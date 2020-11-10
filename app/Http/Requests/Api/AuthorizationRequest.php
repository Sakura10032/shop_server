<?php

namespace App\Http\Requests\Api;

class AuthorizationRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'mobile' => [
                'required',
                'regex:/^1[3-9]\d{9}$/'
            ]
        ];
    }
}