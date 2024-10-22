<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    function index(): View
    {
        if (!session()->has('delivery_fee') || !session()->has('address')) {
            throw ValidationException::withMessages(['Something went wrong']);
        }

        $subtotal = cartTotal();
        $delivery = session()->get('delivery_fee') ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $grandTotal = grandCartTotal($delivery);
        return view('frontend.pages.payment', compact( 'subtotal', 'delivery','discount', 'grandTotal' ));
    }

    function paymentSuccess() : View {
        return view('frontend.pages.payment-success');
    }

    function paymentCancel() : View {
        return view('frontend.pages.payment-cancel');
    }

    function makePayment(Request $request, OrderService $orderService)  {
        $request->validate([
            'payment_gateway' => ['required', 'string', 'in:stripe']
        ]);

         /** Create Order */
         if ($orderService->createOrder()) {
            // redirect user to the payment host
            switch ($request->payment_gateway) {
                case 'stripe':

                    return response(['redirect_url' => route('stripe.payment')]);
                    break;

                    default:
                       break;
            }
        }
    }

      /** Stripe Payment */

      function payWithStripe() {
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));

        /** calculate payable amount */
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.stripe_rate')) * 100;
        $response = StripeSession::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => config('gatewaySettings.stripe_currency'),
                        'product_data' => [
                            'name' => 'Product'
                        ],
                        'unit_amount' => $payableAmount
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel')
        ]);

        return redirect()->away($response->url);

    }
    function stripeSuccess(Request $request, OrderService $orderService) {
        $sessionId = $request->session_id;
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));

        $response = StripeSession::retrieve($sessionId);
        if($response->payment_status === 'paid') {

            $orderId = session()->get('order_id');
            $paymentInfo = [
                'transaction_id' => $response->payment_intent,
                'currency' => $response->currency,
                'status' => 'completed'
            ];
            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');
            OrderPlacedNotificationEvent::dispatch($orderId);

             /** Clear session data */
             $orderService->clearSession();

             return redirect()->route('payment.success');
         }else {
             $this->transactionFailUpdateStatus('Stripe');
             return redirect()->route('payment.cancel');
         }
     }
     function stripeCancel() {
        $this->transactionFailUpdateStatus('Stripe');
        return redirect()->route('payment.cancel');
    }
    function transactionFailUpdateStatus($gatewayName) : void {
        $orderId = session()->get('order_id');
        $paymentInfo = [
            'transaction_id' => '',
            'currency' => '',
            'status' => 'Failed'
        ];

        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    }

}
