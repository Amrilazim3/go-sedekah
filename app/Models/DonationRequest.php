<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    protected $appends = [
        'progress'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function setVerificationExpiryDate()
    {
        $this->verification_expiry_at = Carbon::now()->addDays(7);
    }

    protected function progress(): Attribute
    {
        return new Attribute(
            get: function () {
                $percent = number_format(
                    ($this->currently_received / $this->target_amount) * 100,
                    0
                );
                return $percent . "%";
            }
        );
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

    protected function verificationExpiryAt(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->attributes['verification_expiry_at']
                    ? Carbon::parse(
                        $this->attributes['verification_expiry_at']
                    )->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i')
                    : null;
            }
        );
    }
}
