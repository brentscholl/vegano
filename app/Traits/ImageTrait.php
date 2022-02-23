<?php

    namespace App\Traits;

    use App\Image;
    use Illuminate\Support\Facades\File;

    trait ImageTrait
    {
        /**
         * Removes an image from server and DB
         *
         * @param $id
         */
        function removeImage($id)
        {
            // Find the image
            $image = Image::find($id);

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
        }
    }
