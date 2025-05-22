<?php

namespace App\Models\sales;

use App\Models\Profile\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URS extends Model
{
    use HasFactory;
    protected $table = 'urs';
    protected $fillable = ['no_urs', 'customer_id', 'remark_permintaan_khusus'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function specificationProducts()
    {
        return $this->hasMany(SpesifikasiProduct::class);
    }
}
