<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Banner extends Model
{
    public function setImageUrlAttribute($file_name)
    {
        if (str_contains($file_name, 'http')) {
            $parser_url = explode('/', $file_name);
            $file_name = end($parser_url);
        }

        $this->attributes['image_url'] = 'uploads/banners/'.$file_name;
    }

    public function getImageUrlAttribute($file_name)
    {
        return cdn($file_name);
    }

    public static function allByPosition()
    {
        $return = [];
        $data   = Banner::orderBy('position', 'desc')
                        ->orderBy('order', 'desc')
                        ->get();

        foreach ($data as $banner) {
            $return[$banner->position][] = $banner;
        }
        return $return;
    }
}
