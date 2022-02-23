<nav class="main-nav fixed @yield("nav-class") header-primary">
    <div class="country">
        @if(inAmerica())
            <i class="fas fa-flag-usa"></i>
        @else
            <i class="fab fa-canadian-maple-leaf"></i>
        @endif
    </div>

    <div class="container">
        <div class="nav-container">
            <ul class="nav-list desktop">
                <li><a class="nav-item" href="{{ route('menu') }}">{{ __('Menu') }} </a></li>
{{--                <li><a class="nav-item" href="{{ route('shop') }}">{{ __('Shop') }}</a></li>--}}
{{--                <li class="has-children"><a class="nav-item" href="{{ route('why-vegano') }}">{{ __('Why Vegano') }}</a>--}}
{{--                    <ul class="sub-menu">--}}
{{--                        <li><a class="nav-item" href="{{ route('chefs') }}">{{ __('Chefs') }}</a></li>--}}
{{--                        <li><a class="nav-item" href="{{ route('community') }}">{{ __('Community') }}</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
            <a class="nav-brand primary" href="{{ url('/') }}">
                <img class="nav-logo-icon" src="{{ asset('/images/assets/vegan-meal-deliver_vegano-logo-v-2.svg') }}"
                    alt="Vegano Logo Vegan Delivery Service Icon">
                <img class="nav-logo" src="{{ asset('/images/assets/vegan-meal-deliver_vegano-logo.svg') }}"
                    alt="Vegano Logo Vegan Delivery Service">
            </a>
            <ul class="nav-list desktop">
{{--                <li><a class="nav-item" href="{{ route('gift-cards') }}">{{ __('Gift Cards') }}</a></li>--}}
                @guest
                    <li><a class="nav-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-item" href="{{ route('sign-up') }}">{{ __('Sign Up!') }}</a></li>
                @else
                    <li class="has-children">
                        <a class="nav-item" href="#">
                            <i class="fas fa-user-circle"></i> Hi {{ Auth::user()->first_name }}!
                        </a>
                        <ul class="sub-menu fa-ul">
                            @if(Auth::user()->hasRole('admin'))
                            <li>
                                <a class="nav-item" href="{{ route('admin.dashboard') }}">
                                    <span class="fa-li"><i class="fas fa-tachometer-alt"></i></span>{{ __('Admin Dashboard') }}
                                </a>
                            </li>
                            @else
                            <li>
                                <a class="nav-item" data-toggle="modal" data-target="#boxModal" style="cursor:pointer;">
                                    <span class="fa-li"><i class="fas fa-box-open"></i></span>{{ __('My Boxes') }}
                                </a>
                            </li>
                            <li>
                                <a class="nav-item" href="{{ route('user.account') }}">
                                    <span class="fa-li"><i class="fas fa-user"></i></span>{{ __('My Account') }}
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="nav-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    <span class="fa-li"><i class="fas fa-sign-out-alt"></i></span>{{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
            <div class="site-nav-button-container mobile-menu mobile">
                <button id="nav-btn" class="btn btn-nav hamburger hamburger--elastic">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
                </button>
            </div>
        </div>
    </div>
</nav>

{{--Flash Message--}}
@include('flash::message')
