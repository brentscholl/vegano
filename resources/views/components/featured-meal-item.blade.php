<div class="featured-meal-item-container">
    @if(isset($meal))
    <a href="{{ route('meals.show', $meal->slug) }}" class="featured-meal-item-link">
        @if($meal->image)
            <img src="{{ $meal->image->src }}{{ $meal->image->filename }}" alt="{{ $meal->title }}">
        @endif
        <div class="featured-meal-item-header">
            <h3>{{ $meal->title }}</h3>
        </div>
        <div class="featured-meal-item-footer">
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
    </a>
    <div class="footer-btns">
        @guest
            <a href="{{ route('sign-up') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Please Login or Sign Up first.">Add to Box</a>
        @else
            <button type="button" class="btn btn-primary btn-sm" @click="showBox('{{ $meal->id }}', '{{ $meal->title }}', '{{ $meal->image->src }}{{ $meal->image->filename }}')" data-toggle="modal" data-target="#boxModal">Add to Box</button>
        @endguest
        <a href="{{ route('meals.show', $meal->slug) }}" class="btn btn-secondary btn-sm">More Info</a>
    </div>
    @endif
</div>
