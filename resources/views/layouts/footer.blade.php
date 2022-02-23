<footer class="animation-element">
    <div class="container">
        <div class="footer-upper">
            <div class="row align-items-center justify-content-center">
                <div class="col-auto">
                    <a href="{{ route('home') }}">
                        <img class="footer-logo zoom-in" src="{{ asset('/images/assets/vegan-meal-deliver_icon_vegano.svg') }}" alt="Vegano Vegan Meal Delivery Vancouver Footer Logo">
                    </a>
                </div>
                <div class="col-sm col-auto">
                    <ul class="footer-nav">
                        <li class="fade-in animation-delay-2"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                        <li class="fade-in animation-delay-3"><a href="{{ route('terms-of-service') }}">Terms of Service</a></li>
                        <li class="fade-in animation-delay-4"><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
                        @guest
                <div class="col-sm col-auto">
                    <ul class="footer-nav">
                        <li class="fade-in animation-delay-2"><a href="{{ route('home.vancouver') }}">Available in:</a></li>
                        <li class="fade-in animation-delay-3"><a href="{{ route('home.vancouver') }}">Vancouver</a></li>
                        <li class="fade-in animation-delay-4"><a href="{{ route('home.los-angeles') }}">Los Angeles</a></li>
                    </ul>
                </div>
                        @endguest
                <div class="col-md col-12">
{{--                    <ul class="social-list">--}}
{{--                        <li class="zoom-in animation-delay-5"><a href="#"><i class="fab fa-facebook"></i></a></li>--}}
{{--                        <li class="zoom-in animation-delay-6"><a href="#"><i class="fab fa-instagram"></i></a></li>--}}
{{--                        <li class="zoom-in animation-delay-7"><a href="#"><i class="fab fa-pinterest"></i></a></li>--}}
{{--                    </ul>--}}
                </div>
            </div>
        </div>
        <div class="footer-lower fade-in animation-delay-10">
            <div class="row align-items-center">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="copyright">
                        Copyright &copy; <?php echo date('Y'); ?> Vegano Foods Inc. &bull; All Rights Reserved.
                    </div>
                </div>
                <div class="col-md-2 stealth-logo-col">
                </div>
            </div>
        </div>
    </div>
</footer>
@yield('footer-nav')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/slideout.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@yield('scripts.footer')
</body>
</html>
