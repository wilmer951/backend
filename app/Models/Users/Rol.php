<?php


namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // Asegúrate de importar el modelo User
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rol extends Model
{
    protected $table = 'rol';  // Aquí aseguramos que la tabla sea "roles"
    protected $fillable = ['id_rol', 'name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'rol_user', 'rol_id', 'user_id');
    }
}