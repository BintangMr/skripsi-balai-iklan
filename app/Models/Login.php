<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['email', 'password', 'role'];

    public function pelanggan() {
        return $this->hasOne(Pelanggan::class, 'login_id');
    }
}
