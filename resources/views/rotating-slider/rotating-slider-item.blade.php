<div class="slider-item-container">
    @if($meal->image)
        <a href="{{ route('meals.show', $meal->slug) }}"><img src="{{ $meal->image->src }}{{ $meal->image->filename }}" alt="{{ $meal->title }}"></a>
    @endif
    <div class="slider-item-card card">
        <div class="card-header">
            <a href="{{ route('meals.show', $meal->slug) }}"><h3>{{ $meal->title }}</h3></a>
        </div>
        <div class="card-footer">
            <div class="details">
                <div class="detail-item">
                    <span class="amount">{{ $meal->fat }}g</span>
                    <span class="label">Fat</span>
                </div>
                <div class="detail-item">
                    <span class="amount">{{ $meal->carbs }}g</span>
                    <span class="label">Carbs</span>
                </div>
                <div class="detail-item">
                    <span class="amount">{{ $meal->protein }}g</span>
                    <span class="label">Protein</span>
                </div>
                <div class="detail-item">
                    <span class="amount">{{ $meal->calories }}</span>
                    <span class="label">Calories</span>
                </div>
                <div class="detail-item">
                    <span class="amount">{{ $meal->time }}</span>
                    <span class="label">Minutes</span>
                </div>
            </div>
            <div class="footer-btns">
                @guest
                    <a href="{{ route('sign-up') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Please Login or Sign Up first.">Add to Box</a>
                @else
                    <button type="button" class="btn btn-primary btn-sm" @click="showBox('{{ $meal->id }}', '{{ $meal->title }}', '{{ $meal->image->src }}{{ $meal->image->filename }}')" data-toggle="modal" data-target="#boxModal">Add to Box</button>
                @endguest
                <a href="{{ route('meals.show', $meal->slug) }}" class="btn btn-secondary btn-sm">More Info</a>
            </div>
        </div>
        <div class="slider-item-nav-btns">
            <button type="button" class="prev-btn btn nav-btn"><i class="fas fa-chevron-left"></i></button>
            <button type="button" class="next-btn btn nav-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</div>
