@extends('admin.layouts.app', ['component' => 'chefCreate', 'page' => 'chefs'])
@section('title')
    @if($chef)
        Update Product
    @else
        Add New Product
    @endif
@stop
@section('scripts.header')

@stop
@section('content')
<chef-create inline-template>
    <div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            @if($chef)
                <h1 class="h3 mb-0 text-gray-800">Edit: @{{ form.name }}</h1>
            @else
                <h1 class="h3 mb-0 text-gray-800">Add New Chef</h1>
            @endif
                <div>
                    <a href="{{ route('admin.chefs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">View All Chefs</a>
                </div>
                @if($chef)
                    @if($chef->published == 1)
                        <span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> PUBLISHED</span>
                    @else
                        <span class="badge badge-pill badge-secondary"><i class="fas fa-times-circle"></i> NOT PUBLISHED</span>
                    @endif
                @endif
        </div>

        <!-- Default Card Example -->
        <div class="row">

            <div class="col-lg-8">
                <form id="add-new-chef-form" @submit.prevent="onSubmit" @keyDown="form.errors.clear($event.target.name)">
                    @csrf
                    <input type="hidden" name="image_id" v-model="form.image_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Details
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input id="name" type="text" v-model="form.name"
                                            :class="form.errors.isInvalid('name')"
                                            class="form-control" name="name"
                                            required autocomplete="name" autofocus>

                                            <span v-if="form.errors.has('name')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('name')"></strong>
                                                </small>
                                            </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea id="description" type="text" v-model="form.description"
                                            :class="form.errors.isInvalid('description')"
                                            class="form-control"
                                            name="description"
                                            autofocus></textarea>

                                        <span v-if="form.errors.has('description')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('description')"></strong>
                                            </small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">

                        <div class="col-lg-6">
                            @if($chef)
                                @if($chef->published == '1')
                                    <div class="d-flex align-items-start flex-row">
                                        <button type="button" @click="publishForm" class="btn btn-primary">Update Chef</button>
                                        <button type="button" @click="saveForm" class="btn btn-secondary ml-2" >Unpublish Chef</button>
                                        <button type="button"  class="ml-auto btn btn-danger" @click="$modal.show('delete-chef', { chef_id: {{ $chef->id }}, title: form.title })"><i class="fas fa-trash"></i> Delete Chef</button>
                                    </div>
                                @else
                                    <div class="d-flex align-items-start flex-row">
                                        <button type="button" @click="publishForm" class="btn btn-primary">Publish Chef</button>
                                        <button type="button" @click="saveForm" class="btn btn-secondary ml-2" >Save Chef as Draft</button>
                                        <button type="button"  class="ml-auto btn btn-danger" @click="$modal.show('delete-chef', { chef_id: {{ $chef->id }}, title: form.title })"><i class="fas fa-trash"></i> Delete Chef</button>
                                    </div>
                                @endif
                            @else
                                <button type="button" @click="publishForm" class="btn btn-primary">Publish Chef</button>
                                <button type="button" @click="saveForm" class="btn btn-secondary" >Save Chef as Draft</button>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-lg-4" id="admin-chef-image">
                <div class="card mb-4">
                    <div class="card-header">
                        Image
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.images.create') }}" id="add-new-image-form">
                            @csrf
                            <file-upload></file-upload>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</chef-create>

@endsection
@section('scripts.vue-variables')
    <script>
        var chef = {!! json_encode($chef) !!}
    </script>
@stop
@section('scripts.footer')

@stop
