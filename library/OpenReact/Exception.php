<?php
/**
	OpenReact

  	LICENSE:
  	This source file is subject to the Simplified BSD license that is
  	bundled	with this package in the file LICENSE.txt.
	It is also available through the world-wide-web at this URL:
	http://account.react.com/license/simplified-bsd
	If you did not receive a copy of the license and are unable to
	obtain it through the world-wide-web, please send an email
	to openreact-license@react.com so we can send you a copy immediately.

	Copyright (c) 2012 React B.V. (http://www.react.com)
*/
/**
	Exception class for usage by OpenReact classes.
	Add message parameters plus exception 'autocreation'.
*/

class OpenReact_Exception extends Exception
{
	/**
		Construct an exception.

		Parameters:
			message - (string) Exception message, also supports printf() formatting with the second parameters
			params - (array) Parameters for insertion in the message
			previous - (Exception|null) Exception which 'caused' this exception
			code - (int) Error/exception code
	*/
	public function __construct($message, array $params = array(), $previous = null, $code = 0)
	{
		if (false !== strpos($message, '%s') && is_array($params) && !empty($params))
			$message = vsprintf($message, $params);

		// PHP 5.2 is still supported, but doesn't feature the $previous parameter
		if (isset($previous) && $previous instanceof Exception && version_compare(PHP_VERSION, '5.3.0') >= 0)
			parent::__construct($message, $code, $previous);
		else
			parent::__construct($message, $code);
	}

	/**
		Try to auto-create a non-existing OpenReact_*Exception class.

		Parameters:
			className - (string) class to autoload

		Returns:
			(boolean) if the class was loaded (and thus created)
	*/
	public static function autocreate($className)
	{
		if (!preg_match('~^OpenReact_[a-zA-Z0-9_]+Exception$~', $classname))
			return false;

		eval('class ' . $className . ' extends OpenReact_Exception {};');
	}
}