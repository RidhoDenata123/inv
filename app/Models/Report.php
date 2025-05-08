<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Gunakan report_id sebagai primary key
    protected $primaryKey = 'report_id';

    // Non-incrementing jika report_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'report_id',
        'report_type',
        'report_title',
        'report_description',
        'report_document',
        'generated_by',
        
    ];

}
