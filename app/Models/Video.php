<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\User;
use App\Models\CourseProgress;
use App\Models\CourseMaterial;

class Video extends Model
{
    protected $fillable = [
        'section_id',
        'upload_by',
        'title',
        'thumbnail_url',
        'video_url',
        'order_number',
        'duration',
        'is_preview',
    ];

    // Video belongs to a section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Uploaded by (user)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'upload_by');
    }

    // Progress tracking
    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // Materials (PDFs, files)
    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }
}
