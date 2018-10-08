<?php

class DataFeedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function SetAnInvalidMethod()
    {
        $this->expectException(Dynamix\PesoPay\Exceptions\Parameters\ParameterException::class);

        $this->DataFeedInstance()->setMethod('INVALID');
    }

    /**
     * @test
     */
    public function SetAPostAndGetMethod()
    {
        $dataFeed = $this->DataFeedInstance();

        $this->assertEquals($dataFeed->setMethod('POST')->getMethod(), 'POST');
        $this->assertEquals($dataFeed->setMethod('GET')->getMethod(), 'GET');
    }

    /**
     * Instantiate the DataFeed class.
     * @return \Dynamix\PesoPay\DataFeed
     */
    private function DataFeedInstance()
    {
        return new Dynamix\PesoPay\DataFeed();
    }
}
