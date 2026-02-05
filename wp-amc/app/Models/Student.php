<?php
namespace WpAmc\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $guarded = [];
    public $timestamps = false;

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
