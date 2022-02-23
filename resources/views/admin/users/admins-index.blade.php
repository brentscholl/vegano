@extends('admin.layouts.app', ['page' => 'admin'])
@section('title')
    View All Admins
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">All Admins</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('admin.users.create-admin') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-utensils fa-sm text-white-50"></i> Add New Admins</a>
        </div>
        <div class="card-body">
            <table class="table table-busered table-striped dataTable" id="dataTable" width="100%" cellspacing="0"
                role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                <tr role="row">
                    <th>Name</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    <tr role="row" class="odd">
                        <td><strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                        </td>
                        <td>
                            {{ $user->email }}&nbsp;
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit-admin', [$user->id])  }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                                <span class="text">Edit Admin</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="" class="btn"></a>
    <div class="btn-primary"></div>

@endsection
@section('scripts.footer')

@stop
