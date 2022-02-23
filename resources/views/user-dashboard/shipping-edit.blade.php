@extends('layouts.app')
@section('title', 'Edit Shipping Details | Vegano')

@section('scripts.header')
    {{--    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">--}}
@stop

@section('content')

    <section id="my-account-splash" class="last-section-background-circle">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header"><h1 class="mb-0">{{ __('Edit Shipping Details') }}</h1></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.shipping.update') }}" id="sign-up-form">
                                @csrf
                                @method("PATCH")

                                @if($errors->any())
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                @endif

                                <div class="form-group">
                                    <label for="shipping_address" class="required">{{ __('Address') }}</label>
                                    <input id="shipping_address" type="text" placeholder="1234 Main St"
                                        class="form-control @error('shipping_address') is-invalid @enderror"
                                        name="shipping_address" value="{{ $shipping->address_line_1 }}"
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
                                            name="shipping_address_2" value="{{ $shipping->address_line_2 }}">
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
                                                disabled="disabled" value="{{ $shipping->city }}"
                                                class="form-control @error('shipping_city') is-invalid @enderror"
                                                name="shipping_city"
                                                required autocomplete="city">
                                        @else
                                            <input id="shipping_city" type="text" placeholder="Vancouver"
                                                disabled="disabled" value="{{ $shipping->city }}"
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
                                    <div class="form-group col-md-5">
                                        @if(inAmerica())
                                            <label for="shipping_state" class="required">{{ __('State') }}</label>
                                            <input id="shipping_state" type="text" placeholder="California"
                                                disabled="disabled" value="{{ $shipping->state }}"
                                                class="form-control @error('shipping_state') is-invalid @enderror"
                                                name="shipping_state"
                                                required autocomplete="state">
                                        @else
                                            <label for="shipping_state" class="required">{{ __('Province') }}</label>
                                            <input id="shipping_state" type="text" placeholder="British Columbia"
                                                disabled="disabled" value="{{ $shipping->state }}"
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
                                    <div class="form-group col-md-5">
                                        <label for="shipping_country">{{ __('Country') }}</label>
                                        @if(inAmerica())
                                            <input id="shipping_country" type="text" placeholder="United States"
                                                disabled="disabled" value="{{ $shipping->country }}"
                                                class="form-control @error('shipping_country') is-invalid @enderror"
                                                name="shipping_country">
                                        @else
                                            <input id="shipping_country" type="text" placeholder="Canada"
                                                disabled="disabled" value="{{ $shipping->country }}"
                                                class="form-control @error('shipping_country') is-invalid @enderror"
                                                name="shipping_country">
                                        @endif
                                        @error('shipping_country')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="shipping_postal_code"
                                            class="required">{{ inAmerica() ? 'Zip Code' : 'Postal Code' }}</label>
                                        <input id="shipping_postal_code" type="text"
                                            class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                            name="shipping_postal_code" value="{{ $shipping->postal_code }}"
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
                                        name="delivery_instructions">{{ $shipping->delivery_instructions }}</textarea>
                                    @error('delivery_instructions')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-accent">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts.footer')

@stop
