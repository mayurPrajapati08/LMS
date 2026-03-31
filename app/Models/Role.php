<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    // One role has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
