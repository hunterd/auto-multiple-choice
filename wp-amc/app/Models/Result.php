<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $guarded = [];
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
