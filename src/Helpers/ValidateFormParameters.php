<?php

namespace JeffMabazza\PesoPay\Helpers;

use JeffMabazza\PesoPay\Base;
use JeffMabazza\PesoPay\Helpers\Helper;
use JeffMabazza\PesoPay\Exceptions\Parameters\ParameterException as Parameter;

class ValidateFormParameters extends Base
{
    protected $parameters = [];

    const REQUIRED_PARAMETERS_COUNT = 12;

    public function __construct($parameters = [])
    {
        $this->setParameters($parameters);
    }

    protected function ValidateParameters()
    {
        switch(false) {
            case count($this->parameters) > 0:
                throw Parameter::IsEmpty();
            case $this->HasCompleteParametersPassed():
                throw Parameter::HasMissingValue();
        }
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        $this->ValidateParameters();
    }

    private function HasCompleteParametersPassed()
    {
        foreach(self::$required_parameters as $parameter) {
            if(empty($this->parameters[$parameter])) {
                return false;
            }
        }

        return true;
    }
}
