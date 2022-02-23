<?php

    namespace App\Http\Controllers;

    use App\Allergen;
    use App\Image;
    use App\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;


    class ProductController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $products = Product::with(['image'])->get();

            return view('admin.products.products-index', compact('products'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create() {
            $product = null;

            return view('admin.products.products-create', compact('product'));
        }

        /**
         * Store a newly created resource in storage.
         * todo: Save type
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request) {
            if ( $request->publish == '1' ) {
                // Details Rules
                $rules = [
                    'title'       => 'required|string|unique:products,title|max:255',
                    'sub_title'   => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'calories'    => 'required|numeric',
                    'fat'         => 'required|numeric',
                    'carbs'       => 'required|numeric',
                    'protein'     => 'required|numeric',
                    'weight'      => 'required|numeric',
                    'sku'         => 'nullable|string',
                    'inventory'   => 'nullable|numeric',
                    'price'       => 'nullable|numeric',
                ];

                // Allergen Rules
                if ( $request->input('allergens') ) {
                    $rules['allergens.*.name'] = 'required';
                }

                $this->validate(request(), $rules);
            } else {

                $rules = [
                    'title' => 'required|string|unique:products,title|max:255',
                ];

                $this->validate(request(), $rules);
            }
            try {
                DB::beginTransaction();

                $price = $request->input('price') * 100; //convert to cents

                $product = Product::create([
                    'title'       => $request->input('title'),
                    'sub_title'   => $request->input('sub_title'),
                    'description' => $request->input('description'),
                    'calories'    => $request->input('calories'),
                    'fat'         => $request->input('fat'),
                    'carbs'       => $request->input('carbs'),
                    'protein'     => $request->input('protein'),
                    'weight'      => $request->input('weight'),
                    'image_id'    => $request->input('image_id'),
                    'inventory'   => $request->input('inventory'),
                    'sku'         => $request->input('sku'),
                    'price'       => $price,
                    'published'   => $request->input('publish'),
                    'type'        => null,
                ]);

                //Attach image to the product
                if ( $request->input('image_id') > 0 ) {
                    $image = Image::find($request->input('image_id'));
                    $image->imageable_type = 'App\Product';
                    $image->imageable_id = $product->id;
                    $image->save();
                }

                // Add Allergens
                if ( ! in_array(null, $request->input('allergens.0'), true) ) {
                    $allergenCount = count($request->input('allergens'));
                    for ( $i = 0; $i < $allergenCount; $i++ ) {
                        if ( ! in_array(null, $request->input('allergens.' . $i), true) ) {
                            // Create the allergen if it doesnt exit, else return allergen object
                            $allergen = Allergen::firstOrCreate([
                                'name' => $request->input('allergens.' . $i . '.name'),
                            ]);
                            // Create relationship in pivot table with measurement
                            $product->allergens()->attach([$allergen->id]);
                        }
                    }
                }

                DB::commit();

                flash('Product Created')->success();

                return true;
            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to create product.');

                return redirect()->back();
            }
        }

        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id) {
            $product = Product::with(['image', 'allergens'])->find($id);

            return view('admin.products.products-show', compact('product'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id) {
            $product = Product::with(['allergens', 'image'])->find($id);

            return view('admin.products.products-create', compact('product'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id) {
            if ( $request->publish == '1' ) {
                // Details Rules
                $rules = [
                    'title'       => 'required|string|max:255|unique:products,title,' . $id,
                    'sub_title'   => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'calories'    => 'required|numeric',
                    'fat'         => 'required|numeric',
                    'carbs'       => 'required|numeric',
                    'protein'     => 'required|numeric',
                    'weight'      => 'required|numeric',
                    'sku'         => 'nullable|string',
                    'inventory'   => 'nullable|numeric',
                    'price'       => 'nullable|numeric',
                ];

                // Allergen Rules
                if ( $request->input('allergens') ) {
                    $rules['allergens.*.name'] = 'required';
                }

                $this->validate(request(), $rules);
            } else {

                $rules = [
                    'title' => 'required|string|max:255|unique:products,title,' . $id,
                ];

                $this->validate(request(), $rules);
            }
            try {
                DB::beginTransaction();

                $price = $request->input('price') * 100; //convert to cents

                $product = Product::find($id);
                $product->title = $request->input('title');
                $product->sub_title = $request->input('sub_title');
                $product->description = $request->input('description');
                $product->calories = $request->input('calories');
                $product->fat = $request->input('fat');
                $product->carbs = $request->input('carbs');
                $product->protein = $request->input('protein');
                $product->weight = $request->input('weight');
                $oldProductImageId = $product->image_id;
                $product->image_id = $request->input('image_id');
                $product->inventory = $request->input('inventory');
                $product->sku = $request->input('sku');
                $product->price = $price;
                $product->published = $request->input('publish');
                $product->type = null;

                $product->save();

                //Attach image to the product
                if ( $request->input('image_id') != $oldProductImageId ) {
                    // Delete the old image
                    $oldimage = Image::find($oldProductImageId);
                    $oldImagePath = $oldimage->src . $oldimage->filename;
                    File::delete(public_path($oldImagePath));
                    $oldimage->delete();

                    // Add the new image
                    $image = Image::find($request->input('image_id'));
                    $image->imageable_type = 'App\Product';
                    $image->imageable_id = $product->id;
                    $image->save();
                }

                // Detach old allergens
                $product->allergens()->detach();
                // Add Allergens
                if ( $request->input('allergens') ) {
                    $allergenCount = count($request->input('allergens'));
                    for ( $i = 0; $i < $allergenCount; $i++ ) {
                        // Create the allergen if it doesnt exit, else return allergen object
                        $allergen = Allergen::firstOrCreate([
                            'name' => $request->input('allergens.' . $i . '.name'),
                        ]);
                        // Create relationship in pivot table with measurement
                        $product->allergens()->attach([$allergen->id]);
                    }
                }

                DB::commit();

                flash('Product Updated')->success();

                return true;
            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to create product.');

                return redirect()->back();
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $request
         * @return \Illuminate\Http\Response
         */
        public function destroy(Request $request) {
            $product = Product::with(['allergens', 'image'])->find($request->input('product_id'));

            DB::beginTransaction();
            $product->allergens()->delete();

            if($product->image){
                $imagePath = $product->image->src . $product->image->filename;
                File::delete(public_path($imagePath));
                $product->image_id = null;
                $product->save();
                $product->image()->delete();
            }


            $product->delete();

            DB::commit();

            flash('Product Deleted')->success();

            return redirect()->route('admin.products.index');
        }
    }
