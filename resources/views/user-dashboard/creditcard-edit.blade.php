@extends('layouts.app')
@section('title', 'Edit Credit Card | Vegano')

@section('scripts.header')
    <script src="https://js.stripe.com/v3/"></script>
@stop

@section('content')

    <section id="my-account-splash" class="last-section-background-circle">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header"><h1 class="mb-0">{{ __('Edit Credit Card') }}</h1></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.creditcard.update') }}" id="sign-up-form">
                                @csrf
                                @method("PATCH")

                                @if($errors->any())
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                @endif
                                <p>
                                    Want to update the credit card that we have on file? Provide the new details here.
                                    Your card information will never directly touch our servers. We use <a
                                        href="https://www.stripe.com">Stripe</a> to encrypt your card and keep it secure.
                                </p>

                                <p>Current credit card: <strong>&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; {{ Auth::user()->card_last_four }}</strong></p>

                                <div class="form-group">
                                    <h3 class="mt-2 mb-2">Please Enter Your New Credit Card Information</h3>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                </div>

                                <div class="form-group">
                                    <button id="pay-button" class="btn btn-accent mt-2"
                                        data-secret="{{ $intent->client_secret }}" type="button">Update</button>
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
                    color: '#231F20',
                    lineHeight: '20px',
                    fontFamily: '"SF Light", sans-serif',
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
                const { setupIntent, error } = await stripe.confirmCardSetup(
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
        });
    </script>
@stop
