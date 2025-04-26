<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Gunakan product_id sebagai primary key
    protected $primaryKey = 'product_id';

    // Non-incrementing jika product_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_name',
        'product_category',
        'product_description',
        'product_qty',
        'purchase_price',
        'selling_price',
        'product_unit',
        'product_img',
        'supplier_id',
        'product_status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category', 'category_id');
    }
}
