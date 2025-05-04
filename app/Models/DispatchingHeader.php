<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchingHeader extends Model
{
    use HasFactory;

    // Gunakan dispatching_header_id sebagai primary key
    protected $primaryKey = 'dispatching_header_id';

    // Non-incrementing jika dispatching_header_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'dispatching_header_id',
        'dispatching_header_name',
        'customer_id',
        'dispatching_header_description',
        'created_by',
        'dispatching_header_status',
        'confirmed_by',
        'confirmed_at',
    ];

        //
        public function header()
        {
            return $this->belongsTo(DispatchingHeader::class, 'dispatching_header_id', 'dispatching_header_id');
        }

        // Relasi ke Dispatching Detail
        public function details()
        {
            return $this->hasMany(DispatchingDetail::class, 'dispatching_header_id', 'dispatching_header_id');
        }
    
}
