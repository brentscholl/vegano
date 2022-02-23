@extends('admin.layouts.app', ['page' => 'users'])
@section('title')
    Edit Admin | {{ $user->first_name }} {{ $user->last_name }}
@stop
@section('scripts.header')

@stop
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit: {{ $user->first_name }} {{ $user->last_name }}</h1>
        <div>
            <a href="{{ route('admin.users.admins') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">View All Admins</a>
        </div>
    </div>

    <!-- Default Card Example -->

    <form id="edit-user-form" action="{{ route('admin.users.update-admin', $user->id) }}" method="POST">
        @method("PATCH")
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Details
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="first_name" class="required">{{ __('First Name') }}</label>

                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" value="{{ $user->first_name }}" required>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name" class="required">{{ __('Last Name') }}</label>

                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    name="last_name" value="{{ $user->last_name }}" required>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="email" class="required">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $user->email }}" required>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password" class="required">{{ __('New Password') }}</label>

                                <input id="password" type="text" placeholder="(leave blank to keep old password)"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    value="">

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update Admin</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card mb-4">
        <div class="card-header">
            Delete Admin
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.destroy-admin', $user->id) }}" method="post">
                @csrf
                @method('DELETE')

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="delete" name="delete_user" required>
                    <label class="form-check-label" for="delete">
                        Confirm
                    </label>
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-danger">Delete Admin</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts.footer')

@stop
