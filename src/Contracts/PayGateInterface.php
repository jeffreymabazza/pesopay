<?php

namespace JeffMabazza\PesoPay\Contracts;

interface PayGateInterface
{
    public function setPayMode($mode = 'testing');

    public function setFormParameter($key = null, $value = null);

    public function setFormParameters(array $form_parameters = []);
}
