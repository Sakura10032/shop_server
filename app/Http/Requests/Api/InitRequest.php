<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class InitRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'register_key' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'register_key.required' => '初始化注册码必填！',
        ];
    }
}
