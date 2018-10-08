<?php

namespace Dynamix\PesoPay;

use Dynamix\PesoPay\Exceptions\Parameters\ParameterException as Parameter;

class DataFeed extends Base
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    static $methods = [
        'GET',
        'POST',
    ];

    /**
     * @param string $method The initial method to use.
     */
    public function __construct($method = 'GET')
    {
        $this->method = strtoupper($method);
    }

    /**
     * Get the request parameter. If key doesn't exists,
     * return the second parameter.
     * @param  string      $key     The key.
     * @param  string|null $default The default value if key is not present.
     * @throws \Exception
     * @return string|null
     */
    public function get($key, $default = null)
    {
        if(! empty($key)) {
            return ($parameter = $this->getParameter($key)) ? $parameter : $default;
        }

        throw Parameter::KeyIsEmpty();
    }

    /**
     * Get the request parameter by method.
     * @param  string      $key The key.
     * @throws \Exception
     * @return string|null
     */
    private function getParameter($key)
    {
        $this->validateMethod();

        switch($method) {
            case 'POST':
                return isset($_POST[$key]) ? self::sanitizeParameter($_POST[$key]) : null;
            case 'GET':
                return isset($_GET[$key]) ? self::sanitizeParameter($_GET[$key]) : null;
            default:
                return null;
        }
    }

    /**
     * Sanitize the given value.
     * @param  string $value The value.
     * @return string
     */
    private static function sanitizeParameter($value)
    {
        $parameter = strip_tags($value);
        $sanizited_parameter = str_replace(chr(0), '', $parameter);

        return $sanizited_parameter;
    }

    /**
     * Get the method used.
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($this->method);
    }

    /**
     * Validate if the method supplied is supported.
     * @throws \Exception
     * @return void
     */
    private function validateMethod()
    {
        if(! in_array($method = $this->getMethod(), self::$methods)) {
            throw Parameter::InvalidMethod("Method {$method} is not supported.");
        }
    }

    /**
     * Set the method to use.
     * @param  string $method The method name.
     * @return string
     */
    public function setMethod($method = 'GET')
    {
        $this->method = strtoupper($method);

        $this->validateMethod($this->method);

        return $this;
    }
}
