<?php
namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationTrait{

    protected function failedValidation(Validator $validator)
    {
        $errors = array_values($validator->errors()->toArray());
        $errorsPayLoad = count($errors) > 1 ?
         array_slice(array_reduce($errors, fn($ar1, $ar2) => [...$ar1, ...$ar2], $errors[0]), 1):
         $errors[0];

        throw new HttpResponseException(unprocessable_response($errorsPayLoad));
    }
}
