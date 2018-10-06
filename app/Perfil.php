<?php

namespace App;

use App\Usuario;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}
