<?php


namespace App\Traits\Model;


use App\Category;

trait Categorizable
{
    public function category()
    {
        return $this->morphTo(Category::class, 'categorize');
    }
}