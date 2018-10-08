<?php

namespace Dynamix\PesoPay;

use Closure;
use Exception;
use Dynamix\PesoPay\Encryptor;
use Dynamix\PesoPay\Helpers\Helper;
use Dynamix\PesoPay\Contracts\PayGateInterface;
use Dynamix\PesoPay\Helpers\ValidateFormParameters;
use Dynamix\PesoPay\Exceptions\Validations\ValidationException;

class PesoPay extends Base implements PayGateInterface
{
    const TESTING_URL = 'https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp';
    const PRODUCTION_URL = 'https://www.pesopay.com/b2c2/eng/payment/payForm.jsp';

    /**
     * @var boolean
     */
    protected $is_sandbox = true;

    /**
     * @var array
     */
    protected $form_parameters = [];

    /**
     * @var array
     */
    protected $form_attributes = [];

    /**
     * @var array
     */
    protected $button_attributes = [];

    /**
     * @var array
     */
    protected $datafeed = [];

    /**
     * @param array $form_parameters The form parameters.
     */
    public function __construct(array $form_parameters = [])
    {
        $this->form_parameters = $form_parameters;
    }

    /**
     * Set the payment mode to either testing(sandbox) or production.
     * @param  string $mode The mode. "testing"|"production".
     * @return $this
     */
    public function setPayMode($mode = 'testing')
    {
        $this->is_sandbox = strtolower($mode) === 'production' ? false : true;

        return $this;
    }

    /**
     * Get the payment mode.
     * @return string
     */
    public function getPayMode()
    {
        return $this->is_sandbox;
    }

    /**
     * Set the form parameter.
     * @param  string $key   The name.
     * @param  mixed  $value The value.
     * @return $this
     */
    public function setFormParameter($key = null, $value = null)
    {
        if(! empty($key)) {
            $this->form_parameters[$key] = $value;
        }

        return $this;
    }

    /**
     * Set the form parameters.
     * @param  array $form_parameters The form parameters.
     * @return $this
     */
    public function setFormParameters(array $form_parameters = [])
    {
        if($form_parameters) {
            foreach($form_parameters as $parameter_key => $parameter_value) {
                $this->setFormParameter($parameter_key, $parameter_value);
            }
        }

        return $this;
    }

    /**
     * Get the form parameters.
     * @return array
     */
    public function getFormParameters()
    {
        return $this->form_parameters;
    }

    /**
     * Set the form attributes. Ex: class="my-class" id="my-id"
     * @param  array $form_attributes The form attributes.
     * @return $this
     */
    private function setFormAttributes(array $form_attributes = [])
    {
        if($attributes = $form_attributes) {
            foreach($attributes as $key_attribute => $val_attribute) {
                if($key_attribute == 'name') {
                    $this->form_attributes['name'] = $val_attribute;
                } else {
                    $this->form_attributes[] = $key_attribute.'="'.$val_attribute.'"';
                }
            }
        }

        return $this;
    }

    /**
     * Set the button attributes. Ex: class="my-class" id="my-id".
     * @param  array $button_attributes The button attributes.
     * @return $this
     */
    public function setButtonAttributes(array $button_attributes = [])
    {
        if($attributes = $button_attributes) {
            foreach($attributes as $key_attribute => $val_attribute) {
                if($key_attribute == 'value') {
                        $this->button_attributes['value'] = $val_attribute;
                } else {
                        $this->button_attributes[] = $key_attribute.'="'.$val_attribute.'"';
                }
            }
        }

        return $this;
    }

    /**
     * Get the form attributes.
     * @return array
     */
    public function getFormAttributes()
    {
        unset($this->form_attributes['name']);

        return $this->form_attributes;
    }

    /**
     * Get the button attributes.
     * @return array
     */
    public function getButtonAttributes()
    {
        unset($this->button_attributes['value']);

        return $this->button_attributes;
    }

    /**
     * The form action url.
     * @return string
     */
    public function getFormAction()
    {
        return $this->is_sandbox ? self::TESTING_URL : self::PRODUCTION_URL;
    }

    /**
     * Validates the supplied form parameters.
     * @return $this
     */
    protected function ValidateFormParameters()
    {
        new ValidateFormParameters($this->form_parameters);

        return $this;
    }

    /**
     * Generate the SignData required for the authenticity of the payment.
     * @return string
     */
    private function GenerateSignData()
    {
        $sign_data = [
            isset($this->form_parameters['merchantId'])       ? $this->form_parameters['merchantId'] : '',
            isset($this->form_parameters['orderRef'])         ? $this->form_parameters['orderRef'] : '',
            isset($this->form_parameters['currCode'])         ? $this->form_parameters['currCode'] : '',
            isset($this->form_parameters['amount'])           ? $this->form_parameters['amount'] : '',
            isset($this->form_parameters['payType'])          ? $this->form_parameters['payType'] : '',
            isset($this->form_parameters['secureHashSecret']) ? $this->form_parameters['secureHashSecret'] : '',
        ];

        return implode('|', $sign_data);
    }

    /**
     * Generate the SecureHash string by encrypting the
     * given SignData into sha1 algorithm.
     * @return string
     */
    private function GenerateSecureHash($sign_data = null)
    {
        return sha1($sign_data);
    }

    /**
     * Returns the content of the specified stub. The submit button will only
     * appear once the $submit_button_attributes is set.
     * @param  string $stub The stub to render.
     * @return string
     */
    private function RenderHtmlForm($stub = 'CompleteStub')
    {
        ob_start();

        include __DIR__."/Stubs/{$stub}.php";

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }

    /**
     * Prepare the form.
     * Validate the parameters, thrown an exception on failure.
     * Generate the sign data and encrypt it using the sha1 algorithm.
     * @return $this
     */
    private function prepareForm()
    {
        $this->ValidateFormParameters();

        $sign_data = $this->GenerateSignData();
        $secure_hash = $this->GenerateSecureHash($sign_data);

        $this->setFormParameter('secureHash', $secure_hash);

        return $this;
    }

    /**
     * Creates the opening and the necessary fields of the PesoPay form.
     * @param  array  $form_attributes The form attributes.
     * @return string
     */
    public function formOpen(array $form_attributes = [])
    {
        $this->setFormAttributes($form_attributes);

        return $this->prepareForm()->RenderHtmlForm('OpenStub');
    }

    /**
     * Creates the button element of the PesoPay form.
     * @param  array  $button_attributes The button attributes.
     * @return string
     */
    public function formButton(array $button_attributes = [])
    {
        $this->setButtonAttributes($button_attributes);

        return $this->RenderHtmlForm('ButtonStub');
    }

    /**
     * Creates the closing tag of the PesoPay form.
     * @return string
     */
    public function formClose()
    {
        return $this->renderHtmlForm('CloseStub');
    }
}
