<?php

namespace App\Http\Controllers;

use App\Image;
use App\Meal;
use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Imageintervention;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ImageController extends Controller
{
    use ImageTrait;

    /**
     * Upload image
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'image' => 'required|image64:jpeg,jpg,png'
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            if (!file_exists('images/uploads/')) {
                mkdir('images/uploads/', 666, true);
            }
            Imageintervention::make($request->get('image'))->save(public_path('images/uploads/') . $fileName);

            // Create a new image in db
            $image = Image::create([
                'filename'  => $fileName,
                'extension' => '',
                'src'       => '/images/uploads/',
                'mime_type' => '',
                'file_size' => '',
            ]);

            DB::commit();

            flash('Meal Created')->success();

            return $image;

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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        // Find the image
        DB::beginTransaction();
        $image = Image::find($id);

        $meal = Meal::where('image_id', $id)->get();

        foreach($meal as $m){
            $m->image_id = null;
            $m->save();
        }

        // Get image path w/ thumbnails
        $imageNames = [
            $image->src.$image->filename,
        ];

        // Delete all image files
        foreach ($imageNames as $imageName) {
            File::delete(public_path($imageName));
        }

        // Delete image from DB
        $image->delete();
        DB::commit();

        return true;
    }
}
