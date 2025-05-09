<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingHeader extends Model
{
    use HasFactory;

    // Gunakan receiving_header_id sebagai primary key
    protected $primaryKey = 'receiving_header_id';

    // Non-incrementing jika receiving_header_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'receiving_header_id',
        'receiving_header_name',
        'receiving_header_description',
        'created_by',
        'receiving_header_status',
        'confirmed_by',
        'confirmed_at',
    ];

        //
        public function header()
        {
            return $this->belongsTo(ReceivingHeader::class, 'receiving_header_id', 'receiving_header_id');
        }

        // Relasi ke ReceivingDetail
        public function details()
        {
            return $this->hasMany(ReceivingDetail::class, 'receiving_header_id', 'receiving_header_id');
        }
        
            public function receivingDetails()
        {
            return $this->hasMany(ReceivingDetail::class, 'receiving_header_id', 'receiving_header_id');
        }
}
