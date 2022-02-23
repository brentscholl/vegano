<?php

    namespace App\Http\Controllers;

    use App\Chef;
    use App\Image;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;

    class ChefController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $chefs = Chef::with(['image', 'meals'])->get();

            return view('admin.chefs.chefs-index', compact('chefs'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create() {
            $chef = null;

            return view('admin.chefs.chefs-create', compact('chef'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request) {
            if ( $request->publish == '1' ) {
                // Details Rules
                $rules = [
                    'name'        => 'required|string|unique:chefs,name|max:255',
                    'description' => 'nullable|string',
                ];

                $this->validate(request(), $rules);
            } else {

                $rules = [
                    'name' => 'required|string|unique:chefs,name|max:255',
                ];

                $this->validate(request(), $rules);
            }
            try {
                DB::beginTransaction();

                $chef = Chef::create([
                    'name'        => $request->input('name'),
                    'description' => $request->input('description'),
                    'image_id'    => $request->input('image_id'),
                    'published'   => $request->input('publish'),
                ]);

                //Attach image to the chef
                if ( $request->input('image_id') > 0 ) {
                    $image = Image::find($request->input('image_id'));
                    $image->imageable_type = 'App\Chef';
                    $image->imageable_id = $chef->id;
                    $image->save();
                }

                DB::commit();

                flash('Chef Created')->success();

                return true;
            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to create chef.');

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
            $chef = Chef::with(['image'])->find($id);

            return view('admin.chefs.chefs-show', compact('chef'));

        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id) {
            $chef = Chef::with(['image'])->find($id);

            return view('admin.chefs.chefs-create', compact('chefs', 'chef'));
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
                    'name'        => 'required|string|max:255|unique:chefs,name,' . $id,
                    'description' => 'nullable|string',
                ];

                $this->validate(request(), $rules);
            } else {

                $rules = [
                    'name' => 'required|string|max:255|unique:chefs,name,' . $id,
                ];

                $this->validate(request(), $rules);
            }
            try {
                DB::beginTransaction();

                $chef = Chef::find($id);
                $chef->name = $request->input('name');
                $chef->description = $request->input('description');
                $oldChefImageId = $chef->image_id;
                $chef->image_id = $request->input('image_id');
                $chef->published = $request->input('publish');

                $chef->save();

                //Attach image to the meal
                if ( $request->input('image_id') != $oldChefImageId ) {
                    // Delete the old image
                    $oldimage = Image::find($oldChefImageId);
                    $oldImagePath = $oldimage->src . $oldimage->filename;
                    File::delete(public_path($oldImagePath));
                    $oldimage->delete();

                    // Add the new image
                    $image = Image::find($request->input('image_id'));
                    $image->imageable_type = 'App\Chef';
                    $image->imageable_id = $chef->id;
                    $image->save();
                }

                DB::commit();

                flash('Chef Created')->success();

                return true;
            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to create chef.');

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
            $chef = Chef::with(['image'])->find($request->input('chef_id'));

            DB::beginTransaction();
            if($chef->image){
                $imagePath = $chef->image->src . $chef->image->filename;
                File::delete(public_path($imagePath));
                $chef->image_id = null;
                $chef->save();
                $chef->image()->delete();
            }

            $chef->delete();

            DB::commit();

            flash('Chef Deleted')->success();

            return redirect()->route('admin.chefs.index');
        }
    }
