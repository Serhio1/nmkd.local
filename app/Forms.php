 <?php

class Forms
{
	//formAlias => array(input_name => array(validation_rule1, validation_rule2))
	public $forms = array(
		'loginForm' => array(
			'login' => array('standardLengthRule'),
			'password' => array('standardLengthRule'),
		),

		'registerForm' => array(
			'login' => array('standardLengthRule'),
			'password' => array('standardLengthRule','confirmRule'),
			'confirm_password' => array(),
		),
	);


	public function standardLengthRule($str, $field)
	{		
		if ((mb_strlen($str,'UTF-8') > 2) && ((mb_strlen($str,'UTF-8') < 21))) {
			//Container::get('errors')->addError('std_login_length');	
			return true;
		}
		
		return false;
	}

	public function confirmRule($str, $field)
	{
		if (isset($_POST['confirm_'.$field])) {
			if ($str == $_POST['confirm_'.$field]) {
				return true;
			} else {
				//error: $field is not confirmed
			}
		}
		
		
		return false;
	}
}
