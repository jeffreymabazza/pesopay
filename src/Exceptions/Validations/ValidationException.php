<?php

namespace Dynamix\PesoPay\Exceptions\Validations;

use Dynamix\PesoPay\Exceptions\ThrowableInterface;

class ValidationException extends \Exception implements ThrowableInterface
{
    public static function EmptyParameters($message = 'No parameters passed.', $code = 422)
    {
        return new static($message, $code);
    }

    public static function HasMissingParameters($message = 'Missing required parameters.', $code = 422)
    {
        return new static($message, $code);
    }

    public static function InvalidParameterValue($message = 'Invalid value passed.', $code = 422)
    {
        return new static($message, $code);
    }
}
