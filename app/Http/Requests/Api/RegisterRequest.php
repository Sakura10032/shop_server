<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                    'mobile' => [
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                        'required'
                    ],
                    'name' => 'string|max:10|required'
                ];
            case 'PUT':
            case 'GET':
                return [];
        }
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号必填！',
            'mobile.regex' => '请输入正确的手机号！',
            'name.required'  => '站点名称必填！',
            'name.max'  => '站点名称过长！',
            'name.string'  => '站点名称中有非法字符！',
        ];
    }
}
