@extends('admin.layouts.app', ['page' => 'meals'])
@section('title')
    Meal: {{ $meal->title }}
@stop
@section('scripts.header')

@stop
@section('content')
    <div class="row">
        <div class="col text-right mb-4">
            <a href="{{ route('admin.meals.edit', [$meal->id]) }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                <span class="text">Edit Meal</span>
            </a>
            <a href="{{ route('admin.meals.create') }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-utensils fa-sm text-white-50"></i>
                                </span>
                <span class="text">Add New Meal</span>
            </a>
            <a href="{{ route('admin.meals.index') }}" class="btn btn-secondary">
                <span class="text">View All Meal</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-0 text-gray-800">{{ $meal->title }}</h1>
                </div>
                <div class="card-body">
                    <h2 class="h4 mb-2">{{ $meal->sub_title }}</h2>
                    <p>
                        {{ $meal->description }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-2 d-flex align-items-stretch">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Time</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $meal->time ? $meal->time . " <small>minutes</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 d-flex align-items-stretch">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Servings</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $meal->servings ? $meal->servings : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 d-flex align-items-stretch">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Calories</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $meal->calories ? $meal->calories : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 d-flex align-items-stretch">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Fat</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $meal->fat ? $meal->fat . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 d-flex align-items-stretch">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Carbs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $meal->carbs ? $meal->carbs . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 d-flex align-items-stretch">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Protein</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $meal->protein ? $meal->protein . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h4 mb-0 text-gray-800">Recipe</h1>
                </div>
                <div class="card-body">
                    @foreach($meal->recipeSteps as $step)
                        <div class="card mb-2">
                            <div class="card-header py-3">
                                Step {{ $step->step }}: <strong>{{ $step->title }}</strong>
                            </div>
                            <div class="card-body">
                                {{ $step->description }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="h4 mb-0 text-gray-800">Ingredients</h1>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($meal->ingredients as $ingredient)
                                    <li class="list-group-item">{{ $ingredient->pivot->measurement }} {{ $ingredient->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="h4 mb-0 text-gray-800">Tools</h1>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($meal->tools as $tool)
                                    <li class="list-group-item">{{ $tool->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="h4 mb-0 text-gray-800">Allergens</h1>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($meal->allergens as $allergen)
                                    <li class="list-group-item">{{ $allergen->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tbody>
                        <tr>
                            <th scope="row">Created on:</th>
                            <td class="text-info">
                                {{ date('M d, Y', strtotime($meal->created_at)) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Status:</th>
                            <td class="">{!! $meal->published == 1 ? '<span class="text-success">Published</span>' : 'Draft' !!}</td>
                        </tr>
                        <tr>
                            <th scope="row">Countries:</th>
                            <td class="">
                                @foreach($meal->countries as $country)
                                    @if($country->code == 'usa')
                                        <i class="fas fa-flag-usa"></i>
                                    @elseif ($country->code == 'cad')
                                        <i class="fab fa-canadian-maple-leaf"></i>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Chef:</th>
                            <td>
                            @if($meal->chef)
                                <a href="{{ route('admin.chefs.show', [$meal->chef->id]) }}">{{ $meal->chef->name }}</a>
                            @else
                                <i class="fas fa-user-slash"></i>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Sku:</th>
                            <td class="text-info">{{ $meal->sku }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Inventory:</th>
                            <td class="text-info">{{ $meal->inventory }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Start Date:</th>
                            <td class="text-info">{{ $meal->start_date ? date('d M, Y', strtotime($meal->start_date)) : '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">End Date:</th>
                            <td class="text-info">{{ $meal->end_date ? date('d M, Y', strtotime($meal->end_date)) : '' }}</td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header text-left">
                    Meal Image
                </div>
                <div class="card-body">
                    @if($meal->image)
                        <img class="img-fluid" src="{{ $meal->image->src }}{{ $meal->image->filename }}" alt="{{ $meal->title }}">
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts.footer')

@stop
