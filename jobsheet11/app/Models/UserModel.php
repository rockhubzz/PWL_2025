<?php

namespace App\Models;

use App\Models\LevelModel;
// use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan oleh model ini

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'foto_profil',
        'image'
    ];
    public function level():BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    public function stok()
    {
        return $this->hasMany(StokModel::class, 'user_id', 'user_id');
    }

    public function getRoleName(): string
     {
         return $this->level->level_nama;
     }
 
     public function hasRole(string $role): bool
     {
         return $this->level->level_kode === $role;
     }

    public function getRole() 
    {
       return $this->level->level_kode;
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
    
    protected function image(){
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image)
        );
    }
}