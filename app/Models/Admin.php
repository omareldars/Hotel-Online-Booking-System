<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class Admin extends Authenticatable
{
    use LaratrustUserTrait, HasFactory, Notifiable;

    protected $guard = [];
    protected $fillable = ['name', 'email', 'password', 'created_by', 'image', 'phone', 'national_id', 'banned'];

    protected $hidden = [ 'password'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'created_by', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'admin_id', 'id');
    } // make relationship between room and user

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/images/admins/' . $this->image);
    } // To Return The Image Path

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromDate($date)->diffForHumans();
    } // To Return The Image Path

    // public function getCreatedByAttribute($created_by)
    // {
    //     return $created_by == 0 ? '--' : Admin::findOrFail($created_by)->name ;
    // } // To Return The Image Path
}
