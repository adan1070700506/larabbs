<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //缓存所有分类
    public function allCache()
    {
        if(is_null(cache('categories'))){
            cache(['categories'=>$this->all()],3600);
        }
        return cache('categories');
    }
}
