@extends('admin.layouts.app', ['component' => 'mealCreate', 'page' => 'meals'])
@section('title')
    @if($meal)
        Update Meal
    @else
        Add New Meal
    @endif
@stop
@section('scripts.header')

@stop
@section('content')
<meal-create inline-template>
    <div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            @if($meal)
                <h1 class="h3 mb-0 text-gray-800 flex-grow-1">Edit: @{{ form.title }}</h1>
            @else
                <h1 class="h3 mb-0 text-gray-800">Add New Meal</h1>
            @endif

            @if($meal)
                @if($meal->published == 1)
                        <span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> PUBLISHED</span>
                @else
                        <span class="badge badge-pill badge-secondary"><i class="fas fa-times-circle"></i> NOT PUBLISHED</span>
                @endif
            @endif

            <div class="ml-3">
                <a href="{{ route('admin.meals.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">View All Meals</a>
            </div>
        </div>

        <!-- Default Card Example -->
        <div class="row">

            <div class="col-lg-8">
                <form id="add-new-meal-form" @submit.prevent="onSubmit" @keyDown="form.errors.clear($event.target.name)">
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
                                        <div class="col-md-6">
                                            <label for="time">{{ __('Cook Time') }}</label>
                                            <div class="input-group">
                                                <input id="time" type="number" min="0" v-model="form.time"
                                                    :class="form.errors.isInvalid('time')"
                                                    class="form-control" name="time"
                                                    autocomplete="time" autofocus>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">minutes</span>
                                                </div>
                                            </div>
                                            <span v-if="form.errors.has('time')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('time')"></strong>
                                                </small>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="servings">{{ __('Servings') }}</label>
                                            <input id="servings" type="number" min="2" v-model="form.servings"
                                                :class="form.errors.isInvalid('servings')"
                                                class="form-control" name="servings"
                                                autocomplete="servings" autofocus>
                                            <span v-if="form.errors.has('servings')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('servings')"></strong>
                                                </small>
                                            </span>
                                        </div>
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
                                                    <span class="input-group-text" id="basic-addon2">grams</span>
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
                                                    <span class="input-group-text" id="basic-addon2">grams</span>
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
                                                    <span class="input-group-text" id="basic-addon2">grams</span>
                                                </div>
                                            </div>
                                            <span v-if="form.errors.has('protein')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('protein')"></strong>
                                                </small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="admin-recipe-steps">

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Recipe Steps
                                </div>
                                <div class="card-body">
                                    <div v-for="(recipe, index) in form.recipes">

                                        <input type="hidden" :name="'recipe_step[' + index + ']'" v-model="recipe.step">
                                        <div class="form-group input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Step @{{ index + 1 }}</span>
                                            </div>
                                            <input type="text"
                                                :class="form.errors.isInvalid('recipes.' + index + '.title')"
                                                class="form-control"
                                                :name="'recipe_title[' + index + ']'"
                                                v-model="recipe.title"
                                                placeholder="Title">
                                            <div class="input-group-append">
                                                <button type="button" v-on:click="removeRecipe(index)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <textarea type="text"
                                            :class="form.errors.isInvalid('recipes.' + index + '.description')"
                                            class="form-control mb-3" style="border-top: none;"
                                            :name="'recipe_description[' + index + ']'"
                                            v-model="recipe.description"
                                            placeholder="Instructions"></textarea>
                                        <span v-if="form.errors.has('recipes.' + index + '.title')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('recipes.' + index + '.title')"></strong>
                                            </small>
                                        </span>
                                        <span v-if="form.errors.has('recipes.' + index + '.description')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('recipes.' + index + '.description')"></strong>
                                            </small>
                                        </span>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-primary" @click="addRecipe">Add Recipe Step</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12" id="admin-ingredients">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Ingredients
                                </div>
                                <div class="card-body">
                                    <p><small>Here are some handy measurements to copy/paste:</small></p>
                                    <ul class="list-group list-group-horizontal-xl mb-4">
                                        <li class="list-group-item">½</li>
                                        <li class="list-group-item">⅓</li>
                                        <li class="list-group-item">¼</li>
                                        <li class="list-group-item">⅛</li>
                                        <li class="list-group-item">⅔</li>
                                        <li class="list-group-item">¾</li>
                                    </ul>

                                    <div v-for="(ingredient, index) in form.ingredients">

                                        <div class="form-group input-group">
                                            <input type="text"
                                                :class="form.errors.isInvalid('ingredients.' + index + '.pivot.measurement')"
                                                class="form-control"
                                                :name="'ingredient_measurement[' + index + ']'"
                                                v-model="ingredient.pivot.measurement"
                                                placeholder="Measurement">
                                            <input type="text"
                                                :class="form.errors.isInvalid('ingredients.' + index + '.name')"
                                                class="form-control"
                                                :name="'ingredient[' + index + ']'"
                                                v-model="ingredient.name"
                                                placeholder="Ingredient">
                                            <div class="input-group-append">
                                                <button type="button" v-on:click="removeIngredient(index)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <span v-if="form.errors.has('ingredients.' + index + '.measurement')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('ingredients.' + index + '.measurement')"></strong>
                                            </small>
                                        </span>
                                        <span v-if="form.errors.has('ingredients.' + index + '.title')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('ingredients.' + index + '.title')"></strong>
                                            </small>
                                        </span>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-primary" @click="addIngredient">Add Ingredient</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6" id="admin-tools">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Tools
                                </div>
                                <div class="card-body">
                                    <div v-for="(tool, index) in form.tools">
                                        <div class="form-group input-group">
                                            <input type="text"
                                                :class="form.errors.isInvalid('tools.' + index + '.name')"
                                                class="form-control"
                                                :name="'tool[' + index + ']'"
                                                v-model="tool.name"
                                                placeholder="Tool Title">
                                            <div class="input-group-append">
                                                <button type="button" v-on:click="removeTool(index)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <span v-if="form.errors.has('tools.' + index + '.name')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('ingredients.' + index + '.name')"></strong>
                                            </small>
                                        </span>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-primary" @click="addTool">Add Tool</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6" id="admin-allergens">
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

                    </div>
                    <div class="row">
                        <div class="col-lg-4" id="admin-schedule">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Schedule
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label>Start Date</label>
                                        <div>
                                            <b-form-datepicker form="add-new-meal-form"
                                                v-model="form.start_date"
                                                :class="form.errors.isInvalid('start_date')"
                                                name="start_date"
                                                id="meal-schedule-start_date"
                                                placeholder="Set Start Date" local="en"></b-form-datepicker>
                                        </div>
                                        <span v-if="form.errors.has('start_date')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('start_date')"></strong>
                                            </small>
                                        </span>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>End Date</label>
                                        <div>
                                            <b-form-datepicker form="add-new-meal-form"
                                                v-model="form.end_date"
                                                :class="form.errors.isInvalid('end_date')"
                                                name="end_date"
                                                id="meal-schedule-end_date"
                                                placeholder="Set End Date" local="en"></b-form-datepicker>
                                        </div>
                                        <span v-if="form.errors.has('end_date')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('end_date')"></strong>
                                            </small>
                                        </span>
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
                                    <div class="form-group">
                                        <label for="title">{{ __('Attached To Chef') }}</label>

                                        <select id="chefs" v-model="form.chef_id"
                                            :class="form.errors.isInvalid('chef_id')"
                                            class="form-control">
                                            <option value="" selected>Choose...</option>
                                            <option v-for="chef in form.chefs" v-bind:value="chef.id">
                                                @{{ chef.name }}
                                            </option>
                                        </select>

                                        <span v-if="form.errors.has('chef_id')" class="text-danger" role="alert">
                                            <small>
                                            <strong v-text="form.errors.get('chef_id')"></strong>
                                            </small>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Select the countries this meal belongs too') }}</label>
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="form.countries" type="checkbox" name="countries" value="cad" id="country-canada">
                                            <label class="form-check-label" for="country-canada">
                                                Canada
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="form.countries" type="checkbox" name="countries" value="usa" id="country-usa">
                                            <label class="form-check-label" for="country-usa">
                                                United States
                                            </label>
                                        </div>
                                        <span v-if="form.errors.has('country')" class="text-danger" role="alert">
                                                <small>
                                                <strong v-text="form.errors.get('country')"></strong>
                                                </small>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">

                        <div class="col-lg-12">
                            @if($meal)
                                @if($meal->published == '1')
                                    <div class="d-flex align-items-start flex-row">
                                        <button type="button" @click="publishForm" class="btn btn-primary">Update Meal</button>
                                        <button type="button" @click="saveForm" class="btn btn-secondary ml-2" >Unpublish Meal</button>
                                        <button type="button"  class="ml-auto btn btn-danger" @click="$modal.show('delete-meal', { meal_id: {{ $meal->id }}, title: form.title })"><i class="fas fa-trash"></i> Delete Meal</button>
                                    </div>
                                @else
                                    <div class="d-flex align-items-start flex-row">
                                        <button type="button" @click="publishForm" class="btn btn-primary">Publish Meal</button>
                                        <button type="button" @click="saveForm" class="btn btn-secondary ml-2" >Save Meal as Draft</button>
                                        <button type="button"  class="ml-auto btn btn-danger" @click="$modal.show('delete-meal', { meal_id: {{ $meal->id }}, title: form.title })"><i class="fas fa-trash"></i> Delete Meal</button>
                                    </div>
                                @endif
                            @else
                                <button type="button" @click="publishForm" class="btn btn-primary">Publish Meal</button>
                                <button type="button" @click="saveForm" class="btn btn-secondary" >Save Meal as Draft</button>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-lg-4" id="admin-meal-image">
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
</meal-create>

@endsection
@section('scripts.vue-variables')
    <script>
        var chefs = {!! json_encode($chefs) !!};
        var meal = {!! json_encode($meal) !!};
        var countries = {!! json_encode($countryCodes) !!};
    </script>
@stop
@section('scripts.footer')
@stop
