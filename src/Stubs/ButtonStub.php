<input type="submit" value="<?php echo isset($this->button_attributes['value']) ? $this->button_attributes['value'] : 'Submit'; ?>" <?php echo implode(" ", $this->getButtonAttributes()) ?>>
