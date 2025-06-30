<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama',
        'kelas',
        'jawatan',
        'ic',
        'jantina',
        'agama',
        'telefon',
        'email',
        'alergik',
        'sumbangan',
        'total_amount',
        'bill_code',
        'bill_ref',
        'is_paid',
    ];
}