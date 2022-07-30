<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AdminUserEditRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return isset($user) && $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')
                    ->ignore($this->route('uuid'), 'uuid')
            ],
            'password' => 'required|confirmed|min:6',
            'avatar' => 'sometimes|string   ',
            'phone_number' => 'required',
        ];
    }
}
