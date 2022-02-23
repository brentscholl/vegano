@extends('admin.layouts.app', ['page' => 'prep'])
@section('title')
    Prep Station
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Prep Station</h1>
        <div>
            <a href="{{ route('admin.order.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-box fa-sm text-white-50"></i> All Orders</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-0 text-gray-800">Meals Ordered</h1>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($meals as $meal)
                    <div class="col-3 d-flex align-items-stretch">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 text-center">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">{{ $meal->count() }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $meal->first()->itemable->title }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-0 text-gray-800">Meal Schematic</h1>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($meals as $meal)
                    <div class="col-3 d-flex align-items-stretch">
                        <div class="card shadow mb-4 w-100" >
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="h5 mb-4 font-weight-bold text-gray-800">{{ $meal->first()->itemable->title }}</div>
                                        <div><strong>Order IDs</strong></div>
                                        <ul>
                                            @foreach($meal as $item)
                                                <li><a href="{{ route('admin.order.show', $item->box->id) }}" target="_blank"><strong>{{ $item->box->id }}</strong></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('scripts.footer')

@stop
