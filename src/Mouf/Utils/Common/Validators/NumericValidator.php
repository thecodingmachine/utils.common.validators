<?php
namespace Mouf\Utils\Common\Validators;
/**
 * Numeric validator: validates a input to be a numeric value.
 * Validation may be specified if decimal values are accepted
 * @ApplyTo { "php" : [ "int", "number" ] }
 * @Component
 */
class NumericValidator extends AbstractValidator implements JsValidatorInterface{
	
	/**
	 * Whether or not decimal values are accepted
	 * @Property
	 * @var bool
	 */
	public $allowDecimals = true;
	
	public $allowEmpty = true;
	
	/**
	 * (non-PHPdoc)
	 * @see ValidatorInterface::validate()
	 */
	function doValidate($value){
		if (empty($value) && $this->allowEmpty) return true;
		return $this->allowDecimals ? preg_match("/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/", $value) : preg_match("/^\d+$/", $value);
	}

	/**
	 * (non-PHPdoc)
	 * @see JsValidatorInterface::getScript()
	 */
	function getScript(){
		$regex = $this->allowDecimals ? "/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/" : "/^\d+$/";
		return "function(value, element){
			if (!value) return true;
			return $regex.test(value);
		}";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see JsValidatorInterface::getErrorMessage()
	 */
	function getErrorMessage(){
		return $this->allowDecimals ? ValidatorUtils::translate("validate.numeric") : ValidatorUtils::translate("validate.integer");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see JsValidatorInterface::getJsArguments()
	 */
	function getJsArguments(){
		return true;
	}
}
?>