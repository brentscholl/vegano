@extends('admin.layouts.app', ['page' => 'meals'])
@section('title')
    View All Meals
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        @switch( app('request')->input('country') )
            @case('cad')
                Canadian Meals
                @break
            @case('usa')
                American Meals
                @break
            @default
                All Meals
        @endswitch
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('admin.meals.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-utensils fa-sm text-white-50"></i> Add New Meal</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                <tr role="row">
                    <th>Title</th>
                    <th>SKU</th>
                    <th>Inventory</th>
                    <th>Status</th>
                    <th>Chef</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Title</th>
                    <th>SKU</th>
                    <th>Inventory</th>
                    <th>Status</th>
                    <th>Chef</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($meals as $meal)
                    <tr role="row" class="odd">
                        <td><a href="{{ route('admin.meals.show', [$meal->id]) }}" title="View Meal"><strong>{{ $meal->title }}</strong></a></td>
                        <td>{{ $meal->sku }}</td>
                        <td>{{ $meal->inventory }}</td>
                        <td>
                            {!! $meal->published == 1 ? '<span class="text-success">Published</span> ' : 'Draft ' !!}
                            @foreach($meal->countries as $country)
                                @if($country->code == 'usa')
                                    <i class="fas fa-flag-usa"></i>
                                @elseif ($country->code == 'cad')
                                    <i class="fab fa-canadian-maple-leaf"></i>
                                @endif
                            @endforeach
                        </td>
                        @if($meal->chef)
                            <td><a href="{{ route('admin.chefs.show', [$meal->chef->id]) }}">{{ $meal->chef->name }}</a></td>
                        @else
                            <td></td>
                        @endif
                        <td class="text-center">
                            @if($meal->image)
                                <img style="height: 40px; width: auto;" src="/images/uploads/{{$meal->image->filename}}">
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.meals.edit', [$meal->id]) }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                                <span class="text">Edit Meal</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('scripts.footer')

@stop
