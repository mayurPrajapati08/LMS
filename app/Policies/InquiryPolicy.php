<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    public function replyAsAdmin(User $user, Inquiry $inquiry): bool
    {
        return $user->hasAnyRole(['admin', 'super admin']);
    }

    public function replyAsInstructor(User $user, Inquiry $inquiry): bool
    {
        return $user->hasRole('instructor')
            && $user->courses()->where('courses.id', $inquiry->course_id)->exists();
    }
}
