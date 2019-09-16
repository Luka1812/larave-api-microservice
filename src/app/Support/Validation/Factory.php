<?php

namespace App\Support\Validation;

use Illuminate\Validation\Factory as BaseFactory;

class Factory
{
    /**
     * The base illuminate validation factory
     *
     * @var \Illuminate\Validation\Factory
     */
    private $baseFactory;

    /**
     * @param \Illuminate\Validation\Factory $baseFactory
     *
     * @return void
     */
    public function __construct(BaseFactory $baseFactory)
    {
        $this->baseFactory = $baseFactory;
    }

    /**
     * Create a new Validator instance.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $errorCodes
     * @param  array  $customAttributes
     *
     * @return \App\Support\Validation\Validator
     */
    public function make(array $data, array $rules, array $messages = [], array $errorCodes = [], array $customAttributes = [])
    {
        $baseValidator = $this->baseFactory->make($data, $rules, $messages, $customAttributes);

        $validator = new Validator($baseValidator, $errorCodes);

        return $validator;
    }

    /**
     * Validate the given data against the provided rules.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $errorCodes
     * @param array $customAttributes
     *
     * @return array
     *
     * @throws \App\Support\Validation\ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $data, array $rules, array $messages = [], array $errorCodes = [], array $customAttributes = [])
    {
        return $this->make($data, $rules, $messages, $errorCodes, $customAttributes)->validate();
    }

    /**
     * @param string $name
     * @param mixed $args
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        return call_user_func_array([$this->baseFactory, $name], $args);
    }
}
