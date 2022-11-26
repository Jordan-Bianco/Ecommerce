<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{

    public static function bootSluggable()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
