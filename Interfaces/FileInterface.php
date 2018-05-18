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

interface FileInterface
{
	public function isReady();
	public function write($input);
	public function addString($input);
	public function addSpace();
	public function read();
	public function close();
	public function delete();
	public function isEmpty();
}