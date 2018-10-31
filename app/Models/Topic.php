<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'order', 'category_id','excerpt', 'slug'];

    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query,$order)
    {
        switch ($order){
            case 'recent':
                $query->recent();
            default:
                $query->recentRepeied();
        }
        return $query->with('user','category');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }
    public function scopeRecentRepeied($query)
    {
        return $query->orderBy('updated_at','desc');
    }
}
