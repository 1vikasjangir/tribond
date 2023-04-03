<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Project;

class ProjectMedia extends Model
{
    use HasFactory;
    protected $table='project_medias';
    protected $primaryKey='id';
    protected $fillable=[
        'project_id',
        'image',
        'status',
    ];

    public function projects(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
