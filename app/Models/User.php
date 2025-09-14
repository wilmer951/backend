<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Users\Rol;
use App\Models\Users\Profile;
use App\Models\Users\Module;


class User extends Model implements AuthenticatableContract, JWTSubject, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = ['username', 'name', 'email', 'password',  'profile_id','status', 'last_login'];

    protected $hidden = ['password'];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_user', 'user_id', 'rol_id');
    }

    public function profile()
    {
        // El 'foreign key' es 'profile_id' en la tabla 'users'
        return $this->belongsTo(Profile::class, 'profile_id');
    }


   public function hasModule($moduleName)
            {
                 return $this->roles()->whereHas('modules', function ($q) use ($moduleName) {
                        $q->where('name', $moduleName);
                    })->exists();
            }

    // Métodos requeridos por JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
