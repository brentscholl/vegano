@extends('layouts.app')
@section('title', 'Edit Billing Details | Vegano')

@section('scripts.header')
    {{--    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">--}}
@stop

@section('content')

    <section id="my-account-splash" class="last-section-background-circle">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header"><h1 class="mb-0">{{ __('Edit Billing Details') }}</h1></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.billing.update') }}" id="sign-up-form">
                                @csrf
                                @method("PATCH")

                                @if($errors->any())
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                @endif

                                <div class="form-group">
                                    <label for="billing_address" class="required">{{ __('Address') }}</label>
                                    <input id="billing_address" type="text" placeholder="1234 Main St"
                                        class="form-control @error('billing_address') is-invalid @enderror"
                                        name="billing_address" value="{{ $billing->address_line_1 }}"
                                        required autocomplete="address">
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
                                            name="billing_address_2" value="{{ $billing->address_line_2 }}">
                                        @error('billing_address_2')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="billing_city" class="required">{{ __('City') }}</label>
                                            <input id="billing_city" type="text"
                                                value="{{ $billing->city }}"
                                                class="form-control @error('billing_city') is-invalid @enderror"
                                                name="billing_city"
                                                required autocomplete="city">
                                        @error('billing_city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="billing_state" class="required">{{ __('Province') }}</label>
                                        <input id="billing_state" type="text"
                                            value="{{ $billing->state }}"
                                            class="form-control @error('billing_state') is-invalid @enderror"
                                            name="billing_state"
                                            required autocomplete="state">
                                        @error('billing_province')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="billing_country">{{ __('Country') }}</label>
                                        <input id="billing_country" type="text"
                                            value="{{ $billing->country }}"
                                            class="form-control @error('billing_country') is-invalid @enderror"
                                            name="billing_country">
                                        @error('billing_country')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="billing_postal_code"
                                            class="required">{{ inAmerica() ? 'Zip Code' : 'Postal Code' }}</label>
                                        <input id="billing_postal_code" type="text"
                                            class="form-control @error('billing_postal_code') is-invalid @enderror"
                                            name="billing_postal_code" value="{{ $billing->postal_code }}"
                                            required autocomplete="postal_code">
                                        @error('billing_postal_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
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
