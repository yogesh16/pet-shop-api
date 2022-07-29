<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    use ApiResponse;

    protected function failedValidation(Validator $validator)
    {
        if($this->wantsJson())
        {
            $response = $this->error(
                'Invalid data',
                $validator->errors()->toArray()
            );
        }else{
            $response = redirect()
                ->route('guest.login')
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($validator);
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
