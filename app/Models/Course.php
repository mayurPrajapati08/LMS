<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;
use App\Models\Section;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\CartItem;
use App\Models\Certificate;
use App\Models\CourseProgress;
use App\Models\Inquiry;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'details',
        'thumbnail',
        'price',
        'pricing_model',
        'subscription_cycle',
        'promotional_note',
        'status',
        'content_status',
        'level',
        'language',
        'learning_topics',
        'total_duration',
        'validity_in_days',
    ];

    protected $casts = [
        'learning_topics' => 'array',
    ];

    // Category of the course
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Instructor (user who created course)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sections inside course
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    // Enrollments (students who bought course)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Payments related to this course
    public function payments()
    {
        return $this->hasMany(Payment::class);
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

    // Progress tracking
    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // Inquiries
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }
}
