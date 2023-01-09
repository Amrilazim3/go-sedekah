<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bank()
    {
        return $this->hasMany(Bank::class);
    }
}
