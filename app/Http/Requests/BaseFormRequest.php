<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
       $errors = (new ValidationException($validator))->errors();


    }
}
