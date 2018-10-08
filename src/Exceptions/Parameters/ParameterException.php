<?php

namespace JeffMabazza\PesoPay\Exceptions\Parameters;

class ParameterException extends \Exception
{
    public static function IsEmpty($message = 'No parameters passed.', $code = 422)
    {
        return new static($message, $code);
    }

    public static function HasMissingValue($message = 'Missing required parameters.', $code = 422)
    {
        return new static($message, $code);
    }

    public static function HasInvalidValue($message = 'Invalid value passed.', $code = 422)
    {
        return new static($message, $code);
    }

    public static function KeyIsEmpty($message = 'Request key is required.', $code = 422)
    {
        return new static($message, $code);
    }

    public static function InvalidMethod($message = 'Invalid method or is not supported.', $code = 422)
    {
        return new static($message, $code);
    }
}
