<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory;

    // Gunakan company_id sebagai primary key
    protected $primaryKey = 'company_id';

    // Non-incrementing jika company_id bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'company_name',
        'company_description',
        'company_address',
        'company_phone',
        'company_fax',
        'company_email',
        'company_website',
        'company_img',
        'company_currency',
        'company_bank_account',
    ];
}
