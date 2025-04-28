<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Gunakan customer_id sebagai primary key
    protected $primaryKey = 'customer_id';

    // Non-incrementing jika customer_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_description',
        'customer_address',
        'customer_phone',
        'customer_email',
        'customer_website',
    ];
}
