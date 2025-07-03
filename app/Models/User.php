<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user's current token has expired
     */
    public function hasValidToken()
    {
        $token = $this->tokens()->latest()->first();
        
        if (!$token) {
            return false;
        }

        // Check if token is expired (24 hours = 1440 minutes)
        $expirationTime = $token->created_at->addDay();
        return now()->lessThan($expirationTime);
    }

    /**
     * Generate a new token for the user
     */
    public function generateNewToken()
    {
        // Delete all existing tokens
        $this->tokens()->delete();
        
        // Create a new token that expires in 24 hours
        return $this->createToken('libretto-token', ['*'], now()->addDay());
    }
}
