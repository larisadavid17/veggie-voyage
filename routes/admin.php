<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ReservationTimeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin', 'as' => 'admin.'], function(){

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /** Profile Routes */
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');



    /**Slider */
    Route::resource('slider', SliderController::class);

    /** Daily Offer Routes */
    Route::get('daily-offer/search-product', [DailyOfferController::class, 'productSearch'])->name('daily-offer.search-product');
    Route::put('daily-offer-title-update', [DailyOfferController::class, 'updateTitle'])->name('daily-offer-title-update');
    Route::resource('daily-offer', DailyOfferController::class);

     /**Whyus */
     Route::put('why-choose-title-update', [WhyChooseUsController::class,'updateTitle'])->name('why-choose-title.update');
     Route::resource('why-choose-us', WhyChooseUsController::class);

        /** Testimonial Routes */
    Route::put('testimonial-title-update', [TestimonialController::class, 'updateTitle'])->name('testimonial-title-update');
    Route::resource('testimonial', TestimonialController::class);

     /** Counter Routes */
     Route::get('counter', [CounterController::class, 'index'])->name('counter.index');
     Route::put('counter', [CounterController::class, 'update'])->name('counter.update');

/** About Routes */
Route::get('about', [AboutController::class, 'index'])->name('about.index');
Route::put('about', [AboutController::class, 'update'])->name('about.update');
/** Contact Routes */
Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
Route::put('contact', [ContactController::class, 'update'])->name('contact.update');
 /** Reservation Routes */
 Route::resource('reservation-time', ReservationTimeController::class);
 Route::get('reservation', [ReservationController::class, 'index'])->name('reservation.index');
 Route::post('reservation', [ReservationController::class, 'update'])->name('reservation.update');
 Route::delete('reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');



     /**Product Category */
     Route::resource('category', CategoryController::class);

     /**Product Routes */
     Route::resource('product', ProductController::class);

     /**Product Gallery Routes */
     Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
     Route::resource('product-gallery', ProductGalleryController::class);

       /**Product Size Routes */
       Route::get('product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size.show-index');
       Route::resource('product-size', ProductSizeController::class);

       /**Product Options Routes */
       Route::resource('product-option', ProductOptionController::class);

       /** Product Reviews Routes */
    Route::get('product-reviews', [ProductReviewController::class, 'index'])->name('product-reviews.index');
    Route::post('product-reviews', [ProductReviewController::class, 'updateStatus'])->name('product-reviews.update');
    Route::delete('product-reviews/{id}', [ProductReviewController::class, 'destroy'])->name('product-reviews.destroy');


    /** Coupon Routes */
    Route::resource('coupon', CouponController::class);

    /** Delivery Area Routes */
    Route::resource('delivery-area', DeliveryAreaController::class);

       /**Payment Routes */
       Route::get('/payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-setting.index');
       Route::put('/stripe-setting', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe-setting.update');
        /**Seetings Routes */
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');

   /** Order Routes */
   Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
   Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
   Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

   Route::get('pending-orders', [OrderController::class, 'pendingOrderIndex'])->name('pending-orders');
   Route::get('inprocess-orders', [OrderController::class, 'inProcessOrderIndex'])->name('inprocess-orders');
   Route::get('delivered-orders', [OrderController::class, 'deliveredOrderIndex'])->name('delivered-orders');
   Route::get('declined-orders', [OrderController::class, 'declinedOrderIndex'])->name('declined-orders');

   Route::get('orders/status/{id}', [OrderController::class, 'getOrderStatus'])->name('orders.status');
   Route::put('orders/status-update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('orders.status-update');

});
