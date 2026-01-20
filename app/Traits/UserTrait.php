<?php
namespace App\Traits;
use Storage;
use Auth;
trait UserTrait {
    public function getProfilelinkAttribute()
    {
        return route('panel.users.edit', ['user' => $this->id]);
    }

    public function getAvatarlinkAttribute()
    {
        if(Storage::exists($this->avatar))
        {
            return asset(Storage::url($this->avatar));
        }
        return asset('assets/img/avatar/avatar-1.png');
    }

    public function getIsmeAttribute()
    {
        if(Auth::check() && Auth::id() == $this->id)
        {
            return true;
        }
        return false;
    }
}
