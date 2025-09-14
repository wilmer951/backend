<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Rol;



class Module extends Model
{
    protected $table = 'module'; // nombre de la tabla
    protected $fillable = ['nombre']; // columnas que puedes asignar masivamente

    // Relación muchos a muchos con Rol
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_module', 'rol_id', 'module_id');
    }
}
