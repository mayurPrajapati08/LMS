<?php

namespace App\Http\Requests\Admin;

use App\Models\Inquiry;
use Illuminate\Foundation\Http\FormRequest;

class ReplyInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Inquiry|null $inquiry */
        $inquiry = $this->route('inquiry');

        return $inquiry instanceof Inquiry
            && (bool) $this->user()?->can('replyAsAdmin', $inquiry);
    }

    public function rules(): array
    {
        return [
            'admin_reply' => ['required', 'string', 'max:5000'],
            'status' => ['nullable', 'in:pending,resolved'],
        ];
    }
}
