@extends('layouts.app')
@section('title', 'Vegano')

@section('scripts.header')
    {{--    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">--}}
@stop


@section('content')
    <section id="home-splash">
        <div class="home-slider-container desktop">
            @include('rotating-slider.rotating-slider')
        </div>
        <div class="container animation-element">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6">
                    <h1 class="slide-in-right">This week's lineup</h1>
                    <p class="slide-in-right animation-delay-1">See what we have in store for this week's recipes. Pick your favorites and start cooking!</p>
                </div>
            </div>
        </div>
    </section>

    <section id="home-featured-bowls" class="last-section-background-circle">
        <div class="container animation-element">
            <div class="row desktop">
                <div class="col-md-12">
                    <h2>Meals</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($meals as $meal)
                <div class="col-md-4 col-sm-6 featured-meal-col zoom-in animation-delay-{{ $loop->iteration }}">
                    @include('components.featured-meal-item', ['meal' => $meal])
                </div>
                @endforeach
            </div>
        </div>
    </section>
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

        rotateSlider();
    </script>

@stop
