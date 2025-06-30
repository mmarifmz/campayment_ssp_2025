<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YuranFamily extends Model
{
    protected $connection = 'yuranpibg';
    protected $table = 'families';

    protected $fillable = ['student_name'];
    public $timestamps = false;
}