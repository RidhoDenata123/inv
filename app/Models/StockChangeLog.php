<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockChangeLog extends Model
{
    use HasFactory;

    // Gunakan stock_change_log_id sebagai primary key
    protected $primaryKey = 'stock_change_log_id';

    // Non-incrementing jika stock_change_log_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'stock_change_log_id',
        'stock_change_type',
        'product_id',
        'reference_id',
        'qty_before',
        'qty_changed',
        'qty_after',
        'changed_at',
        'changed_by',
        'change_note',
        
    ];
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

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }
    
}
