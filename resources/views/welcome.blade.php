@extends('layouts.app')
@section('title', 'Vegano')

@section('scripts.header')
@stop


@section('content')

    <section id="landing-splash" class="animation-element">
        <div class="landing-slider-container desktop">
            @include('rotating-slider.rotating-slider', ['meals' => $sliderMeals])
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6">
                    <h2 class="h1 slide-in-right">Rooting yourself in a {{ $city == 'Los Angeles' ? 'vegan' : 'plant-based' }} lifestyle has never been easier.</h2>
                    <h1 class="p slide-in-right animation-delay-1">Make meal prep easy and every night delicious with chef-crafted {{ $city == 'Los Angeles' ? 'plant-based' : 'vegan' }} meal delivery{{ $city ? ' in ' . $city : '' }}.</h1>
                    <a href="{{ route('sign-up') }}" class="btn btn-primary btn-lg slide-in-right animation-delay-2">Create My Box</a>
                </div>
            </div>
        </div>
    </section>

    <div class="animation-element">
        <section id="landing-featured-bowls-title">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <h2 class="h1 slide-in-right">Discover the Easy Way to Enjoy Vegan Every Day.</h2>
                        <p class="slide-in-right animation-delay-1">Our recipes are handcrafted by a community of top
                            chefs and infused with delicious, organic ingredients grown and sourced locally{{ $city ? ' in ' . $city : '' }}. Mix and match
                            your favourites to create the perfect food system, delivered right to your door.
                            Vegan meal prep{{ $city ? ' in ' . $city : '' }} will fit right into any busy schedule with Vegano!</p>
                        <a href="{{ route('meals.index') }}" class="btn btn-primary btn-lg slide-in-right animation-delay-2">See All Recipes</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="landing-featured-bowls">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach($featuredMeals as $meal)
                        @if($loop->iteration <= 3)
                            <div class="col-md-4 col-sm-6 featured-meal-col zoom-in animation-delay-{{ $loop->iteration * 2 }}">
                                @include('components.featured-meal-item', ['meal' => $meal])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <div class="last-section-background-circle">
    <section id="landing-how-we-work">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 nav-col">
                    <div class="nav flex-column nav-pills how-we-work-nav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home"
                            role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <div class="step"><span>Step</span>1</div>
                            <div class="step-icon"><img class="icon"
                                    src="{{ asset("/images/assets/vegan-meal-deliver_icon_how-we-work-1.svg") }}"
                                    alt="How Vegano Works Order Online"></div>
                            <div class="step-description">
                                <h4>Order Online</h4>
                                <p>Choose your recipes and delivery schedule with a few easy clicks.</p>
                            </div>
                        </a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                            role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            <div class="step"><span>Step</span>2</div>
                            <div class="step-icon"><img class="icon"
                                    src="{{ asset("/images/assets/vegan-meal-deliver_icon_how-we-work-2.svg") }}"
                                    alt="How Vegano Works Get Your Box"></div>
                            <div class="step-description">
                                <h4>Get Your Box</h4>
                                <p>Receive a speedy delivery of locally sourced, super fresh ingredients.</p>
                            </div>
                        </a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                            role="tab" aria-controls="v-pills-messages" aria-selected="false">
                            <div class="step"><span>Step</span>3</div>
                            <div class="step-icon"><img class="icon"
                                    src="{{ asset("/images/assets/vegan-meal-deliver_icon_how-we-work-3.svg") }}"
                                    alt="How Vegano Works Prep & Eat"></div>
                            <div class="step-description">
                                <h4>Prep & Eat</h4>
                                <p>Create your vegan culinary masterpiece in under 20 minutes, and enjoy! </p>
                            </div>
                        </a>
                    </div>
                    <div class="how-we-work-nav-footer">
                        <h4>...and then repeat.</h4>
                        <a href="{{ route('sign-up') }}" class="btn btn-primary">Get My Box</a>
                    </div>
                </div>
                <div class="col-md-6 content-col desktop">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            @include('components.featured-meal-item')
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">
                            <img src="{{ asset('/images/assets/vegan-meal-deliver_How-We-Work_step2_box.jpg') }}" alt="Vegano Vegan Meal Delivery Step 2">
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab">
                            <img src="{{ asset('/images/assets/vegan-meal-deliver_How-We-Work_step3_BimBimBap_plate.jpg') }}" alt="Vegano Vegan Meal Delivery Step 3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="landing-shout">
        <div class="container">
            <div class="mission">
                <h3>Discover the convenience of vegan food delivery{{ $city ? ' in ' . $city : '' }} with Vegano.</h3>
            </div>
            <div class="scroll-text-container">
                <div class="hundred">
                    100%
                </div>
                <div class="scroll-text">
                    <span>Simple</span>
                    <span>Delicious</span>
                    <span>Vegan</span>
                    <span>Organic</span>
                </div>
                <div class="top-cover"></div>
                <div class="bottom-cover"></div>
            </div>
        </div>
    </section>
    </div>

