<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Account extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;
    protected $table='users';
    protected $fillable=['role_id','google_id','username','password','email','phone','gender','facebook_id',
    'address','birthday','first_name','last_name','status','avatar','last_login','last_logout','remember_token'];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
