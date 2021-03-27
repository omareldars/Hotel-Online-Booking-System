<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'floor_id', 'id');
    }

    // public function getAdminIdAttribute($floor_id)
    // {
    //     return Admin::findOrFail($floor_id)->name;
    // } // make relationship between room and user
}
