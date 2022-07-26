<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\JWTService;
use App\Traits\Filters;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Class User.
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 *     required={
 *          "first_name", "last_name", "email",
 *          "password", "password_confirmation", "avatar",
 *          "address", "phone_number"
 *     },
 * )
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use Uuids;
    use Filters;

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
        'last_login_at',
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
        'last_login_at' => 'datetime',
    ];

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
     * Encrypt password attribute
     *
     * @param string $value
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNotAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', 0);
    }

    /**
     * @return HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(JwtToken::class);
    }

    public function generateToken(): string
    {
        return JWTService::getToken($this);
    }

    /**
     * Check is user admin?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === 1;
    }

    /**
     * @param Request $request
     *
     * @return Builder
     */
    public static function filter(Request $request): Builder
    {
        $query = User::query();

        $keys = [
            'first_name',
            'email',
            'phone',
            'address',
            'marketing',
        ];

        $query = self::commonFilter($query, $request, $keys);

        if ($request->has('created_at')) {
            $date = date('Y-m-d', strtotime($request->input('created_at')));

            $query->orWhereDate('created_at', $date);
        }

        return self::sortByFilter($query, $request);
    }
}
