@extends('layouts.app')
@section('title', 'Meals | Vegano')

@section('scripts.header')
@stop

@section('content')
    <section id="menu-menu" class="last-section-background-circle">
        <div class="container animation-element">
            <div class="row">
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

@stop
