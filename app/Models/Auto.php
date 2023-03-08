<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Auto extends Model
{
    protected $table = 'auto';

    protected $fillable = [
        'user_name',
        'state_number',
        'color',
        'vin_code',
    ];

}
