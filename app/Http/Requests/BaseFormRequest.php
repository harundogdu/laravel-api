<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ResultType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            (new ApiController)->apiResponse(ResultType::ERROR, $errors, 'Validation Failed', JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
