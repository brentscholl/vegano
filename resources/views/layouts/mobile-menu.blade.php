<nav class="mobile-menu-panel mobile" id="mobile-menu-slide">
    <div id="site-navigation">
        <div id="site-menu" class="text-center" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
            <ul class="nav-list">
                <li><a class="nav-item" href="{{ route('menu') }}">{{ __('Menu') }} </a></li>
                {{--                <li><a class="nav-item" href="{{ route('shop') }}">{{ __('Shop') }}</a></li>--}}
                {{--                <li class="has-children"><a class="nav-item" href="{{ route('why-vegano') }}">{{ __('Why Vegano') }}</a>--}}
                {{--                    <ul class="sub-menu">--}}
                {{--                        <li><a class="nav-item" href="{{ route('chefs') }}">{{ __('Chefs') }}</a></li>--}}
                {{--                        <li><a class="nav-item" href="{{ route('community') }}">{{ __('Community') }}</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li><a class="nav-item" href="{{ route('gift-cards') }}">{{ __('Gift Cards') }}</a></li>--}}
                @guest
                    <li><a class="nav-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-item" href="{{ route('sign-up') }}">{{ __('Sign Up!') }}</a></li>
                @else
                    @if(Auth::user()->hasRole('admin'))
                        <li>
                            <a class="nav-item" href="{{ route('admin.dashboard') }}">
                                {{ __('Admin Dashboard') }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="nav-item" data-toggle="modal" data-target="#boxModal" style="cursor:pointer;">
                                {{ __('My Boxes') }}
                            </a>
                        </li>
                        <li>
                            <a class="nav-item" href="{{ route('user.account') }}">
                                {{ __('My Account') }}
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="nav-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
