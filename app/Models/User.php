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
        'bio',
        'avatar_path',
        'two_factor_enabled',
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
            'two_factor_enabled' => 'boolean',
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

    public function emailVerificationOtps()
    {
        return $this->hasMany(EmailVerificationOtp::class);
    }

    public function avatarUrl(int $size = 128): string
    {
        if ($this->avatar_path) {
            if (str_starts_with($this->avatar_path, 'http://') || str_starts_with($this->avatar_path, 'https://')) {
                return $this->avatar_path;
            }

            return asset($this->avatar_path);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=EEF2FF&color=312E81&size='.$size;
    }
}
