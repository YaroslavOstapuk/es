<?php
use App\Helpers\UrlSlugGenerator;
use Illuminate\Database\Eloquent\Model;

// return slug
if (!function_exists('set_slug')) {
    function set_slug(Model $model, $strSlug = null)
    {
        $model->update([
            'slug' => app(UrlSlugGenerator::class)->slugGet($model, $strSlug)
        ]);
    }
}
