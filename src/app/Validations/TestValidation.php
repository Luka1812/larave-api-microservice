<?php

namespace App\Validations;

use App\Enums\ErrorCodes\TestErrorCode;

class TestValidation extends Validation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'test_field' => 'required'
        ];
    }

    /**
     * Get the validation error codes for the request.
     *
     * @return array
     */
    public function errorCodes() : array
    {
        return [
            'test_field.required'  => TestErrorCode::ERR_EMPTY_TEST_FIELD
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData() : array
    {
        $data = [
            'test_field' => $this->data('testField'),
        ];

        return $data;
    }
}
