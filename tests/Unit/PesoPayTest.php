<?php

class PesoPayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider Tests\DataProviders\DataProvider::EmptyValue()
     */
    public function SupplyAnEmptyValueWhenOpeningAForm($data)
    {
        $this->expectException(JeffMabazza\PesoPay\Exceptions\Parameters\ParameterException::class);
        $this->expectExceptionCode(422);
        $this->expectExceptionMessage('No parameters passed.');

        $this->PesoPayInstance($data)->formOpen();
    }

    /**
     * @test
     * @dataProvider Tests\DataProviders\DataProvider::MissingValue()
     */
    public function SupplyMissingValueWhenOpeningAForm($data)
    {
        $this->expectException(JeffMabazza\PesoPay\Exceptions\Parameters\ParameterException::class);
        $this->expectExceptionCode(422);
        $this->expectExceptionMessage('Missing required parameters.');

        $this->PesoPayInstance($data)->formOpen();
    }

    /**
     * @test
     * @dataProvider Tests\DataProviders\DataProvider::CompleteValue()
     */
    public function SetPayModeToProduction($data)
    {
        $pay_mode = $this->PesoPayInstance($data)
            ->setPaymode('production')
            ->getPayMode();

        $this->assertFalse($pay_mode);
    }

    /**
     * @test
     * @dataProvider Tests\DataProviders\DataProvider::CompleteValue()
     */
    public function setAttributes($data)
    {
        $pesopay = $this->PesoPayInstance($data);
        $form_open = $pesopay->formOpen([
            'name'  => 'altered_form_name',
            'id'    => 'my-form-id',
            'class' => 'my-form-class',
        ]);
        $form_button = $pesopay->formButton([
            'value' => 'altered_button_value',
            'id'    => 'my-button-id',
            'class' => 'my-button-class',
        ]);

        $this->assertContains('name="altered_form_name"', $form_open);
        $this->assertContains('id="my-form-id" class="my-form-class"', $form_open);
        $this->assertContains('value="altered_button_value"', $form_button);
        $this->assertContains('id="my-button-id" class="my-button-class"', $form_button);
    }

    /**
     * Instantiate the PesoPay class.
     * @param  array   $data                The parameters.
     * @param  boolean $data_to_constructor Place the $data parameters weather in the constructor or in the setFormParameters(). Default is constructor.
     * @return JeffMabazza\PesoPay\PesoPay
     */
    private function PesoPayInstance($data = null, $data_to_constructor = true)
    {
        if($data !== null) {
            if($data_to_constructor === false) {
                return (new JeffMabazza\PesoPay\PesoPay())->setFormParameters($data);
            }

            return new JeffMabazza\PesoPay\PesoPay($data);
        }

        return new JeffMabazza\PesoPay\PesoPay();
    }
}
