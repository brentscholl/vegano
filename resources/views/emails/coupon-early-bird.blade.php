@component('mail::message')
## Welcome, {{ $coupon['first_name'] }}! Thank you for choosing Vegano!

We are very excited to welcome you to the new digital home of your favourite vegan meal delivery service!

If you are receiving this email, you pre-ordered a Vegano subscription. Please use the following unique code on the Sign Up page in order to redeem your subscription.

## {{ $coupon['token'] }}

You are redeeming  your {{ $coupon['amount'] }} week subscription.

Let’s get started!

@component('mail::button', ['url' => route('sign-up')])
    Sign Up
@endcomponent

The Vegano Team

@endcomponent
