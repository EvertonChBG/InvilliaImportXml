<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shiporder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'person_id',
        'shipto'
    ];

    protected $casts = [
        'shipto' => 'array',
    ];

    /**
     * Return shiporder items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ShiporderItem::class);
    }
}
