<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'done'];

    public function users() // muss mehrzahl sein bei n zu m weil es mehrere sind
    {
        return $this->belongsToMany(User::class); //n:m
    }

    //scopeSearch im Model -> search()
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', $term)
            ->orWhere('description', 'like', $term);
        });
    }
}

