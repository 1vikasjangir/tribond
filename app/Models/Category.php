<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;




class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    //protected $primaryKey='id';
    protected $fillable=[
        'title',
        'description',
        'status',
        'slug',
        'meta_title',
        'meta_desc'
    ];

    public function posts(){
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }
}
