<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiporderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'note',
        'quantity',
        'price',
        'shiporder_id',
    ];


}
