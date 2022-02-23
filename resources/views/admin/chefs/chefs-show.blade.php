@extends('admin.layouts.app', ['page' => 'chefs'])
@section('title')
    Chef: {{ $chef->name }}
@stop
@section('scripts.header')

@stop
@section('content')
    <div class="row">
        <div class="col text-right mb-4">
            <a href="{{ route('admin.chefs.edit', [$chef->id]) }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                <span class="text">Edit Chef</span>
            </a>
            <a href="{{ route('admin.chefs.create') }}" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-utensils fa-sm text-white-50"></i>
                                </span>
                <span class="text">Add New Chef</span>
            </a>
            <a href="{{ route('admin.chefs.index') }}" class="btn btn-secondary">
                <span class="text">View All Chefs</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-0 text-gray-800">{{ $chef->name }}</h1>
                </div>
                <div class="card-body">
                    <p>
                        {{ $chef->description }}
                    </p>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h4 mb-0 text-gray-800">Meals</h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($chef->meals as $meal)
                            <li class="list-group-item"><a
                                    href="{{ route('admin.meals.show', $meal->id) }}">{{ $meal->title }}</a></li>
                        @endforeach
                    </ul>
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
                                {{ date('M d, Y', strtotime($chef->created_at)) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Status:</th>
                            <td class="">{!! $chef->published == 1 ? '<span class="text-success">Published</span>' : 'Draft' !!}</td>
                        </tr>
                        <tr>
                            <th scope="row">Meals:</th>
                            <td class="">{{ count($chef->meals) }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header text-left">
                    Chef Image
                </div>
                <div class="card-body text-center">
                    @if($chef->image)
                        <img class="img-fluid" src="{{ $chef->image->src }}{{ $chef->image->filename }}"
                            alt="{{ $chef->title }}">
                    @else
                        <i class="fas fa-10x fa-portrait" style="opacity: 0.5"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts.footer')

@stop
