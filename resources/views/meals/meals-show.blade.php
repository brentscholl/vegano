@extends('layouts.app')
@section('title', $meal->title. ' | Vegano')

@section('scripts.header')
@stop

@section('content')
    <section id="meal-splash" class="animation-element">
        <div class="container">
            <div class="img-container">
                <img class="rotate-in-top" src="{{ $meal->image->src }}{{ $meal->image->filename }}" alt="{{ $meal->title }}">
            </div>
        </div>
    </section>
    <section id="meal-content">
        <div class="container meal-container">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <h1>{{ $meal->title }}</h1>
                    <h2>{{ $meal->sub_title }}</h2>
                    @if(inAmerica())
                        @if($meal->isUSA())
                            @guest
                                <a href="{{ route('sign-up') }}" class="btn btn-accent" data-toggle="tooltip" data-placement="top" title="Please Login or Sign Up first.">Add to Box</a>
                            @else
                                <button type="button" class="btn btn-accent" @click="showBox('{{ $meal->id }}', '{{ $meal->title }}', '{{ $meal->image->src }}{{ $meal->image->filename }}')" data-toggle="modal" data-target="#boxModal">Add to Box</button>
                            @endguest
                        @else
                            <h3>This meal is not available in your country</h3>
                        @endif
                    @else
                        @if($meal->inCanada())
                            @guest
                                <a href="{{ route('sign-up') }}" class="btn btn-accent" data-toggle="tooltip" data-placement="top" title="Please Login or Sign Up first.">Add to Box</a>
                            @else
                                <button type="button" class="btn btn-accent" @click="showBox('{{ $meal->id }}', '{{ $meal->title }}', '{{ $meal->image->src }}{{ $meal->image->filename }}')" data-toggle="modal" data-target="#boxModal">Add to Box</button>
                            @endguest
                        @else
                            <h3>This meal is not available in your country</h3>
                        @endif
                    @endif
                </div>
                <div class="col-lg-4 col-md-6">
                    <table class="table table-striped table-borderless prep-time-table">
                        <thead>
                        <tr>
                            <th scope="col" class="title"><i class="fas fa-hourglass-half"></i> Prep & Cook Time</th>
                            <th scope="col" class="time text-right">{{ $meal->time }} min</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="title">Calories</td>
                            <td class="text-right">{{ $meal->calories }}</td>
                        </tr>
                        <tr>
                            <td class="title">Fat</td>
                            <td class="text-right">{{ $meal->fat }}g</td>
                        </tr>
                        <tr>
                            <td class="title">Carbohydrates</td>
                            <td class="text-right">{{ $meal->carbs }}g</td>
                        </tr>
                        <tr>
                            <td class="title">Protein</td>
                            <td class="text-right">{{ $meal->protein }}g</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-md-8">
                    <div class="attribute-container">
                        <div class="meal-detail-title">
                            Main Ingredients
                        </div>
                        <ul class="ingredient-list">
                            @foreach($meal->ingredients as $ingredient)
                                <li>{{ $ingredient->pivot->measurement }} {{ $ingredient->name }}</li>
                            @endforeach
                        </ul>
                        @if($meal->allergens->count() > 0)
                            <div class="allergen-container">
                                <span><i class="fas fa-exclamation-circle"></i>Contains Allergen{{ $meal->allergens->count() > 1 ? 's' : '' }}</span>
                                <ul class="allergen-list">
                                    @foreach($meal->allergens as $allergen)
                                        <li>{{ $allergen->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-3 col-md-4">
                    <div class="attribute-container">
                        <div class="meal-detail-title">
                            Tools
                        </div>
                        <ul class="tool-list">
                            @foreach($meal->tools as $tool)
                                <li>{{ $tool->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="meal-detail-title mb-0">
                Instructions
            </div>
            <div class="row">
                @foreach($meal->recipeSteps as $step)
                    <div class="col-lg-6">
                        <div class="step-container">
                            <div class="step-icon">
                                <span>Step</span>
                                {{ $step->step }}
                            </div>
                            <div class="step-body">
                                <h5>{{ $step->title }}</h5>
                                <p>{{ $step->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <section id="meal-share">
        <div class="container text-center">
            @if(inAmerica())
                @if($meal->isUSA())
                    @guest
                        <a href="{{ route('sign-up') }}" class="btn btn-accent" data-toggle="tooltip" data-placement="top" title="Please Login or Sign Up first.">Add to Box</a>
                    @else
                        <button type="button" class="btn btn-accent" @click="showBox('{{ $meal->id }}', '{{ $meal->title }}', '{{ $meal->image->src }}{{ $meal->image->filename }}')" data-toggle="modal" data-target="#boxModal">Add to Box</button>
                    @endguest
                @endif
            @else
                @if($meal->inCanada())
                    @guest
                        <a href="{{ route('sign-up') }}" class="btn btn-accent" data-toggle="tooltip" data-placement="top" title="Please Login or Sign Up first.">Add to Box</a>
                    @else
                        <button type="button" class="btn btn-accent" @click="showBox('{{ $meal->id }}', '{{ $meal->title }}', '{{ $meal->image->src }}{{ $meal->image->filename }}')" data-toggle="modal" data-target="#boxModal">Add to Box</button>
                    @endguest
                @endif
            @endif
            <div class="share-container">
{{--                <span>Share this recipe:</span>--}}
            </div>
        </div>
    </section>

    <section id="meal-other-bowls" class="last-section-background-circle">
        <div class="container animation-element">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="h1">
                        Try these bowls
                    </h3>
                </div>
            </div>
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
@endsection

@section('scripts.footer')
@stop
