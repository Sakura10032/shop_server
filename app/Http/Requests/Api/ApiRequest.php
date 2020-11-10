<?php


namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            'code'=>422,
            'msg'=>$validator->errors()
        ],422)));
    }
}