<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User memiliki banyak contact, satu contact dimiliki satu user
 */
class User extends Model implements Authenticatable
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

    public function getAuthIdentifierName()
    {
        return "username";
    }

    public function getAuthIdentifier()
    {
        return $this->username;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        // hanya dummy
        return $this->token;
    }

    public function setRememberToken($value)
    {
        $this->token = $value;   
    }

    public function getRememberTokenName()
    {
        return "token";
    }
}
