<?php

/**
 * @package Xtpl (Ajax Template Transformer)
 * @category PHP/Ajax HTML Render Class
 * @version 1.0.0
 * @author JIHAD SINNAOUR
 * @copyright (c) 2018 JIHAD SINNAOUR <j.sinnaour.official@gmail.com>
 * @license MIT
 * @link https://jakiboy.github.io/Xtpl/
 */

namespace Jakiboy\Xtpl;

class XTPLException extends Exception
{
	/**
	 * @access protected
	 * custom message handler
	 */
	protected $error;

	/**
	 * @access protected
	 * custom error handler
	 */
	public function message()
	{
		$this->error = $this->getMessage();

		switch ($this->error)
		{
			case 'single':
				$this->error = 'Cannot use transformAll on single array, use transform instead';
				break;			

			case 'multiple':
				$this->error = 'Cannot use transform on multiple array, use transformAll instead';;
				break;
			
			default:
				$this->error = 'Unhandled exception';
				break;
		}
		return "Error : {$this->error}";
	}
}
