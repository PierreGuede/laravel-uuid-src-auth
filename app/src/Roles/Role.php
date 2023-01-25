<?php

namespace App\src\Roles;

use App\Models\User;
use App\Traits\UUIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, UUIDTrait;
    protected $fillable=[
        'name',
        'identifier'
    ];
    public function user ():HasMany{
        return $this->hasMany(User::class);
    }
}
