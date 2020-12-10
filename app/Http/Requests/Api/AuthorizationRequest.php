<?php

namespace App\Http\Requests\Api;

class AuthorizationRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'account' => [
                'required',
                'regex:/^1[3-9]\d{9}$/'
            ]
        ];
    }


    public function messages()
    {
        return [
            'account.regex' => '手机号格式不正确！',
            'account.required' => '请填写手机号！'
        ];
    }
}
