<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DeleteAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $managedAdmin */
        $managedAdmin = $this->route('managedAdmin');

        return $managedAdmin instanceof User
            && (bool) $this->user()?->can('deletePrivilegedAccount', $managedAdmin);
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
        ];
    }
}
