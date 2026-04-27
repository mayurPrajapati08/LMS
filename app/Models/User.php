<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\CourseProgress;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\CartItem;
use App\Models\Certificate;
use App\Models\Video;
use App\Models\Inquiry;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, MustVerifyEmailTrait, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'email_verified_at',
        'last_login_at',
        'bio',
        'avatar_path',
        'two_factor_enabled',
        'show_on_homepage',
        'faculty_sort_order',
        'faculty_headline',
        'password',
        'role_id',
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
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'show_on_homepage' => 'boolean',
        ];
    }

    // Role relationship
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Courses created by instructor
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Progress
    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Wishlist
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Certificates
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Uploaded videos
    public function uploadedVideos()
    {
        return $this->hasMany(Video::class, 'uploaded_by');
    }

    // Inquiries
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function assignedPublicContacts()
    {
        return $this->hasMany(PublicContact::class, 'assigned_to');
    }

    public function reviewedWorkshopRegistrations()
    {
        return $this->hasMany(WorkshopRegistration::class, 'reviewed_by');
    }

    public function emailVerificationOtps()
    {
        return $this->hasMany(EmailVerificationOtp::class);
    }

    public function avatarUrl(int $size = 128): string
    {
        if ($this->avatar_path) {
            $avatarPath = trim((string) $this->avatar_path);

            if (str_starts_with($avatarPath, '//')) {
                $avatarPath = 'https:'.$avatarPath;
            }

            if (str_starts_with($avatarPath, 'http://') || str_starts_with($avatarPath, 'https://')) {
                $host = parse_url($avatarPath, PHP_URL_HOST);
                $isGoogleAvatar = is_string($host) && Str::contains(strtolower($host), 'googleusercontent.com');

                if ($isGoogleAvatar) {
                    $query = [];
                    parse_str((string) parse_url($avatarPath, PHP_URL_QUERY), $query);
                    $query['sz'] = max(64, min(1024, $size * 2));

                    $scheme = (string) parse_url($avatarPath, PHP_URL_SCHEME);
                    $authority = (string) parse_url($avatarPath, PHP_URL_HOST);
                    $port = parse_url($avatarPath, PHP_URL_PORT);
                    $path = (string) parse_url($avatarPath, PHP_URL_PATH);
                    $fragment = (string) parse_url($avatarPath, PHP_URL_FRAGMENT);

                    $avatarPath = $scheme.'://'.$authority.($port ? ':'.$port : '').$path;
                    $avatarPath .= '?'.http_build_query($query);

                    if ($fragment !== '') {
                        $avatarPath .= '#'.$fragment;
                    }
                }

                return $avatarPath;
            }

            return asset($avatarPath);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=EEF2FF&color=312E81&size='.$size;
    }

    public function hasRole(string $role): bool
    {
        return strtolower((string) $this->role?->name) === strtolower($role);
    }

    public function hasAnyRole(array $roles): bool
    {
        $normalizedRoles = array_map(static fn (string $role) => strtolower($role), $roles);

        return in_array(strtolower((string) $this->role?->name), $normalizedRoles, true);
    }
}
