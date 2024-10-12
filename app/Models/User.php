<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{

    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function registration()
    {
        return $this->hasOne(Registration::class);
    }

}
