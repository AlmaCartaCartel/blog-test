<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    CONST IS_ACTIVE = 0;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    public function remove()
    {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadAvatar($image = null)
    {
        if ($image === null) return;

        Storage::delete('uploads/' . $this->image);

        $filename = str_random(10) . '.' . $image->extension();
        $image->saveAs('uploads', $filename);

        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {
        if ($this->image === null) {
            return 'img/no-avatar.png';
        }
        return 'uploads/' . $this->image;
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

    public function ban(){
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function unban(){
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan($value = null)
    {
        if($value === null){
            $this->unban();
        }else{
            $this->ban();
        }
    }
}
