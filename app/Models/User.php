<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'user_type', 'gender', 'blocked', 'photo_url'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'blocked' => 'boolean',
        ];
    }

    //Relação Customer-user
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'id');
    }

    public function isAdministrador(): bool
    {
        return $this->user_type === 'A';
    }
    public function isCliente(): bool
    {
        return $this->user_type === 'C';
    }

    public function isFuncionario(): bool
    {
        return $this->user_type === 'F';
    }

    public function isMasculino(): bool
    {
        return $this->gender === 'M';
    }

    public function isFeminino(): bool
    {
        return $this->gender === 'F';
    }

    public function isBloqueado(): bool
    {
        return $this->blocked;
    }

    public function getPhotoFullUrlAttribute() // fazer aquela cena do storage para qguardar as imagens das pessoas
    {
        if ($this->photo_url && Storage::disk('public')->exists("photos/{$this->photo_url}")) {
            return asset("storage/photos/{$this->photo_url}");
        } else {
            return asset("storage/photos/anonymous.png");
        }
    }

    public function getGender(): string
    {
        return match ($this->gender) {
            'M' => 'Masculino',
            'F' => 'Feminino',
            default => 'Não definido'
        };
    }
}
