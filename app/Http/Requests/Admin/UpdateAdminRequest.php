<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $managedAdmin */
        $managedAdmin = $this->route('managedAdmin');

        return $managedAdmin instanceof User
            && (bool) $this->user()?->can('updatePrivilegedAccount', $managedAdmin);
    }

    public function rules(): array
    {
        /** @var User $managedAdmin */
        $managedAdmin = $this->route('managedAdmin');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$managedAdmin->id],
            'role' => ['required', 'in:admin,super admin,hr team'],
            'current_password' => ['required', 'current_password'],
        ];
    }
}
