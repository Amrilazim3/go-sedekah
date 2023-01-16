<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donationRequest()
    {
        return $this->belongsTo(DonationRequest::class);
    }

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: function () {
                return Carbon::parse(
                    $this->attributes['created_at']
                )->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i');
            }
        );
    }
}
