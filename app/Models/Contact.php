<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User memiliki banyak contact, satu contact dimiliki satu user
 */
/**
 * Contact memiliki banyak address, satu address dimiliki satu contact
 */
class Contact extends Model
{
    protected $table = "contacts";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Contact::class, "user_id", "id");
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, "contact_id", "id");
    }

    public function scopeSearch($query, $name, $email, $phone)
    {
        return
            $query->where(function ($builder) use ($name) {
                $builder->where('first_name', 'like', '%' . $name . '%')
                    ->orWhere('last_name', 'like', '%' . $name . '%');
            })
            ->when($email, function ($query) use ($email) {
                return $query->where('email', 'like', '%' . $email . '%');
            })
            ->when($phone, function ($query) use ($phone) {
                return $query->where('phone', 'like', '%' . $phone . '%');
            });
    }
}
