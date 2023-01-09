<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function BankDetail()
    {
        return $this->belongsTo(BankDetail::class, 'bank_detail_id', 'id');
    }
}
