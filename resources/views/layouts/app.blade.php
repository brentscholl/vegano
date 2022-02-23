@include('layouts.header')
@yield('modals')
@include('layouts.nav')
@include('layouts.mobile-menu')
    <div id="app">
        @yield('content')

        @if(Auth::user() && ! Auth::user()->isAdmin())
            <button type="button" class="footer-box-btn btn" @click="$modal.show('show-box')" data-toggle="modal" data-target="#boxModal"><i class="fas fa-box-open"></i><span>View my boxes</span></button>
            @include('components.box-modal')
        @endif
    </div>
@yield('scripts.vue-variables')
@include('layouts.footer')
