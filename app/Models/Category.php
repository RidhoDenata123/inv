<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Gunakan category_id sebagai primary key
    protected $primaryKey = 'category_id';

    // Non-incrementing jika category_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'category_name',
        'category_description',
    ];
}
