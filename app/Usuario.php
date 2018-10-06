<?php

namespace App;

use App\Perfil;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	protected $hidden = ['email', 'password', '_token'];


    public function rol()
    {
        return $this->belongsTo(Perfil::class);
    }
}
