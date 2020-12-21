<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'size',
        'async',
        'date_processed'
    ];

    /**
     * Return Asynchronous and Unprocessed
     * @return mixed
     */
    public static function scopeAsyncUnprocessed()
    {
        return static::where('async', '=', true)
            ->whereNull('date_processed');
    }
}
