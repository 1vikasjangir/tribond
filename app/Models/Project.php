<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table= 'projects';
    protected $primaryKey='id';


    protected $fillable=[
        'id',
        'title',
        'description',
        'status',
        'thumbnail',
        'main_image',
        'hash_tags',
        'sort_order',
        'status',
        'fullwidth_image'
    ];

    public function getProjectMedia(){
        return $this->hasMany(ProjectMedia::class,'project_id','id');
    }
}
