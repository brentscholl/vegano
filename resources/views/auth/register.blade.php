@extends('layouts.app')
@section('title', 'Sign Up | Vegano')

@section('scripts.header')
    <script src="https://js.stripe.com/v3/"></script>
@stop

@section('content')
    <sign-up inline-template>
        <div>
            <form method="POST" action="{{ route('sign-up') }}" id="sign-up-form">
                @csrf
                <section id="login-splash" class="last-section-background-circle">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 order-lg-1 order-2">
                                <div class="card">
                                    <div class="card-header"><h1 class="mb-0">{{ __('Sign Up') }}</h1></div>

                                    <div class="card-body">
                                        @if($errors->any())
                                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                                        @endif

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name" class="required">{{ __('First Name') }}</label>

                                                <input id="first_name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    name="first_name" value="{{ old('first_name') }}" required
                                                    autocomplete="first_name" autofocus>

                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="last_name" class="required">{{ __('Last Name') }}</label>

                                                <input id="last_name" type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    name="last_name" value="{{ old('last_name') }}" required
                                                    autocomplete="last_name" autofocus>

                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label for="email" class="required">{{ __('E-Mail Address') }}</label>

                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email"
                                                    value="{{ old('email') }}" required autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="phone_number"
                                                    class="required">{{ __('Phone Number') }}</label>

                                                <input id="phone_number" type="text" placeholder="123-456-7890"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    name="phone_number"
                                                    value="{{ old('phone_number') }}" required
                                                    autocomplete="phone_number">

                                                @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="password" class="required">{{ __('Password') }}</label>

                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password"
                                                    required autocomplete="new-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="password-confirm"
                                                    class="required">{{ __('Confirm Password') }}</label>

                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group mr-auto ml-auto">
                                                <h3 class="mt-2 mb-0">Where would you like us to ship your box?</h3>
                                                <p>
                                                    @if(inAmerica())
                                                        Note: We are only available in Los Angeles, California, USA at
                                                        thistime.
                                                        Please check back for when we will be available in your city.
                                                    @else
                                                        Note: We are only available in Vancouver, British Columbia,
                                                        Canada at
                                                        this time. Please check back for when we will be available in
                                                        your city.
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="shipping_address" class="required">{{ __('Address') }}</label>
                                            <input id="shipping_address" type="text" placeholder="1234 Main St"
                                                class="form-control @error('shipping_address') is-invalid @enderror"
                                                name="shipping_address" value="{{ old('shipping_address') }}"
                                                required autocomplete="address">
                                            @error('shipping_address')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="shipping_address_2">{{ __('Address 2') }}</label>
                                                <input id="shipping_address_2" type="text"
                                                    placeholder="Apartment, studio, or floor"
                                                    class="form-control @error('shipping_address_2') is-invalid @enderror"
                                                    name="shipping_address_2" value="{{ old('shipping_address_2') }}">
                                                @error('shipping_address_2')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="shipping_city" class="required">{{ __('City') }}</label>
                                                @if(inAmerica())
                                                    <input id="shipping_city" type="text" placeholder="Los Angeles"
                                                        disabled="disabled" value="Los Angeles"
                                                        class="form-control @error('shipping_city') is-invalid @enderror"
                                                        name="shipping_city"
                                                        required autocomplete="city">
                                                @else
                                                    <input id="shipping_city" type="text" placeholder="Vancouver"
                                                        disabled="disabled" value="Vancouver"
                                                        class="form-control @error('shipping_city') is-invalid @enderror"
                                                        name="shipping_city"
                                                        required autocomplete="city">
                                                @endif
                                                @error('shipping_city')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-xl-5 col-md-4">
                                                @if(inAmerica())
                                                    <label for="shipping_state"
                                                        class="required">{{ __('State') }}</label>
                                                    <input id="shipping_state" type="text" placeholder="California"
                                                        disabled="disabled" value="California"
                                                        class="form-control @error('shipping_state') is-invalid @enderror"
                                                        name="shipping_state"
                                                        required autocomplete="state">
                                                @else
                                                    <label for="shipping_state"
                                                        class="required">{{ __('Province') }}</label>
                                                    <input id="shipping_state" type="text"
                                                        placeholder="British Columbia"
                                                        disabled="disabled" value="British Columbia"
                                                        class="form-control @error('shipping_state') is-invalid @enderror"
                                                        name="shipping_state"
                                                        required autocomplete="state">
                                                @endif
                                                @error('shipping_province')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-xl-5 col-md-4">
                                                <label for="shipping_country">{{ __('Country') }}</label>
                                                @if(inAmerica())
                                                    <input id="shipping_country" type="text" placeholder="United States"
                                                        disabled="disabled" value="United States"
                                                        class="form-control @error('shipping_country') is-invalid @enderror"
                                                        name="shipping_country">
                                                @else
                                                    <input id="shipping_country" type="text" placeholder="Canada"
                                                        disabled="disabled" value="Canada"
                                                        class="form-control @error('shipping_country') is-invalid @enderror"
                                                        name="shipping_country">
                                                @endif
                                                @error('shipping_country')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-xl-2 col-md-4">
                                                <label for="shipping_postal_code"
                                                    class="required">{{ inAmerica() ? 'Zip Code' : 'Postal Code' }}</label>
                                                <input id="shipping_postal_code" type="text"
                                                    class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                                    name="shipping_postal_code"
                                                    value="{{ old('shipping_postal_code') }}"
                                                    required autocomplete="postal_code">
                                                @error('shipping_postal_code')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="delivery_instructions">{{ __('Delivery Instructions') }}</label>
                                            <textarea id="delivery_instructions" type="text"
                                                class="form-control @error('delivery_instructions') is-invalid @enderror"
                                                name="delivery_instructions">{{ old('delivery_instructions') }}</textarea>
                                            @error('delivery_instructions')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="billing_different"
                                                name="billing_address_different">
                                            <label class="form-check-label" for="billing_different">My shipping address
                                                is
                                                different than my billing address</label>
                                        </div>

                                        <div class="form-row"></div>

                                        <div id="sign-up-billing">
                                            <div class="form-row">
                                                <div class="form-group mr-auto ml-auto">
                                                    <h3 class="mt-2 mb-0">Enter your billing address</h3>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="billing_address">{{ __('Address') }}</label>
                                                <input id="billing_address" type="text" placeholder="1234 Main St"
                                                    class="form-control @error('billing_address') is-invalid @enderror"
                                                    name="billing_address" value="{{ old('billing_address') }}">
                                                @error('billing_address')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="billing_address_2">{{ __('Address 2') }}</label>
                                                    <input id="billing_address_2" type="text"
                                                        placeholder="Apartment, studio, or floor"
                                                        class="form-control @error('billing_address_2') is-invalid @enderror"
                                                        name="billing_address_2" value="{{ old('billing_address_2') }}">
                                                    @error('billing_address_2')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="billing_city">{{ __('City') }}</label>
                                                    <input id="billing_city" type="text"
                                                        class="form-control @error('billing_city') is-invalid @enderror"
                                                        name="billing_city" value="{{ old('billing_city') }}">
                                                    @error('billing_city')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-xl-5 col-md-4">
                                                    <label
                                                        for="billing_state">{{ inAmerica() ? 'State' : 'Province' }}</label>
                                                    <input id="billing_state" type="text"
                                                        class="form-control @error('billing_state') is-invalid @enderror"
                                                        name="billing_state" value="{{ old('billing_state') }}">
                                                    @error('billing_state')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-xl-5 col-md-4">
                                                    <label for="billing_country">{{ __('Country') }}</label>
                                                    <input id="billing_country" type="text"
                                                        class="form-control @error('billing_country') is-invalid @enderror"
                                                        name="billing_country" value="{{ old('billing_country') }}">
                                                    @error('billing_country')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-xl-2 col-md-4">
                                                    <label
                                                        for="billing_postal_code">{{ inAmerica() ? 'Zip Code' : 'Postal Code' }}</label>
                                                    <input id="billing_postal_code" type="text"
                                                        class="form-control @error('billing_postal_code') is-invalid @enderror"
                                                        name="billing_postal_code"
                                                        value="{{ old('billing_postal_code') }}">
                                                    @error('billing_postal_code')
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group form-check mt-2 mb-2">
                                            <input type="checkbox" class="form-check-input" id="terms" name="terms"
                                                required>
                                            <label class="form-check-label" for="terms">I have read and agree to the <a
                                                    href="{{ route('terms-of-service') }}" target="_blank">Terms of
                                                    Service</a>
                                                and <a href="{{ route('privacy-policy') }}" target="_blank">Privacy
                                                    Policy</a></label>
                                        </div>

                                        {{--                                                                <div class="form-group text-center mb-0 mt-1">--}}
                                        {{--                                                                    <button type="submit" id="checkoutButton" class="btn btn-primary"--}}
                                        {{--                                                                            onsubmit="startLoad()">{{ __('Proceed To Checkout') }}</button>--}}
                                        {{--                                                                </div>--}}

                                        <div class="form-row"></div>
                                        @csrf
                                        <div class="form-group">
                                            <h3 class="mt-2 mb-2">Please Enter Your Credit Card Information</h3>
                                            <div id="card-element">
                                                <!-- A Stripe Element will be inserted here. -->
                                            </div>
                                            <!-- Used to display form errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                        <div class="form-group text-center mb-0 mt-2">
                                            <button id="pay-button" class="btn btn-primary"
                                                data-secret="{{ $intent->client_secret }}" type="button">Sign Up and Pay
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <h5 class="mb-1">Are You Already a Customer?</h5>
                                        <a href="{{ route('login') }}" class="btn btn-link">Login</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 order-lg-2 order-1">
                                <div class="sign-up-plan-card">
                                    <div class="card-header">
                                        <img src="{{ asset('images/assets/vegan-meal-deliver_one-month.png') }}"
                                            alt="Vegano Sign Up Plan">
                                    </div>

                                    <div class="card-body">
                                        <div class="plan-description-container">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="mb-1">1 Week Subscription</h4>
                                                    <p class="mb-0">Sign up for a weekly subscription that contains 3
                                                        meals per
                                                        week.</p>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="price">
                                                        @if(inAmerica())
                                                            <small>USD</small>${{ config('company.standard-subscription-price-usa') }}
                                                        @else
                                                            <small>CAD</small>${{ config('company.standard-subscription-price') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="plan-pricing-container">
                                            <div class="form-group row">
                                                <label class="col">Shipping:</label>
                                                <div class="col text-right">
                                                    <div class="price">FREE</div>
                                                </div>
                                            </div>
{{--                                            <div class="form-group row">--}}
{{--                                                <label class="col">Sales Tax: <i class="fa fa-info-circle"></i></label>--}}
{{--                                                <div class="col text-right">--}}
{{--                                                    <div class="price"></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <transition name="fade">
                                            <div class="form-group mb-0" v-if="!form.valid">
                                                <label
                                                    for="discount_code">{{ __('Apply Gift Card or Promo Code') }}</label>

                                                <div class="input-group">
                                                    <input id="discount_code" type="text" v-model="form.coupon_code"
                                                        class="form-control @error('discount_code') is-invalid @enderror"
                                                        name="discount_code">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary discount-button" @click="onSubmit">
                                                            Apply
                                                        </button>
                                                    </div>
                                                    <span v-if="form.error" class="text-danger">Invalid Coupon Code. Try again.</span>
                                                </div>
                                                @error('discount_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-0" v-else>
                                                <h4 class="mb-1">Coupon Applied!</h4>
                                                <p>You will be subscribed to a free <span class="week-discount-label">@{{ form.weeks }}</span> week subscription!</p>
                                            </div>
                                            </transition>
                                        </div>
                                        <input type="hidden" v-model="form.coupon_code" name="coupon_code">

                                        <div class="plan-total-container">
                                            <div class="form-group row">
                                                <div class="col">
                                                    <h4>Total for your box:</h4>
                                                </div>
                                                <div class="col-auto text-right">
                                                    <div class="price">
                                                        @if(inAmerica())
                                                            <small>USD</small>$@{{ form.price }}
                                                        @else
                                                            <small>CAD</small>$@{{ form.price }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </sign-up>

@endsection

@section('scripts.vue-variables')
    @if(inAmerica())
        <script>
            var price = {!! config('company.standard-subscription-price-usa') !!};
        </script>
    @else
        <script>
            var price = {!! config('company.standard-subscription-price') !!};
        </script>
    @endif

@stop

@section('scripts.footer')
    <script>
        $(document).ready(function () {
            // Create a Stripe client.
            var stripe = Stripe('{{ env("STRIPE_KEY") }}');

// Create an instance of Elements.
            var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#2b2e34',
                    lineHeight: '20px',
                    fontFamily: '"Gotham Light", sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '18px',
                    '::placeholder': {
                        color: '#91A499'
                    }
                },
                invalid: {
                    color: '#bb2011',
                    iconColor: '#bb2011'
                }
            };

// Create an instance of the card Element.
            var card = elements.create('card', {style: style, hidePostalCode: true});

// Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

// Handle real-time validation errors from the card Element.
            card.on('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

// Handle form submission.
            const payButton = document.getElementById('pay-button');
            const clientSecret = payButton.dataset.secret;
            var form = document.getElementById('sign-up-form');
            payButton.addEventListener('click', async (e) => {
                const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: card
                        }
                    }
                );
                if (error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(setupIntent.payment_method);
                }
            });

// Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('sign-up-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }

            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            var billingAddressSection = $('#sign-up-billing');
            var billingDifferent = $('#billing_different');

            billingDifferent.click(function () {
                if ($(this).is(':checked')) {
                    billingAddressSection.slideDown();
                } else {
                    billingAddressSection.slideUp();
                }
            });

        });
    </script>
@stop