{{--    <section id="landing-about" class="last-section-background-circle">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-4 text-center">--}}
{{--                    <a href="#" class="about-item-container" id="meet-our-chefs">--}}
{{--                        <div class="overlay">--}}
{{--                            <span class="about-item-icon">--}}
{{--                                <img src="{{ asset('/images/assets/vegan-meal-deliver_icon_chefs.svg') }}" alt="Meet our chefs">--}}
{{--                            </span>--}}
{{--                            <span class="about-item-title">--}}
{{--                                Meet Our Chefs--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-4 text-center">--}}
{{--                    <a href="#" class="about-item-container" id="sustainability">--}}
{{--                        <div class="overlay">--}}
{{--                            <span class="about-item-icon">--}}
{{--                                <img src="{{ asset('/images/assets/vegan-meal-deliver_icon_sustainability.svg') }}" alt="Meet our chefs">--}}
{{--                            </span>--}}
{{--                            <span class="about-item-title">--}}
{{--                                Sustainability--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-4 text-center">--}}
{{--                    <a href="#" class="about-item-container" id="our-community">--}}
{{--                        <div class="overlay">--}}
{{--                            <span class="about-item-icon">--}}
{{--                                <img src="{{ asset('/images/assets/vegan-meal-deliver_icon_community.svg') }}" alt="Meet our chefs">--}}
{{--                            </span>--}}
{{--                            <span class="about-item-title">--}}
{{--                                Our Community--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

@endsection
@section('scripts.footer')
    <script>
        function rotateSlider() {
            $(".splash-rotating-slider > .slider-item-container:last").addClass('in-legacy');
            $(".splash-rotating-slider > .slider-item-container:first").addClass('in-view');
            $(".splash-rotating-slider > .slider-item-container:nth-child(2)").addClass('up-next');

            $('.splash-rotating-slider').each(function () {
                (function ($slider) {
                    var timer = setInterval(function () {
                        var $prev = $slider.find('.in-legacy').removeClass('in-legacy');
                        var $cur = $slider.find('.in-view').removeClass('in-view').addClass('in-legacy');
                        var $next = $cur.next().length ? $cur.next() : $slider.children().eq(0);
                        var $upNext = $next.next().length ? $next.next() : $slider.children().eq(0);
                        $upNext.addClass('up-next');
                        $next.removeClass('up-next').addClass('in-view');
                    }, 4000);
                    $('.slider-item-container').hover(function (ev) {
                        clearInterval(timer);
                    }, function (ev) {
                        timer = setInterval(function () {
                            var $prev = $slider.find('.in-legacy').removeClass('in-legacy');
                            var $cur = $slider.find('.in-view').removeClass('in-view').addClass('in-legacy');
                            var $next = $cur.next().length ? $cur.next() : $slider.children().eq(0);
                            var $upNext = $next.next().length ? $next.next() : $slider.children().eq(0);
                            $upNext.addClass('up-next');
                            $next.removeClass('up-next').addClass('in-view');
                        }, 4000);
                    });

                    var prevBtn = $slider.find('.prev-btn');
                    var nextBtn = $slider.find('.next-btn');

                    prevBtn.on('click', function(){
                        var $prev = $slider.find('.up-next').removeClass('up-next');
                        var $cur = $slider.find('.in-view').removeClass('in-view').addClass('up-next');
                        var $next = $cur.prev().length ? $cur.prev() : $slider.children().last();
                        var $upNext = $next.prev().length ? $next.prev() : $slider.children().last();
                        $upNext.addClass('in-legacy');
                        $next.removeClass('in-legacy').addClass('in-view');
                    });

                    nextBtn.on('click', function(){
                        var $prev = $slider.find('.in-legacy').removeClass('in-legacy');
                        var $cur = $slider.find('.in-view').removeClass('in-view').addClass('in-legacy');
                        var $next = $cur.next().length ? $cur.next() : $slider.children().eq(0);
                        var $upNext = $next.next().length ? $next.next() : $slider.children().eq(0);
                        $upNext.addClass('up-next');
                        $next.removeClass('up-next').addClass('in-view');
                    });

                })($(this));
            });
        }

        function howWeWork() {

            var nav = $('.how-we-work-nav');
            var timer = setInterval(function () {
                var $cur = nav.find('.active').removeClass('active');
                var $next = $cur.next().length ? $cur.next() : nav.children().eq(0);
                $next.trigger('click');
            }, 4000);
            $('#landing-how-we-work row').hover(function (ev) {
                clearInterval(timer);
            }, function (ev) {
                timer = setInterval(function () {
                    var $cur = nav.find('.active').removeClass('active');
                    var $next = $cur.next().length ? $cur.next() : nav.children().eq(0);
                    $next.trigger('click');
                }, 4000);
            });
        }

        rotateSlider();
        howWeWork();
    </script>
@stop
