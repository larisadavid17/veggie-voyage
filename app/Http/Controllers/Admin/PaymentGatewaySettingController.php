<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentGatewaySettingController extends Controller
{
    use FileUploadTrait;

    function index() : View {
        $paymentGateway = PaymentGatewaySetting::pluck('value', 'key');
        return view('admin.payment-setting.index', compact('paymentGateway'));
    }

    function stripeSettingUpdate(Request $request)  {
        $validatedData = $request->validate([
            'stripe_status' => ['required', 'boolean'],
            'stripe_country' => ['required'],
            'stripe_currency' => ['required'],
            'stripe_rate' => ['required', 'numeric'],
            'stripe_api_key' => ['required'],
            'stripe_secret_key' => ['required'],
        ]);


        if($request->hasFile('stripe_logo')){
            $request->validate([
                'stripe_logo' => ['nullable', 'image']
            ]);

            $imagePath = $this->uploadImage($request, 'stripe_logo');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'stripe_logo'],
                ['value' => $imagePath]
            );
        }

        foreach($validatedData as $key => $value){
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Successfully!');
        return redirect()->back();
    }

}
