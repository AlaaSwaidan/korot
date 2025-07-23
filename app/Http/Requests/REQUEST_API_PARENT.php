<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class REQUEST_API_PARENT extends FormRequest
{
    public function expectsJson()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        // $data['field'] = $validator->errors()->keys()[0];
      if (auth()->guard('api_merchant')->check()) {
          if (auth()->guard('api_merchant')->user()->id == 632) {
              throw new HttpResponseException(ApiController::respondWithError(trans('api.global_error'))); // 422

          }
          throw new HttpResponseException(ApiController::respondWithError(validateRules($validator->errors(), $validator->errors()->messages()))); // 422

      }
        throw new HttpResponseException(ApiController::respondWithError(validateRules($validator->errors(), $validator->errors()->messages()))); // 422
    }
}
