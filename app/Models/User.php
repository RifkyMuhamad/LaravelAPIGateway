<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User memiliki banyak contact, satu contact dimiliki satu user
 */
class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        "username",
        "password",
        "name"
    ];

    /**
     * user_id dari table contacts
     * id dari table users
     */
    public function contacts():HasMany
    {
        return $this->hasMany(Contact::class, "user_id", "id");
    }
}
