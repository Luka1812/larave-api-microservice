<?php

namespace App\Support\Validation;

use Illuminate\Validation\ValidationException as BaseValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Validation\Validator as BaseValidator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Validator implements ValidatorContract
{
    /**
     * The base illuminate validation validator instance
     *
     * @var \Illuminate\Validation\Validator
     */
    private $baseValidator;

    /**
     * The error codes array
     *
     * @var array
     */
    private $errorCodes = [];

    /**
     * @param \Illuminate\Validation\Validator $baseValidator
     * @param array $errorCodes
     *
     * @return void
     */
    public function __construct(BaseValidator $baseValidator, array $errorCodes = [])
    {
        $this->baseValidator = $baseValidator;

        $this->setErrorCodes($errorCodes);
    }

    /**
     * Run the validator's rules against its data.
     *
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \App\Support\Validation\ValidationException
     */
    public function validate()
    {
        try {
            return $this->baseValidator->validate();
        } catch (BaseValidationException $exception) {
            throw new ValidationException($this);
        }
    }

    /**
     * Get the attributes and values that were validated.
     *
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validated()
    {
        try {
            return $this->baseValidator->validated();
        } catch (BaseValidationException $exception) {
            throw new ValidationException($this);
        }
    }

    /**
     * Get validation error codes
     *
     * @return array
     */
    public function getErrorCodes(): array
    {
        return $this->errorCodes;
    }

    /**
     * Get all of the validation error messages.
     *
     * @return array
     */
    public function errors() : array
    {
        $errors = [];

        foreach ($this->baseValidator->failed() as $field => $rule) {
            $fullRuleName = $this->getFullRuleName($field, $rule);

            $errors[] = [
                'message' => $this->baseValidator->errors()->first($field),
                'code'    => $this->getErrorCode($fullRuleName),
            ];
        }

        return $errors;
    }

    /**
     * Get full rule name from field and rule.
     *
     * @param  string  $field
     * @param  array  $rule
     *
     * @return string
     */
    protected function getFullRuleName(string $field, array $rule) : string
    {
        return $field . '.' . strtolower(key($rule));
    }

    /**
     * Get error code from field and rule name.
     *
     * @param  string  $ruleName
     *
     * @return string|null
     */
    protected function getErrorCode(string $ruleName) : string
    {
        return Arr::get($this->errorCodes, $ruleName, '');
    }

    /**
     * Set error codes
     *
     * @param array $errorCodes
     *
     * @return void
     */
    protected function setErrorCodes(array $errorCodes) : void
    {
        foreach ($errorCodes as $key => $errorCode) {
            if (Str::contains($key, '*')) {
                $this->setErrorCodesForWildcardKey($key, $errorCode);
            } else {
                $this->setErrorCode($key, $errorCode);
            }
        }
    }

    /**
     * Set error codes for wildcard key
     *
     * @param string $key
     * @param string $errorCode
     *
     * @return void
     */
    protected function setErrorCodesForWildcardKey(string $key, string $errorCode) : void
    {
        // get field name without rule
        $field = substr($key, 0, strrpos($key, '.'));

        $fieldRegexp = '/^'.str_replace('.*.', '.([0-9]*).', $field).'$/';

        $keyMatches = [];

        foreach ($this->baseValidator->getMessageBag()->keys() as $messageBagKey) {
            if (preg_match($fieldRegexp, $messageBagKey, $matches)) {
                $keyMatches[] = $matches[1];
            }
        }

        foreach ($keyMatches as $keyMatch) {
            $fullRuleName = str_replace('.*.', ".$keyMatch.", $key);

            $this->setErrorCode($fullRuleName, $errorCode);
        }
    }

    /**
     * Set error code with key
     *
     * @param string $key
     * @param string $errorCode
     *
     * @return void
     */
    protected function setErrorCode(string $key, string $errorCode) : void
    {
        if (! Arr::exists($this->errorCodes, $key)) {
            $this->errorCodes[$key] = $errorCode;
        }
    }

    /**
     * Get the messages for the instance.
     *
     * @return \Illuminate\Contracts\Support\MessageBag
     */
    public function getMessageBag()
    {
        return $this->baseValidator->getMessageBag();
    }

    /**
     * Determine if the data fails the validation rules.
     *
     * @return bool
     */
    public function fails()
    {
        return $this->baseValidator->fails();
    }

    /**
     * Get the failed validation rules.
     *
     * @return array
     */
    public function failed()
    {
        return $this->baseValidator->failed();
    }

    /**
     * Add conditions to a given field based on a Closure.
     *
     * @param  string|array  $attribute
     * @param  string|array  $rules
     * @param  callable  $callback
     * @return $this
     */
    public function sometimes($attribute, $rules, callable $callback)
    {
        $this->baseValidator->sometimes($attribute, $rules, $callback);

        return $this;
    }

    /**
     * Add an after validation callback.
     *
     * @param callable|string $callback
     *
     * @return $this
     */
    public function after($callback)
    {
        $this->baseValidator->after($callback);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $args
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        return call_user_func_array([$this->baseValidator, $name], $args);
    }
}
