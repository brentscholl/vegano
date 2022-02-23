@extends('admin.layouts.app', ['page' => 'chefs'])
@section('title')
    View All Chefs
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">All Chefs</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('admin.chefs.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-utensils fa-sm text-white-50"></i> Add New Chef</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                <tr role="row">
                    <th>Name</th>
                    <th>Meal Count</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Meal Count</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($chefs as $chef)
                    <tr role="row" class="odd">
                        <td><a href="{{ route("admin.chefs.show", [$chef->id]) }}" title="View Chef"><strong>{{ $chef->name }}</strong></a></td>
                        <td>{{ $chef->meals->count() }}</td>
                        <td class="text-center">
                            @if($chef->image)
                                <img style="height: 40px; width: auto;" src="/images/{{$chef->image->filename}}">
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route("admin.chefs.edit", [$chef->id]) }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                                <span class="text">Edit Chef</span>
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
