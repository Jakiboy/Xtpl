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

class FileException extends Exception
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
			case 'notfound':
				$this->error = 'Cannot find requested Xtpl template file';
				break;

			case 'unreadable':
				$this->error = 'Unable to read Xtpl template file, please check permission';
				break;
			
			default:
				$this->error = 'Unhandled exception';
				break;
		}
		return "Error : {$this->error}";
	}
}
