<?php

namespace App\Models;
use App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table='medias';
    protected $primaryKey='id';
    protected $fillable=[
        'type',
        'blog_id',
        'file',
        'status',
    ];

    public function blogs(){
        return $this->belongsTo(Blog::class,'blog_id','id');
    }
}
