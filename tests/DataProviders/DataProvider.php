<?php

namespace Tests\DataProviders;

class DataProvider
{
    public function EmptyValue()
    {
        $data = [];

        return [[ $data ]];
    }

    public function CompleteValue()
    {
        $data = [
            'merchantId'      => '123456',
            'amount'          => '123456',
            'orderRef'        => '12345654321',
            'currCode'        => '123',
            'mpsMode'         => 'ABC',
            'successUrl'      => 'http://www.some-domain.com/Success.html',
            'failUrl'         => 'http://www.some-domain.com/Fail.html',
            'cancelUrl'       => 'http://www.some-domain.com/Cancel.html',
            'payType'         => 'A',
            'lang'            => 'A',
            'payMethod'       => 'A',
            'secureHashSecret' => 'somesecurehashsecret123456',
        ];

        return [[ $data]];
    }

    public function MissingValue()
    {
        $data = [
            'amount'           => '123456',
            'orderRef'         => '12345654321',
            'currCode'         => '123',
            'mpsMode'          => 'ABC',
            'successUrl'       => 'http://www.some-domain.com/Success.html',
            'failUrl'          => 'http://www.some-domain.com/Fail.html',
            'cancelUrl'        => 'http://www.some-domain.com/Cancel.html',
            'payType'          => 'A',
            'lang'             => 'A',
            'payMethod'        => 'A',
            'secureHashSecret' => 'somesecurehashsecret123456',
        ];

        return [[ $data]];
    }

    public function SetFormAttributesData()
    {
        $data = [
            'class' => 'my-form-class',
            'id'    => 'my-form-id',
        ];

        return [[ $data ]];
    }
}
