<?php

    namespace App\Http\Controllers;

    use App\Allergen;
    use App\BoxItem;
    use App\Chef;
    use App\Country;
    use App\Image;
    use App\Ingredient;
    use App\Meal;
    use App\RecipeStep;
    use App\Tool;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    use Validator;

    class MealController extends Controller
    {
        /**
         * Display meals to admin users in dashboard
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {

            if($request->query('country')){
                $meals = Meal::with(['image'])->whereHas('countries', function($e) use($request) {
                        $e->where('code', $request->query('country'));
                })->get();
            }else{
                $meals = Meal::with(['image'])->get();
            }

            return view('admin.meals.meals-index', compact('meals'));
        }

        /**
         * Display meals to frontend users.
         *
         * @return \Illuminate\Http\Response
         */
        public function indexFront() {
            if(inAmerica()){
                $countryCode = 'usa';
            }else{
                $countryCode = 'cad';
            }

            $meals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
                $e->where('code', $countryCode);
            })->get();

            return view('meals.meals-index', compact('meals'));
        }

        /**
         * Show the form for creating a meal
         */
        public function create() {

            $chefs = Chef::orderBy('name', 'desc')->get();
            $meal = null;
            $countryCodes = array();

            return view('admin.meals.meals-create', compact('chefs', 'meal', 'countryCodes'));
        }

        /**
         * Store a newly created meal in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request) {

            if ( $request->publish == '1' ) { // If trying to publish
                // Details Rules
                $rules = [
                    'title'       => 'required|string|unique:meals,title|max:255',
                    'sub_title'   => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'time'        => 'required|numeric',
                    'servings'    => 'required|numeric',
                    'calories'    => 'required|numeric',
                    'fat'         => 'required|numeric',
                    'carbs'       => 'required|numeric',
                    'protein'     => 'required|numeric',
                    // 'start_date'  => 'required|date_format:Y-m-d',
                    // 'end_date'    => 'required|date_format:Y-m-d',
                    'sku'         => 'nullable|string|unique:meals,sku',
                    'inventory'   => 'nullable|numeric',
                    'chef_id'     => 'nullable|numeric',
                ];

                // Recipe Rules
                if ( $request->input('recipes') ) {
                    $rules['recipes.*.title'] = 'required|string';
                    $rules['recipes.*.description'] = 'required|string';
                }

                // Ingredient Rules
                if ( $request->input('ingredients') ) {
                    $rules['ingredients.*.pivot.measurement'] = 'required';
                    $rules['ingredients.*.name'] = 'required|string';
                }

                // Tool Rules
                if ( $request->input('tools') ) {
                    $rules['tools.*.name'] = 'required';
                }

                // Allergen Rules
                if ( $request->input('allergens') ) {
                    $rules['allergens.*.name'] = 'required';
                }

                $this->validate(request(), $rules);
            } else { // Saving as draft

                $rules = [
                    'title'       => 'required|string|unique:meals,title|max:255',
                ];

                $this->validate(request(), $rules);
            }

            try {
                DB::beginTransaction();
                $meal = Meal::create([
                    'title'       => $request->input('title'),
                    'sub_title'   => $request->input('sub_title'),
                    'description' => $request->input('description'),
                    'time'        => $request->input('time'),
                    'calories'    => $request->input('calories'),
                    'fat'         => $request->input('fat'),
                    'carbs'       => $request->input('carbs'),
                    'protein'     => $request->input('protein'),
                    'servings'    => $request->input('servings'),
                    'image_id'    => $request->input('image_id'),
                    'inventory'   => $request->input('inventory'),
                    'sku'         => $request->input('sku'),
                    'premium'     => $request->input('premium') ? $request->input('premium') : 0,
                    'published'   => $request->input('publish'),
                    'start_date'  => $request->input('start_date'),
                    'end_date'    => $request->input('end_date'),
                    'chef_id'     => $request->input('chef_id'),
                ]);

                //Attach image to the meal
                if ( $request->input('image_id') > 0 ) {
                    $image = Image::find($request->input('image_id'));
                    $image->imageable_type = 'App\Meal';
                    $image->imageable_id = $meal->id;
                    $image->save();
                }

                // Add Recipe steps
                if ( $request->input('recipes') > 0 ) {
                    $recipeStepCount = count($request->input('recipes'));
                    $step = 1;
                    for ( $i = 0; $i < $recipeStepCount; $i++ ) {
                        RecipeStep::create([
                            'meal_id'     => $meal->id,
                            'step'        => $step,
                            'title'       => $request->input('recipes.' . $i . '.title'),
                            'description' => $request->input('recipes.' . $i . '.description'),
                        ]);
                        $step++;
                    }
                }

                // Add Ingredients
                if($request->input('ingredients.0')) {
                    if ( ! in_array(null, $request->input('ingredients.0'), true) ) {

                        $ingredientCount = count($request->input('ingredients'));
                        for ( $i = 0; $i < $ingredientCount; $i++ ) {
                            // Create the ingredient if it doesnt exit, else return ingredient object
                            if ( ! in_array(null, $request->input('ingredients.' . $i), true) ) {
                                $ingredient = Ingredient::firstOrCreate([
                                    'name' => $request->input('ingredients.' . $i . '.name'),
                                ]);
                                // Get Measurement
                                $measurement = $request->input('ingredients.' . $i . '.pivot.measurement');
                                // Create relationship in pivot table with measurement
                                $meal->ingredients()->attach([$ingredient->id => ['measurement' => $measurement]]);
                            }
                        }
                    }
                }

                // Add Tools
                if($request->input('tools.0')) {
                    if ( ! in_array(null, $request->input('tools.0'), true) ) {
                        $toolCount = count($request->input('tools'));
                        for ( $i = 0; $i < $toolCount; $i++ ) {
                            if ( ! in_array(null, $request->input('tools.' . $i), true) ) {
                                // Create the tool if it doesnt exit, else return tool object
                                $tool = Tool::firstOrCreate([
                                    'name' => $request->input('tools.' . $i . '.name'),
                                ]);
                                // Create relationship in pivot table with measurement
                                $meal->tools()->attach([$tool->id]);
                            }
                        }
                    }
                }

                // Add Allergens
                if($request->input('allergens.0')) {
                    if ( ! in_array(null, $request->input('allergens.0'), true) ) {
                        $allergenCount = count($request->input('allergens'));
                        for ( $i = 0; $i < $allergenCount; $i++ ) {
                            if ( ! in_array(null, $request->input('allergens.' . $i), true) ) {
                                // Create the allergen if it doesnt exit, else return allergen object
                                $allergen = Allergen::firstOrCreate([
                                    'name' => $request->input('allergens.' . $i . '.name'),
                                ]);
                                // Create relationship in pivot table with measurement
                                $meal->allergens()->attach([$allergen->id]);
                            }
                        }
                    }
                }

                // Set Country
                if($request->input('countries')) {
                    $countryCount = count($request->input('countries'));
                    for ( $i = 0; $i < $countryCount; $i++ ) {
                        // Create relationship in pivot table with measurement
                        $country = Country::where('code', $request->input('countries.' . $i))->firstOrFail();

                        $meal->countries()->attach([$country->id]);
                    }
                }

                DB::commit();

                flash('Meal Created')->success();

                return true;

            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

                return redirect()->back();
            }
        }

        /**
         * Display the meal
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id) {
            $meal = Meal::with(['image', 'recipeSteps', 'tools', 'allergens', 'ingredients'])->find($id);

            return view('admin.meals.meals-show', compact('meal'));
        }

        /**
         * Display the specified meal on the front end
         *
         * @param \App\Meal $meal
         * @return \Illuminate\Http\Response
         */
        public function showFront(Meal $meal) {
            $meal = Meal::with(['image', 'recipeSteps', 'tools', 'allergens', 'ingredients'])->find($meal->id);

            // Get country to display featured meals for meal page
            if(inAmerica()){
                $countryCode = 'usa';
            }else{
                $countryCode = 'cad';
            }

            $featuredMeals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
                $e->where('code', $countryCode);
            })
                ->where('id', '!=', $meal->id)
                ->inRandomOrder()
                ->limit(3)
                ->get();

            return view('meals.meals-show', compact('meal', 'featuredMeals'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id) {
            $chefs = Chef::orderBy('name', 'desc')->get();
            $meal = Meal::with(['recipeSteps', 'ingredients', 'tools', 'allergens', 'image', 'countries'])->find($id);
            $countries = $meal->countries;

            $countryCodes = array();
            foreach($countries as $c){
                $countryCodes[] = $c->code;
            }

            return view('admin.meals.meals-create', compact('chefs', 'meal', 'countryCodes'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id) {

            if ( $request->publish == '1' ) { // If trying to publish
                // Details Rules
                $rules = [
                    'title'       => 'required|string|max:255|unique:meals,title,' . $id,
                    'sub_title'   => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'time'        => 'required|numeric',
                    'servings'    => 'required|numeric',
                    'calories'    => 'required|numeric',
                    'fat'         => 'required|numeric',
                    'carbs'       => 'required|numeric',
                    'protein'     => 'required|numeric',
                    // 'start_date'  => 'required|date_format:Y-m-d',
                    // 'end_date'    => 'required|date_format:Y-m-d',
                    'sku'         => 'nullable|string|unique:meals,sku,' . $id,
                    'inventory'   => 'nullable|numeric',
                    'chef_id'     => 'nullable|numeric',
                ];

                // Recipe Rules
                if ( $request->input('recipes') ) {
                    $rules['recipes.*.title'] = 'required|string';
                    $rules['recipes.*.description'] = 'required|string';
                }

                // Ingredient Rules
                if ( $request->input('ingredients') ) {
                    $rules['ingredients.*.pivot.measurement'] = 'required';
                    $rules['ingredients.*.name'] = 'required|string';
                }

                // Tool Rules
                if ( $request->input('tools') ) {
                    $rules['tools.*.name'] = 'required';
                }

                // Allergen Rules
                if ( $request->input('allergens') ) {
                    $rules['allergens.*.name'] = 'required';
                }

                $this->validate(request(), $rules);
            } else { // Saving as draft

                $rules = [
                    'title' => 'required|string|max:255|unique:meals,title,' . $id,
                ];

                $this->validate(request(), $rules);
            }

            try {
                DB::beginTransaction();

                $meal = Meal::find($id);

                $meal->title = $request->input('title');
                $meal->sub_title = $request->input('sub_title');
                $meal->description = $request->input('description');
                $meal->time = $request->input('time');
                $meal->calories = $request->input('calories');
                $meal->fat = $request->input('fat');
                $meal->carbs = $request->input('carbs');
                $meal->protein = $request->input('protein');
                $meal->servings = $request->input('servings');
                $oldMealImageId = $meal->image_id; // Get old image id
                $meal->image_id = $request->input('image_id');
                $meal->inventory = $request->input('inventory');
                $meal->sku = $request->input('sku');
                $meal->premium = $request->input('premium') ? $request->input('premium') : 0;
                $meal->published = $request->input('publish');
                $meal->start_date = $request->input('start_date');
                $meal->end_date = $request->input('end_date');
                $meal->chef_id = $request->input('chef_id');

                $meal->save();

                // Attach image to the meal
                if ( $request->input('image_id') != $oldMealImageId ) {
                    // Delete the old image
                    if($oldMealImageId){
                    $oldimage = Image::find($oldMealImageId);
                    $oldImagePath = $oldimage->src . $oldimage->filename;
                    File::delete(public_path($oldImagePath));
                    $oldimage->delete();
                    }

                    // Add the new image
                    $image = Image::find($request->input('image_id'));
                    $image->imageable_type = 'App\Meal';
                    $image->imageable_id = $meal->id;
                    $image->save();
                }

                // Update Recipe steps
                // Delete the old ones
                $oldRecipeSteps = RecipeStep::where('meal_id', $meal->id)->get();
                foreach ( $oldRecipeSteps as $step ) {
                    $step->delete();
                }

                // Add Recipe Steps
                if ( $request->input('recipes') ) {
                    $recipeStepCount = count($request->input('recipes'));
                    $step = 1;
                    for ( $i = 0; $i < $recipeStepCount; $i++ ) {
                        RecipeStep::create([
                            'meal_id'     => $meal->id,
                            'step'        => $step,
                            'title'       => $request->input('recipes.' . $i . '.title'),
                            'description' => $request->input('recipes.' . $i . '.description'),
                        ]);
                        $step++;
                    }
                }

                // Detach old ingredients
                $meal->ingredients()->detach();

                // Add Ingredients
                if ( $request->input('ingredients') ) {
                    $ingredientCount = count($request->input('ingredients'));
                    for ( $i = 0; $i < $ingredientCount; $i++ ) {
                        // Create the ingredient if it doesnt exit, else return ingredient object
                        $ingredient = Ingredient::firstOrCreate([
                            'name' => $request->input('ingredients.' . $i . '.name'),
                        ]);
                        // Get Measurement
                        $measurement = $request->input('ingredients.' . $i . '.pivot.measurement');
                        // Create relationship in pivot table with measurement
                        $meal->ingredients()->attach([$ingredient->id => ['measurement' => $measurement]]);
                    }
                }

                // Detach old tools
                $meal->tools()->detach();
                // Add Tools
                if ( $request->input('tools') ) {
                    $toolCount = count($request->input('tools'));
                    for ( $i = 0; $i < $toolCount; $i++ ) {
                        // Create the tool if it doesnt exit, else return tool object
                        $tool = Tool::firstOrCreate([
                            'name' => $request->input('tools.' . $i . '.name'),
                        ]);
                        // Create relationship in pivot table with measurement
                        $meal->tools()->attach([$tool->id]);
                    }
                }

                // Detach old allergens
                $meal->allergens()->detach();
                // Add Allergens
                if ( $request->input('allergens') ) {
                    $allergenCount = count($request->input('allergens'));
                    for ( $i = 0; $i < $allergenCount; $i++ ) {
                        // Create the allergen if it doesnt exit, else return allergen object
                        $allergen = Allergen::firstOrCreate([
                            'name' => $request->input('allergens.' . $i . '.name'),
                        ]);
                        // Create relationship in pivot table with measurement
                        $meal->allergens()->attach([$allergen->id]);
                    }
                }

                // Detach old allergens
                $meal->countries()->detach();
                // Add Countries
                if($request->input('countries')) {
                    $countryCount = count($request->input('countries'));
                    for ( $i = 0; $i < $countryCount; $i++ ) {
                        // Create relationship in pivot table with measurement
                        $country = Country::where('code', $request->input('countries.' . $i))->firstOrFail();

                        $meal->countries()->attach([$country->id]);
                    }
                }

                DB::commit();

                flash('Meal Updated')->success();

                return true;
            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to update meal.');

                return redirect()->back();
            }
        }

        /**
         * Remove the meal from storage.
         *
         * @param int $request
         * @return \Illuminate\Http\Response
         */
        public function destroy(Request $request) {
            $meal = Meal::with(['recipeSteps', 'ingredients', 'tools', 'allergens', 'image'])->find($request->input('meal_id'));

            DB::beginTransaction();
            $meal->recipeSteps()->delete();
            $meal->ingredients()->delete();
            $meal->tools()->delete();
            $meal->allergens()->delete();

            if ( $meal->image ) {
                $imagePath = $meal->image->src . $meal->image->filename;
                File::delete(public_path($imagePath));
                $meal->image_id = null;
                $meal->save();
                $meal->image()->delete();
            }

            // We need to replace the box items with a new meal if we are deleting this one so get a new meal
            $mealReplacement = Meal::inRandomOrder()->first();

            // Get all box items with this meal
            $boxItems = BoxItem::where('itemable_id', $meal->id)->get();

            // Replace these boxitems with this meal replacement
            foreach($boxItems as $item){
                $item->itemable_id = $mealReplacement->id;
                $item->save();
            }

            // now delete the meal
            $meal->delete();

            DB::commit();

            flash('Meal Deleted')->success();

            return redirect()->route('admin.meals.index');
        }
    }
