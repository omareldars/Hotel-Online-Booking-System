<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'room_id', 'from', 'to', 'accompany_number', 'total' ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }
    
    public function room() {
        return $this->belongsTo( Room::class, 'room_id' );
    }
}
