<?php

namespace App;

use App\Http\Controllers\UserServicesController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    use UserTrait;
    use SoftDeletes;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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

        return [
            'user' => $this->only(['id', 'name', 'email', 'status']),
            'envatoelements' => UserServicesController::getServiceInfos('envatoelements')['downs'] > 0,
            'freepik' => UserServicesController::getServiceInfos('freepik')['downs'] > 0,
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'status', 'avatar', 'username','balance'
    ];

    protected $appends = ['allPermissions', 'profilelink', 'avatarlink', 'isme'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getAllpermissionsAttribute()
    {
        $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach ($allPermissions as $p) {
            $res[] = $p->name;
        }
        return $res;
    }

    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function getMeta($key)
    {
        if ($this->metas->meta($key)) {
            return $this->metas->meta($key)->value;
        }
        return false;
    }
}

class UserMeta extends Model
{
    protected $table = "user_meta";
    protected $guarded = [];
}
