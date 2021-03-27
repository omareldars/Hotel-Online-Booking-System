<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'size', 'price', 'floor', 'reservation', 'user_id', 'admin_id', 'floor_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    } // make relationship between room and user

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    } // make relationship between room and user

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function getFloorIdAttribute($floor_id)
    {
        return Floor::findOrFail($floor_id)->number;
    } // make relationship between room and user

    public function getReservationAttribute($reservation)
    {
        return $reservation == 0 ? 'not reservation' : 'reservation By | ' . User::findOrFail($reservation)->name;
    } // make relationship between room and user

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromDate($date)->diffForHumans();
    } // To Return The Image Path

    // public function getAdminIdAttribute($admin_id)
    // {
    //     return Admin::findOrFail($admin_id)->name;
    // } // To Return The Image Path
}
