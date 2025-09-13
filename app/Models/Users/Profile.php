<?php


namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // Asegúrate de importar el modelo User
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Profile extends Model
{
    protected $table = 'Profile';
    protected $fillable = ['id_profile', 'name', 'description'];
}