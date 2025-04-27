<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Gunakan supplier_id sebagai primary key
    protected $primaryKey = 'supplier_id';

    // Non-incrementing jika supplier_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id',
        'supplier_name',
        'supplier_description',
        'supplier_address',
        'supplier_phone',
        'supplier_email',
        'supplier_website',
    ];
}
