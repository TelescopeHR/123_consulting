<?php

namespace App\Traits;

use App\Models\Slug;
use Illuminate\Support\Str;

trait SlugTrait
{
    /**
     * @param $slug
     * @param $id
     * @return mixed
     */
    function createUniqueSlug($slug, $id = 0)
    {
        if (Slug::whereSlug($slug)->where('id', '<>', $id)->exists()) {
            if (is_numeric($slug[-1])) {
                $new_slug = preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $slug);

                return $this->createUniqueSlug($new_slug, $id);
            }

            return $this->createUniqueSlug("{$slug}-1", $id);
        }

        return $slug;
    }
}
