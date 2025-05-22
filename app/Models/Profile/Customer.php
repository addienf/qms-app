<?php

namespace App\Models\Profile;

use App\Models\Sales\URS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'department',
        'phone_number',
        'company_name',
        'company_address',
    ];

    public function urs()
    {
        return $this->hasMany(URS::class, 'customer_id');
    }
}
