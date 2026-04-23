<?php

namespace App\Policies;

use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\User;

class CourseMaterialPolicy
{
    public function view(User $user, CourseMaterial $material): bool
    {
        $courseId = (int) optional(optional($material->video)->section)->course_id;

        if ($courseId <= 0) {
            return false;
        }

        return Enrollment::query()
            ->where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->exists();
    }

    public function download(User $user, CourseMaterial $material): bool
    {
        return $this->view($user, $material) && (bool) $material->is_downloadable;
    }
}
