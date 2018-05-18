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

interface XTPLInterface
{
	public static function build($path = null);
	public function transformAll(array $dataArray);
	public function transform(array $dataArray);
	public function setDelimiter($start,$end);
	public function shortcodeIn($shortcode);
	public function clear();
}
