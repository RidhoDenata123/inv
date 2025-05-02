<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingDetail extends Model
{
    use HasFactory;

    // Gunakan receiving_detail_id sebagai primary key
    protected $primaryKey = 'receiving_detail_id';

    // Non-incrementing jika receiving_detail_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'receiving_detail_id',
        'receiving_header_id',
        'product_id',
        'receiving_qty',
        'receiving_detail_status',
        'confirmed_by',
        'confirmed_at',
        'created_by',
    ];
    // Get the receiving header
    public function details()
    {
        return $this->hasMany(ReceivingDetail::class, 'receiving_header_id', 'receiving_header_id');
        
    }
    // Relasi ke ReceivingHeader
    public function header()
    {
        return $this->belongsTo(ReceivingHeader::class, 'receiving_header_id', 'receiving_header_id');
    }
    // Get the existing product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    // Get the category of the product
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category', 'category_id');
    }
    // Get the unit of the product
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'product_unit', 'unit_id');
    }
    // Get the supplier of the product
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}

