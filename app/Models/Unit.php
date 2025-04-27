<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    // Gunakan unit_id sebagai primary key
    protected $primaryKey = 'unit_id';

    // Non-incrementing jika unit_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'unit_id',
        'unit_name',
        'unit_description',
    ];
}
