<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\JWTService;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User.
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 *     required={"first_name", "last_name", "email", "password", "password_confirmation", "avatar",
 *     "address", "phone_number"},
 * )
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use Uuids;

    /**
     * @OA\Property(
     *     description="User first name",
     *     title="First name",
     * )
     *
     * @var string
     */
    private $first_name;

    /**
     * @OA\Property(
     *     description="User last name",
     *     title="Last name",
     * )
     *
     * @var string
     */
    private $last_name;

    /**
     * @OA\Property(
     *     format="email",
     *     description="User email",
     *     title="Email",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     description="User Password",
     *     title="Password",
     * )
     *
     * @var string
     */
    private $password;

    /**
     * @OA\Property(
     *     description="User Password Confirmation",
     *     title="Password Confirmation",
     * )
     *
     * @var string
     */
    private $password_confirmation;

    /**
     * @OA\Property(
     *     description="User avatar UUID",
     *     title="Avatar UUID",
     * )
     *
     * @var string
     */
    private $avatar;

    /**
     * @OA\Property(
     *     description="User address",
     *     title="Address",
     * )
     *
     * @var string
     */
    private $address;

    /**
     * @OA\Property(
     *     description="User phone number",
     *     title="Phone number",
     * )
     *
     * @var string
     */
    private $phone_number;

    /**
     * @OA\Property(
     *     description="User marketing",
     *     title="marketing",
     * )
     *
     * @var string
     */
    private $is_marketing;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'is_admin',
        'email',
        'password',
        'avatar',
        'address',
        'phone_number',
        'is_marketing',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime'
    ];

    public function tokens()
    {
        return $this->hasMany(JwtToken::class);
    }

    public function generateToken() : string
    {
        return JWTService::getToken($this);
    }

    /**
     * Check is user admin?
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin === 1;
    }
}
