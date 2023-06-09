<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'author',
        'category_id',
        'image',
        'status',
        'blog',
        'media_above_desc'
    ];

    public function categories(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function getMedia(){
        return $this->hasMany(Media::class,'blog_id','id');
    }
}
