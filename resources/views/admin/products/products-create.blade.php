@extends('admin.layouts.app', ['component' => 'productCreate', 'page' => 'products'])
@section('title')
    @if($product)
        Update Product
    @else
        Add New Product
    @endif
@stop
@section('scripts.header')

@stop
@section('content')
<product-create inline-template>
    <div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            @if($product)
                <h1 class="h3 mb-0 text-gray-800">Edit: @{{ form.title }}</h1>
            @else
                <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
            @endif

            @if($product)
                @if($product->published == 1)
                    <span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> PUBLISHED</span>
                @else
                    <span class="badge badge-pill badge-secondary"><i class="fas fa-times-circle"></i> NOT PUBLISHED</span>
                @endif
            @endif
        </div>

        <!-- Default Card Example -->
        <div class="row">

            <div class="col-lg-8">
                <form id="add-new-product-form" @submit.prevent="onSubmit" @keyDown="form.errors.clear($event.target.name)">
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
                                        <label for="title">{{ __('Title') }}</label>
                                        <input id="title" type="text" v-model="form.title"
                                            :class="form.errors.isInvalid('title')"
                                            class="form-control" name="title"
                                            required autocomplete="title" autofocus>

                                            <span v-if="form.errors.has('title')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('title')"></strong>
                                                </small>
                                            </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="sub_title">{{ __('Sub Title') }}</label>
                                        <input id="sub_title" type="text" v-model="form.sub_title"
                                            :class="form.errors.isInvalid('sub_title')"
                                            class="form-control" name="sub_title"
                                            autocomplete="sub_title" autofocus>

                                        <span v-if="form.errors.has('sub_title')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('sub_title')"></strong>
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

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="calories">{{ __('Calories') }}</label>

                                            <input id="calories" type="number" min="0" v-model="form.calories"
                                                :class="form.errors.isInvalid('calories')"
                                                class="form-control" name="calories"
                                                autocomplete="calories" autofocus>

                                            <span v-if="form.errors.has('calories')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('calories')"></strong>
                                                </small>
                                            </span>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="fat">{{ __('Fat') }}</label>
                                            <div class="input-group">

                                                <input id="fat" type="number" min="0" v-model="form.fat"
                                                    :class="form.errors.isInvalid('fat')"
                                                    class="form-control" name="fat"
                                                    autocomplete="fat" autofocus>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">grams</span>
                                                </div>
                                            </div>
                                            <span v-if="form.errors.has('fat')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('fat')"></strong>
                                                </small>
                                            </span>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="carbs">{{ __('Carbohydrates') }}</label>
                                            <div class="input-group">

                                                <input id="carbs" type="number" min="0" v-model="form.carbs"
                                                    :class="form.errors.isInvalid('carbs')"
                                                    class="form-control" name="carbs"
                                                    autocomplete="carbs" autofocus>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">grams</span>
                                                </div>
                                            </div>
                                            <span v-if="form.errors.has('carbs')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('carbs')"></strong>
                                                </small>
                                            </span>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="protein">{{ __('Protein') }}</label>
                                            <div class="input-group">
                                                <input id="protein" type="number" min="0" v-model="form.protein"
                                                    :class="form.errors.isInvalid('protein')"
                                                    class="form-control"
                                                    name="protein"
                                                    autocomplete="protein" autofocus>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">grams</span>
                                                </div>
                                            </div>
                                            <span v-if="form.errors.has('protein')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('protein')"></strong>
                                                </small>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="weight">{{ __('Weight') }}</label>
                                            <div class="input-group">
                                                <input id="weight" type="number" min="0" v-model="form.weight"
                                                    :class="form.errors.isInvalid('weight')"
                                                    class="form-control" name="weight"
                                                    autocomplete="weight" autofocus>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">grams</span>
                                                </div>
                                            </div>
                                            <span v-if="form.errors.has('weight')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('weight')"></strong>
                                                </small>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="price">{{ __('Price') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input id="price" type="number" min="0" v-model="form.price"
                                                    :class="form.errors.isInvalid('price')"
                                                    class="form-control" name="price"
                                                    autocomplete="price" autofocus>
                                            </div>
                                            <span v-if="form.errors.has('price')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('price')"></strong>
                                                </small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4" id="admin-allergens">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Allergens
                                </div>
                                <div class="card-body">
                                    <div v-for="(allergen, index) in form.allergens">
                                        <div class="form-group input-group">
                                            <input type="text"
                                                :class="form.errors.isInvalid('allergens.' + index + '.name')"
                                                class="form-control"
                                                :name="'allergen[' + index + ']'"
                                                v-model="allergen.name"
                                                placeholder="Allergen Title">
                                            <div class="input-group-append">
                                                <button type="button" v-on:click="removeAllergen(index)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <span v-if="form.errors.has('allergens.' + index + '.name')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('allergens.' + index + '.name')"></strong>
                                            </small>
                                        </span>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-primary" @click="addAllergen">Add Allergen</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Attributes
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Inventory</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">SKU</span>
                                                    </div>
                                                    <input type="text"
                                                        v-model="form.sku"
                                                        name="sku"
                                                        :class="form.errors.isInvalid('sku')"
                                                        class="form-control">
                                                </div>
                                                <span v-if="form.errors.has('sku')" class="text-danger" role="alert">
                                                    <small>
                                                    <strong v-text="form.errors.get('sku')"></strong>
                                                    </small>
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Inventory</span>
                                                    </div>
                                                    <input type="number"
                                                        v-model="form.inventory" min="0" min="0"
                                                        name="inventory"
                                                        :class="form.errors.isInvalid('inventory')"
                                                        class="form-control">
                                                </div>
                                                <span v-if="form.errors.has('inventory')" class="text-danger" role="alert">
                                                    <small>
                                                    <strong v-text="form.errors.get('inventory')"></strong>
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">

                        <div class="col-lg-12">
                            @if($product)
                                @if($product->published == '1')
                                    <div class="d-flex align-items-start flex-row">
                                        <button type="button" @click="publishForm" class="btn btn-primary">Update Product</button>
                                        <button type="button" @click="saveForm" class="btn btn-secondary ml-2" >Unpublish Product</button>
                                        <button type="button"  class="ml-auto btn btn-danger" @click="$modal.show('delete-product', { product_id: {{ $product->id }}, title: form.title })"><i class="fas fa-trash"></i> Delete Product</button>
                                    </div>
                                @else
                                    <div class="d-flex align-items-start flex-row">
                                        <button type="button" @click="publishForm" class="btn btn-primary">Publish Product</button>
                                        <button type="button" @click="saveForm" class="btn btn-secondary ml-2" >Save Product as Draft</button>
                                        <button type="button"  class="ml-auto btn btn-danger" @click="$modal.show('delete-product', { product_id: {{ $product->id }}, title: form.title })"><i class="fas fa-trash"></i> Delete Product</button>
                                    </div>
                                @endif
                            @else
                                <button type="button" @click="publishForm" class="btn btn-primary">Publish Product</button>
                                <button type="button" @click="saveForm" class="btn btn-secondary" >Save Product as Draft</button>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-lg-4" id="admin-product-image">
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
</product-create>

@endsection
@section('scripts.vue-variables')
    <script>
        var product = {!! json_encode($product) !!}
    </script>
@stop
@section('scripts.footer')
@stop
