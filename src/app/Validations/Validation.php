<?php

namespace App\Validations;

use App\Support\Validation\Factory as ValidationFactory;
use App\Support\Validation\Validator;

abstract class Validation
{
    /**
     * The validation factory instance
     *
     * @var \App\Support\Validation\Factory
     */
    protected $validationFactory;

    /**
     * The validation validator instance
     *
     * @var \App\Support\Validation\Validator
     */
    protected $validator;

    /**
     * The provided data array
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create new Validation instance
     *
     * @param \App\Support\Validation\Factory $validationFactory
     *
     * @return void
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate the given data against the provided rules.
     *
     * @param array $data
     *
     * @return array
     *
     * @throws \App\Support\Validation\ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $data): array
    {
        $this->setValidationData($data);

        $validator = $this->getValidatorInstance();

        return $validator->validate();
    }

    /**
     * Get the validator instance
     *
     * @return \App\Support\Validation\Validator
     */
    protected function getValidatorInstance(): Validator
    {
        if ($this->validator) {
            return $this->validator;
        }

        $validator = $this->createValidator();

        $this->setValidator($validator);

        return $validator;
    }

    /**
     * Create the validator instance.
     *
     * @return \App\Support\Validation\Validator
     */
    protected function createValidator(): Validator
    {
        return $this->validationFactory->make(
            $this->validationData(), $this->rules(),
            $this->messages(), $this->errorCodes()
        );
    }

    /**
     * Get the validation rules that apply to the given data array.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Get the validation messages for the given data array.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get the validation error codes for the given data array.
     *
     * @return array
     */
    public function errorCodes(): array
    {
        return [];
    }

    /**
     * Get data to be validated from the given data array.
     *
     * @return array
     */
    public function validationData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    protected function setValidationData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Retrieve an item from the given data array.
     *
     * @param  string|null  $key
     * @param  string|array|null  $default
     * @return string|array|null
     */
    public function data($key = null, $default = null)
    {
        return data_get($this->data, $key, $default);
    }

    /**
     * @param \App\Support\Validation\Validator $validator
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }
}
