<?php


namespace App\Http\Controllers\Api\Traits;


trait StoreImages
{
    /**
     * @param $request
     */
    public function storeMainPhoto($request, $model)
    {
        if ($request->main_photo) {
            $model->clearMediaCollection('main_photo');

            $model->addMedia($request->main_photo)->toMediaCollection('main_photo');
        }
    }

    /**
     * @param $request
     * @param $model
     */
    public static function storePhotos($request, $model)
    {
        if ($request->photos) {
            foreach ($request->photos as $photo) {
                $model->addMedia($photo)->toMediaCollection('photos');
            }
        }
    }
}
