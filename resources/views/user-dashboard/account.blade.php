@extends('layouts.app')
@section('title', 'My Account | Vegano')

@section('scripts.header')
    {{--    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">--}}
@stop

@section('content')

    <section id="my-account-splash" class="last-section-background-circle">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1 class="mb-4">My Account</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col" class="title">Personal Details</th>
                            <th scope="col" class="edit text-right"><a href="{{ route('user.account.edit') }}" class="btn btn-accent">Edit</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="label">First Name</td>
                            <td class="">{{ $user->first_name }}</td>
                        </tr>
                        <tr>
                            <td class="label">Last Name</td>
                            <td class="">{{ $user->last_name }}</td>
                        </tr>
                        <tr>
                            <td class="label">Email Address</td>
                            <td class="">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="label">Phone Number</td>
                            <td class="">{{ $user->phone_number }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col" class="title">Shipping Details</th>
                            <th scope="col" class="edit text-right"><a href="{{ route('user.shipping.edit') }}" class="btn btn-accent">Edit</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="label">Address</td>
                            <td class="">{{ $shipping->address_line_1 }}</td>
                        </tr>
                        <tr>
                            <td class="label">Address Line 2</td>
                            <td class="">{{ $shipping->address_line_2 }}</td>
                        </tr>
                        <tr>
                            <td class="label">City</td>
                            <td class="">{{ $shipping->city }}</td>
                        </tr>
                        <tr>
                            @if(inAmerica())
                                <td class="label">State</td>
                            @else
                                <td class="label">Province</td>
                            @endif
                            <td class="">{{ $shipping->state }}</td>
                        </tr>
                        <tr>
                            <td class="label">Country</td>
                            <td class="">{{ $shipping->country }}</td>
                        </tr>
                        <tr>
                            @if(inAmerica())
                                <td class="label">Zip Code</td>
                            @else
                                <td class="label">Postal Code</td>
                            @endif
                            <td class="">{{ $shipping->postal_code }}</td>
                        </tr>
                        <tr>
                            <td class="label">Delivery Instructions</td>
                            <td class="">{{ $shipping->delivery_instructions }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col" class="title">Billing Details</th>
                            <th scope="col" class="edit text-right"><a href="{{ route('user.billing.edit') }}" class="btn btn-accent">Edit</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="label">Address</td>
                            <td class="">{{ $billing->address_line_1 }}</td>
                        </tr>
                        <tr>
                            <td class="label">Address Line 2</td>
                            <td class="">{{ $billing->address_line_2 }}</td>
                        </tr>
                        <tr>
                            <td class="label">City</td>
                            <td class="">{{ $billing->city }}</td>
                        </tr>
                        <tr>
                            @if(inAmerica())
                                <td class="label">State</td>
                            @else
                                <td class="label">Province</td>
                            @endif
                            <td class="">{{ $billing->state }}</td>
                        </tr>
                        <tr>
                            <td class="label">Country</td>
                            <td class="">{{ $billing->country }}</td>
                        </tr>
                        <tr>
                            @if(inAmerica())
                                <td class="label">Zip Code</td>
                            @else
                                <td class="label">Postal Code</td>
                            @endif
                            <td class="">{{ $billing->postal_code }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col" class="title">Subscription</th>
                            <th scope="col" class="edit text-right"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="label">Your Plan</td>
                            <td class="">
                                @if($user->subscribed('standard'))
                                    @if($user->paid_subscription_start_date)
                                        <span class="tag standard-tag">COUPON APPLIED! Weekly subscription that contains 3 meals for $0/week. Coupon expires on {{ $user->paid_subscription_start_date->addDays(-1)->format('M d, Y') }}</span>
                                    @else
                                        @if(! $user->subscription('standard')->onGracePeriod())
                                            <span class="tag standard-tag">Weekly subscription that contains 3 meals for ${!! inAmerica() ? config('company.standard-subscription-price-usa') . '<small>USD</small>' : config('company.standard-subscription-price') . '<small>CAD</small>' !!}/week.</span>
                                        @elseif($user->subscription('standard')->onGracePeriod())
                                            <span class="tag standard-tag">Weekly subscription that contains 3 meals (Ending: {{ $user->subscription('standard')->ends_at->toFormattedDateString() }})</span>
                                        @endif
                                    @endif
                                @elseif($user->hasRole('admin'))
                                    <span class="tag admin-tag">ADMIN</span>
                                @else
                                    <span class="tag standard-tag">NOT SUBSCRIBED</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Next Bill Date</td>
                            @if($user->subscribed('standard'))
                                @if(! $user->subscription('standard')->onGracePeriod())
                                    <td class="">{{ getSubscriptionRenewDate('standard') }}</td>
                                @elseif($user->subscription('standard')->onGracePeriod())
                                    <td class="">--</td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td class="label">Apply Coupon</td>
                            <td>
                                <form action="{{ route('user.apply-coupon') }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <input id="coupon_code" type="text" placeholder="Enter Coupon Code"
                                            class="form-control @error('coupon_code') is-invalid @enderror"
                                            name="coupon_code">
                                        @error('coupon_code')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Apply
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Credit Card</td>
                            <td class="edit">XXXX XXXX XXXX {{ $user->card_last_four }} <a href="{{ route('user.creditcard.edit') }}" class="btn btn-accent ml-1">Update Credit Card</a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="destroy-buttons">
                        @if($user->subscribed('standard'))
                            @if(! $user->subscription('standard')->onGracePeriod())
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#cancelSubscriptionModal">Cancel Subscription</button>
                            @elseif($user->subscription('standard')->onGracePeriod() || ! $user->subscribed('standard'))
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#resumeSubscriptionModal">Resume Subscription</button>
                            @endif
                        @endif

                                | <button type="button" class="btn btn-link" data-toggle="modal" data-target="#deleteAccountModal">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('modals')
    @include('components.cancel-subscription-modal')
    @include('components.resume-subscription-modal')
    @include('components.delete-account-modal')
@stop

@section('scripts.footer')

@stop
