<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    // Gunakan account_id sebagai primary key
    protected $primaryKey = 'account_id';

    // Non-incrementing jika account_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'account_name',
        'bank_name',
    ];
}
