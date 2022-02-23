<div id="home-rotating-slider" class="splash-rotating-slider">
    @foreach($meals as $meal)
        @include('rotating-slider.rotating-slider-item', ['meal' => $meal])
    @endforeach
</div>
