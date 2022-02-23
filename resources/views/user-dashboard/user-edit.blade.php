@extends('layouts.app')
@section('title', 'Edit Personal Details | Vegano')

@section('scripts.header')
    {{--    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">--}}
@stop

@section('content')

    <section id="my-account-splash" class="last-section-background-circle">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header"><h1 class="mb-0">{{ __('Edit Personal Details') }}</h1></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.account.update') }}" id="sign-up-form">
                                @csrf
                                @method("PATCH")

                                @if($errors->any())
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                @endif

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name" class="required">{{ __('First Name') }}</label>

                                        <input id="first_name" type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ Auth::user()->first_name }}" required
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
                                            name="last_name" value="{{ Auth::user()->last_name }}" required
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
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ Auth::user()->email }}" required autocomplete="email">

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
                                            value="{{ Auth::user()->phone_number }}" required autocomplete="phone_number">

                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            {{ __('Change Your Password?') }}
                                        </a>
                                    @endif
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
