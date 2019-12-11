<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

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
    ];

    const IS_BANNED = 1;
    const IS_ACTIVE = 0;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        if ($fields['password'] !== null) {
            $user->password = bcrypt($fields['password']);
        }
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        if($fields['password'] !== null){
            $this->password = bcrypt($fields['password']);
        }
        $this->save();
    }

    public function remove()
    {
        if($this->avatar !== null){
            Storage::delete('/uploads/admin/' . $this->avatar);
        }
        $this->delete();
    }

    public function uploadAvatar($avatar)
    {
        if ($avatar === null) return;

        if ($this-> avatar !== null) {
            Storage::delete('/uploads/admin/' . $this->avatar);
        }
        $filename = str_random(10) . '.' . $avatar -> extension();
        $avatar->storeAs('/uploads/admin/', $filename);

        $this->avatar = $filename;
        $this->save();
    }

    public function getImage()
    {
        if ($this->avatar === null) {
            return '/img/no-avatar.png';
        }
        return '/uploads/admin/' . $this->avatar;
    }

    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }

    public function toggleAdmin($value = null)
    {
        if ($value === null) {
            $this->makeNormal();
        } else {
            $this->makeAdmin();
        }
    }

    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan($value = null)
    {
        if ($value === null) {
            $this->unban();
        } else {
            $this->ban();
        }
    }

    public function genereteToken()
    {
        $this -> token = str_random(100);
        $this -> save();
    }
}
