<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = [];
    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
