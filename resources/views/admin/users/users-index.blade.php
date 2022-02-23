@extends('admin.layouts.app', ['page' => 'users'])
@section('title')
    View All Users
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">All Users</h1>

    <div class="row justify-content-center mb-4">
        <div class="col">
            <form method="POST" action="{{ route('admin.users.search') }}" id="boxes-search-form"
                class="search-bar">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    {!! Form::select('search_by',array(
                        '' => 'Search By...',
                        'id' => 'User ID',
                        'name' => 'Name',
                        'email' => 'Email',
                    ), session('SEARCH.SEARCH_BY') , array('class'=>'form-control', 'id' => 'search_by')) !!}
                        {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control','placeholder'=>'Search')) !!}

                    <div class="input-group-append">
                        {!! Form::submit('Search', array('id' => 'search', 'name' => '', 'class' => 'btn btn-primary')) !!}
                        {!! Form::button('Reset',array('type'=>'submit','id' => 'reset', 'name' => 'reset', 'value' => '1', 'class' => 'btn btn-secondary')) !!}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-busered table-striped dataTable" id="dataTable" width="100%" cellspacing="0"
                role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Stripe ID</th>
                    <th>Trial End Date</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Stripe ID</th>
                    <th>Trial End Date</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    <tr role="row" class="odd">
                        <td><strong>{{ $user->id }}</strong></td>
                        <td><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></td>
                        <td>
                            {{ $user->email }}&nbsp;
{{--                            @if($user->verified_at)--}}
{{--                                <i class="fas fa-check-circle text-success" title="Verified email"></i>--}}
{{--                            @else--}}
{{--                                <i class="fas fa-times-circle text-danger" title="Email not verified"></i>--}}
{{--                            @endif--}}
                        </td>
                        <td>{{ $user->strip_id }}</td>
                        <td>{{ $user->trial_ends_at ? date('d M, Y @ g:i A', strtotime($user->trial_ends_at)) : '' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit', [$user->id])  }}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                                <span class="text">Edit User</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $paginator !!}
        </div>
    </div>

    <a href="" class="btn"></a>
    <div class="btn-primary"></div>

@endsection
@section('scripts.footer')

@stop
