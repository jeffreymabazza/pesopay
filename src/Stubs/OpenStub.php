<form name="<?php echo isset($this->form_attributes['name']) ? $this->form_attributes['name'] : 'payFormCcard' ?>" method="post" action="<?php echo $this->getFormAction(); ?>" <?php echo implode(" ", $this->getFormAttributes()); ?>>
<input type="hidden" name="merchantId" value="<?php echo isset($this->form_parameters['merchantId']) ? $this->form_parameters['merchantId'] : ''; ?>">
<input type="hidden" name="amount" value="<?php echo isset($this->form_parameters['amount']) ? $this->form_parameters['amount'] : ''; ?>" >
<input type="hidden" name="orderRef" value="<?php echo isset($this->form_parameters['orderRef']) ? $this->form_parameters['orderRef'] : ''; ?>">
<input type="hidden" name="currCode" value="<?php echo isset($this->form_parameters['currCode']) ? $this->form_parameters['currCode'] : ''; ?>" >
<input type="hidden" name="mpsMode" value="<?php echo isset($this->form_parameters['mpsMode']) ? $this->form_parameters['mpsMode'] : ''; ?>" >
<input type="hidden" name="successUrl" value="<?php echo isset($this->form_parameters['successUrl']) ? $this->form_parameters['successUrl'] : $this->FallbackUrl(); ?>">
<input type="hidden" name="failUrl" value="<?php echo isset($this->form_parameters['failUrl']) ? $this->form_parameters['failUrl'] : $this->FallbackUrl(); ?>">
<input type="hidden" name="cancelUrl" value="<?php echo isset($this->form_parameters['cancelUrl']) ? $this->form_parameters['cancelUrl'] : $this->FallbackUrl(); ?>">
<input type="hidden" name="payType" value="<?php echo isset($this->form_parameters['payType']) ? $this->form_parameters['payType'] : ''; ?>">
<input type="hidden" name="lang" value="<?php echo isset($this->form_parameters['lang']) ? $this->form_parameters['lang'] : ''; ?>">
<input type="hidden" name="payMethod" value="<?php echo isset($this->form_parameters['payMethod']) ? $this->form_parameters['payMethod'] : ''; ?>">
<input type="hidden" name="secureHash" value="<?php echo isset($this->form_parameters['secureHash']) ? $this->form_parameters['secureHash'] : ''; ?>">
