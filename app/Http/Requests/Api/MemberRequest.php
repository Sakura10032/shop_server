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
        return [
            'email' => 'email:rfc|required',
            'pwd' => 'required',
        ];
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
