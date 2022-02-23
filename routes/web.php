<?php

    use Illuminate\Support\Facades\Route;

    Route::group(['middleware' => 'under-construction'], function () {

// *********************************************************************************************************************
// Front End ===========================================================================================================
// *********************************************************************************************************************
        // Page Routes ===========================================================================================
        Route::get('/',                               'PageController@home')->name('home');
        Route::get('/vancouver',                      'PageController@cityVancouver')->name('home.vancouver');
        Route::get('/los-angeles',                    'PageController@cityLosAngeles')->name('home.los-angeles');
        Route::get('/menu',                           'PageController@menu')->name('menu');
        // Route::get('/shop',                           'PageController@shop')->name('shop');
        // Route::get('/why-vegano',                     'PageController@whyVegano')->name('why-vegano');
        // Route::get('/chefs',                          'PageController@chefs')->name('chefs');
        // Route::get('/community',                      'PageController@community')->name('community');
        // Route::get('/gift-cards',                     'PageController@giftCards')->name('gift-cards');

        // Authentication Routes =================================================================================
        Route::get('login',                            'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login',                           'Auth\LoginController@login');
        Route::post('logout',                          'Auth\LoginController@logout')->name('logout');

        // Password Reset Routes =================================================================================
        Route::post('password/email',                  'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset',                   'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/reset',                  'Auth\ResetPasswordController@reset')->name('password.update');
        Route::get('password/reset/{token}',           'Auth\ResetPasswordController@showResetForm')->name('password.reset');

        // Registration Routes ====================================================================================
        Route::get('sign-up',                          'Auth\RegisterController@showRegistrationForm')->name('sign-up');
        Route::post('sign-up',                         'Auth\RegisterController@register');
        Route::post('coupon-check',                    'Auth\RegisterController@checkCoupon');

        // Terms Routes ===========================================================================================
        Route::get('terms-of-service',                 'PageController@terms')->name('terms-of-service');
        Route::get('privacy-policy',                   'PageController@privacy')->name('privacy-policy');

        // Meals Routes ===========================================================================================
        Route::get('/meals',                           'MealController@indexFront')->name('meals.index');
        Route::get('/meals/{meal}',                      'MealController@showFront')->name('meals.show');

        // Pages ==================================================================================================
        Route::get('/contact-us',                      'PageController@contact')->name('contact-us');
        Route::post('/contact-us',                     'PageController@contactSubmit')->name('contact-us.create');


// *********************************************************************************************************************
// Auth Users Only =====================================================================================================
// *********************************************************************************************************************
        Route::group(['middleware' => 'auth'], function () {
            // Box ================================================================================================
            Route::get('/my-box',                           'BoxController@show')->name('box.show');
            Route::patch('/my-box/replace-meal/{id}',       'BoxController@replace')->name('box.replace');
            Route::patch('/my-box/skip-box/{id}',           'BoxController@skip')->name('box.skip');
            Route::patch('/my-box/unskip-box/{id}',         'BoxController@unskip')->name('box.unskip');

            // My Account =========================================================================================
            // Route::get('/settings',                      'UserController@settings')->name('user.settings');
            Route::get('/my-account',                       'UserController@account')->name('user.account');
            Route::get('/my-account/details/edit',          'UserController@edit')->name('user.account.edit');
            Route::patch('/my-account/details/edit',        'UserController@update')->name('user.account.update');
            Route::get('/my-account/shipping/edit',         'UserShippingController@edit')->name('user.shipping.edit');
            Route::patch('/my-account/shipping/edit',       'UserShippingController@update')->name('user.shipping.update');
            Route::get('/my-account/billing/edit',          'UserBillingController@edit')->name('user.billing.edit');
            Route::patch('/my-account/billing/edit',        'UserBillingController@update')->name('user.billing.update');
            Route::get('/my-account/creditcard/edit',       'UserBillingController@creditcardEdit')->name('user.creditcard.edit');
            Route::patch('/my-account/creditcard/edit',     'UserBillingController@creditcardUpdate')->name('user.creditcard.update');
            Route::patch('/my-account/apply-coupon',        'UserController@applyCoupon')->name('user.apply-coupon');

            Route::patch('/unsubscribe/{id}',               'UserController@unsubscribe')->name('user.unsubscribe');
            Route::patch('/resubscribe/{id}',               'UserController@resubscribe')->name('user.resume-subscription');
            Route::delete('/my-account',                    'UserController@destroy')->name('user.destroy');
        });

// *********************************************************************************************************************
// Admin Users Only ====================================================================================================
// *********************************************************************************************************************
        Route::group(['middleware' => 'admin', 'prefix' => 'admin-dashboard'], function () {

            // DASHBOARD ========================================================================
            Route::get('/',                                 'Admin\AdminController@dashboard')->name('admin.dashboard');

            // MEALS ============================================================================
            Route::get('/meals',                            'MealController@index')->name('admin.meals.index');
            Route::get('/meals/create',                     'MealController@create')->name('admin.meals.create');
            Route::post('/meals',                           'MealController@store')->name('admin.meals.store');
            Route::get('/meals/{id}',                       'MealController@show')->name('admin.meals.show');
            Route::get('/meals/{id}/edit',                  'MealController@edit')->name('admin.meals.edit');
            Route::patch('/meals/{id}',                     'MealController@update')->name('admin.meals.update');
            Route::delete('/meals/delete',                  'MealController@destroy')->name('admin.meals.destroy');

            // PRODUCTS ==========================================================================
            Route::get('/products',                         'ProductController@index')->name('admin.products.index');
            Route::get('/products/create',                  'ProductController@create')->name('admin.products.create');
            Route::post('/products',                        'ProductController@store')->name('admin.products.store');
            Route::get('/products/{id}',                    'ProductController@show')->name('admin.products.show');
            Route::get('/products/{id}/edit',               'ProductController@edit')->name('admin.products.edit');
            Route::patch('/products/{id}',                  'ProductController@update')->name('admin.products.update');
            Route::delete('/products/delete',               'ProductController@destroy')->name('admin.products.destroy');

            // CHEFS ==========================================================================
            Route::get('/chefs',                            'ChefController@index')->name('admin.chefs.index');
            Route::get('/chefs/create',                     'ChefController@create')->name('admin.chefs.create');
            Route::post('/chefs',                           'ChefController@store')->name('admin.chefs.store');
            Route::get('/chefs/{id}',                       'ChefController@show')->name('admin.chefs.show');
            Route::get('/chefs/{id}/edit',                  'ChefController@edit')->name('admin.chefs.edit');
            Route::patch('/chefs/{id}',                     'ChefController@update')->name('admin.chefs.update');
            Route::delete('/chefs/delete',                  'ChefController@destroy')->name('admin.chefs.destroy');

            // ORDERS ==========================================================================
            Route::get('/order',                            'OrderController@index')->name('admin.order.index');
            Route::get('/order/create',                     'OrderController@create')->name('admin.order.create');
            Route::get('/order/prep-station',               'OrderController@prep')->name('admin.order.prep-station');
            Route::post('/order/search',                    'OrderController@search')->name('admin.order.search');
            Route::post('/order',                           'OrderController@store')->name('admin.order.store');
            Route::get('/order/{id}',                       'OrderController@show')->name('admin.order.show');
            Route::get('/order/{id}/edit',                  'OrderController@edit')->name('admin.order.edit');
            Route::patch('/order/{id}',                     'OrderController@update')->name('admin.order.update');
            Route::delete('/order/{id}',                    'OrderController@destroy')->name('admin.order.destroy');

            // USERS ==========================================================================
            Route::get('/users',                            'UserController@index')->name('admin.users.index');
            Route::post('/users/search',                    'UserController@search')->name('admin.users.search');
            Route::get('/users/create',                     'UserController@create')->name('admin.users.create');
            Route::post('/users',                           'UserController@store')->name('admin.users.store');
            Route::get('/users/{id}',                       'UserController@show')->name('admin.users.show');
            Route::get('/users/{id}/edit',                  'UserController@adminEdit')->name('admin.users.edit');
            Route::patch('/users/{id}',                     'UserController@adminUpdate')->name('admin.users.update');
            Route::delete('/users/{id}',                    'UserController@adminDestroy')->name('admin.users.destroy');

            // ADMINS ==========================================================================
            Route::get('/admins',                           'UserController@admin')->name('admin.users.admins');
            Route::get('/admins/create',                    'UserController@createAdmin')->name('admin.users.create-admin');
            Route::post('/admins',                          'UserController@storeAdmin')->name('admin.users.store-admin');
            Route::get('/admins/{id}/edit',                 'UserController@adminEditAdmin')->name('admin.users.edit-admin');
            Route::patch('/admins/{id}',                    'UserController@adminUpdateAdmin')->name('admin.users.update-admin');
            Route::delete('/admins/{id}',                   'UserController@adminDestroyAdmin')->name('admin.users.destroy-admin');

            // IMAGE ============================================================================
            Route::post('/images/create',                   'ImageController@create')->name('admin.images.create');
            Route::delete('/images/{id}',                   'ImageController@destroy')->name('admin.images.destroy');
        });
    });
