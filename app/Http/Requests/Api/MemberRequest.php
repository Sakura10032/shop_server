<?php

namespace App\Http\Requests\Api;


class MemberRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'email' => 'email:rfc|required',
                    'pwd' => 'required',
                ];
            case 'GET':
            case 'PUT':
                return [];
        }
    }

    public function messages()
    {
        return [
            'email.email' => '邮箱格式不合法！',
            'email.required' => '请填写邮箱！',
            'pwd.required' => '请填写密码！'
        ];
    }
}
