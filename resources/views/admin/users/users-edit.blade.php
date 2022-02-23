@extends('admin.layouts.app', ['page' => 'users'])
@section('title')
    Edit User | {{ $user->first_name }} {{ $user->last_name }}
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit: {{ $user->first_name }} {{ $user->last_name }}</h1>
        <div>
            <a href="{{ route('admin.users.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">View All Users</a>
        </div>
    </div>

    <!-- Default Card Example -->

    <form id="edit-user-form" action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Details
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="first_name" class="required">{{ __('First Name') }}</label>

                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" value="{{ $user->first_name }}" required>

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
                                    name="last_name" value="{{ $user->last_name }}" required>

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
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $user->email }}" required>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone_number" class="required">{{ __('Phone Number') }}</label>

                                <input id="phone_number" type="text" placeholder="123-456-7890"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    name="phone_number"
                                    value="{{ $user->phone_number }}" required>

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        Shipping
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="shipping_address" class="required">{{ __('Address') }}</label>
                            <input id="shipping_address" type="text" placeholder="1234 Main St"
                                class="form-control @error('shipping_address') is-invalid @enderror"
                                name="shipping_address" value="{{ $user->shipping->address_line_1 }}"
                                required>
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
                                    name="shipping_address_2" value="{{ $user->shipping->address_line_2 }}">
                                @error('shipping_address_2')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="shipping_city" class="required">{{ __('City') }}</label>
                                <input id="shipping_city" type="text" placeholder="Los Angeles"
                                    value="{{ $user->shipping->city }}"
                                    class="form-control @error('shipping_city') is-invalid @enderror"
                                    name="shipping_city"
                                    required>
                                @error('shipping_city')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="shipping_state" class="required">{{ __('Province') }}</label>
                                <input id="shipping_state" type="text" placeholder="British Columbia"
                                    value="{{ $user->shipping->state }}"
                                    class="form-control @error('shipping_state') is-invalid @enderror"
                                    name="shipping_state"
                                    required>
                                @error('shipping_province')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label for="shipping_country">{{ __('Country') }}</label>
                                <input id="shipping_country" type="text" placeholder="Canada"
                                    value="{{ $user->shipping->country }}"
                                    class="form-control @error('shipping_country') is-invalid @enderror"
                                    name="shipping_country">
                                @error('shipping_country')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="shipping_postal_code"
                                    class="required">Postal Code</label>
                                <input id="shipping_postal_code" type="text"
                                    class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                    name="shipping_postal_code" value="{{ $user->shipping->postal_code }}"
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
                                name="delivery_instructions">{{ $user->shipping->delivery_instructions }}</textarea>
                            @error('delivery_instructions')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        Billing
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="billing_address">{{ __('Address') }}</label>
                            <input id="billing_address" type="text" placeholder="1234 Main St"
                                class="form-control @error('billing_address') is-invalid @enderror"
                                name="billing_address" value="{{ $user->billing->address_line_1 }}">
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
                                    name="billing_address_2" value="{{ $user->billing->address_line_2 }}">
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
                                    name="billing_city" value="{{ $user->billing->city }}">
                                @error('billing_city')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="billing_state">Province</label>
                                <input id="billing_state" type="text"
                                    class="form-control @error('billing_state') is-invalid @enderror"
                                    name="billing_state" value="{{ $user->billing->state }}">
                                @error('billing_state')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label for="billing_country">{{ __('Country') }}</label>
                                <input id="billing_country" type="text"
                                    class="form-control @error('billing_country') is-invalid @enderror"
                                    name="billing_country" value="{{ $user->billing->country }}">
                                @error('billing_country')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label
                                    for="billing_postal_code">Postal Code</label>
                                <input id="billing_postal_code" type="text"
                                    class="form-control @error('billing_postal_code') is-invalid @enderror"
                                    name="billing_postal_code" value="{{ $user->billing->postal_code }}">
                                @error('billing_postal_code')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@section('scripts.footer')

@stop
