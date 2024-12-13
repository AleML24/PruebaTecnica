<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Utils\ResponseFormat;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
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

    public static function validateData(Request $request, $update = false)
    {
        $validator = Validator::make($request->all(), [
            'name' => [$update ? '': 'required', 'string', 'regex:/^[A-Za-z ]+$/', 'max:150'],
            'email' => [$update ? '': 'required', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'],
            'role' => [$update ? '': 'required', 'in:manager,revisor,comprador']
        ]);

        if ($validator->fails()) {
            $errorMessage = ResponseFormat::getValidatorErrorMessage($validator);
            throw new Exception($errorMessage);
        }

        return true;
    }
}
