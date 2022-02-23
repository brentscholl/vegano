@extends('admin.layouts.app', ['page' => 'products'])
@section('title')
    Product: {{ $product->title }}
@stop
@section('scripts.header')

@stop
@section('content')
    <div class="row">
        <div class="col text-right mb-4">
            <a href="{{ route('admin.products.edit', [$product->id]) }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                <span class="text">Edit Product</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-utensils fa-sm text-white-50"></i>
                                </span>
                <span class="text">Add New Product</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-0 text-gray-800">{{ $product->title }}</h1>
                </div>
                <div class="card-body">
                    <h2 class="h4 mb-2">{{ $product->sub_title }}</h2>
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Price</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $product->price ? '$' . number_format($product->price / 100, 2, '.', ',') : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Weight</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $product->weight ? $product->weight . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Calories</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $product->calories ? $product->calories : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Fat</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $product->fat ? $product->fat . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Carbs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $product->carbs ? $product->carbs . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Protein</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $product->protein ? $product->protein . " <small>grams</small>" : '' !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="h4 mb-0 text-gray-800">Allergens</h1>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($product->allergens as $allergen)
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
                                {{ date('M d, Y', strtotime($product->created_at)) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Status:</th>
                            <td class="">{!! $product->published == 1 ? '<span class="text-success">Published</span>' : 'Draft' !!}</td>
                        </tr>
                        <tr>
                            <th scope="row">Sku:</th>
                            <td class="text-info">{{ $product->sku }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Inventory:</th>
                            <td class="text-info">{{ $product->inventory }}</td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header text-left">
                    Product Image
                </div>
                <div class="card-body">
                    <img class="img-fluid" src="{{ $product->image->src }}{{ $product->image->filename }}" alt="{{ $product->title }}">
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts.footer')

@stop
