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
            case 'PATCH':
                return [
                    'id' => 'required',
                    'age' => 'int',
                    'mobile' => [
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/'
                    ],
                ];
            case 'PUT':
                return [];
        }
    }

    public function messages()
    {
        return [
            'email.email' => '邮箱格式不合法！',
            'email.required' => '请填写邮箱！',
            'pwd.required' => '请填写密码！',
            'id.required' => '缺少必要参数！',
            'age.int' => '年龄格式不合法！',
            'mobile.regex' => '请输入正确的手机号！',
        ];
    }
}
