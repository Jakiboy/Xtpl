<?php

/**
 * @author   : JIHAD SINNAOUR
 * @package  : Html
 * @version  : 0.1
 * @category : PHP frameework | FloatPHP
 * @link     : https://www.floatphp.com/
 */

// namespace floatphp\System\Class\Html;

include('File.php');
// use \floatphp\System\Class\Storage\File;

class Xtpl
{
	/**
	 * @access public
	 */
	public $shortcode = [];
	public $response;
	/**
	 * @access protected
	 */
	protected $file;
	protected $delimiter = "{%s%}";

	/**
	 * Xtpl object
	 *
	 * @param string $path
	 * @return void
	 */
	public function __construct($path = null)
	{
		// bind template file
		try {

			$this->file = new File($path);
			
		} catch (Exception $e) {

			die($e->getMessage());
		}
		// read file content
		$this->file->read();
	}
	/**
	 * static Xtpl object
	 *
	 * @param string $path
	 * @return void
	 */
	public static function build($path = null)
	{
		return new self( $path );
	}
	/**
	 * set custom delimiter
	 *
	 * @param string $start starting delimiter,$end ending delimiter
	 * @return string
	 */
	public function setDelimiter($start, $end)
	{
		return $this->delimiter = $start . '%s%' . $end;
	}
	/**
	 * transform shortcode to content
	 *
	 * @param array $dataArray
	 * @return object Xtpl
	 * @see multidimensional array
	 *
	 * using transform method on multi-dimensional array,
	 * or on non-multi-dimensional array by loop	 
	 */
	public function transform(array $dataArray)
	{
		try 
		{
			$this->isSingle($dataArray);	
		}
		catch (Exception $e) 
		{
			die($e->getMessage());
		}
		// initialization
		$result = [];

		foreach ($dataArray as $entity => $data)
		{
			$shortcode = $this->doShortcode($entity);
			$this->catchShortcode($shortcode);
			// bind data into shortcode
			$result[$shortcode] = $data;
		}
		if ( $this->response ){

			// assembly result for multiple use
			$this->response = $this->replace($result, $this->response);

		}else{

			// assembly result for one use
			$this->response .= $this->replace($result);
		}
		return $this;
	}
	/**
	 * transform shortcode to content for array like SQL response
	 *
	 * @param array $dataArray
	 * @return object Xtpl
	 *
	 * using transform method on multi-dimensional array only	 
	 */
	public function transformAll(array $dataArray)
	{
		try 
		{
			$this->isMultiple($dataArray);	
		}
		catch (Exception $e) 
		{
			die($e->getMessage());
		}
		// initialization
		$this->response = null;

		foreach ($dataArray as $data)
		{
			$shortcodeArray = array_keys($data);
			// initialization
			$result = [];

			foreach ($shortcodeArray as $entity)
			{
				$shortcode = $this->doShortcode($entity);
				$this->catchShortcode($shortcode);
				// bind data into shortcode
				$result[$shortcode] = $data[$entity];
			}
			// assembly result for one use
			$this->response .= $this->replace($result);
		}
		return $this;
	}
	/**
	 * catch and return accepted shortcodes to class
	 *
	 * @param string $s shortcode
	 * @return void
	 */
	private function catchShortcode($s)
	{
		$this->shortcode[] = $s;
		$this->shortcode = array_unique($this->shortcode);
	}
	/**
	 * return shortcode from data
	 *
	 * @param string $e 
	 * @return string
	 */
	private function doShortcode($e)
	{
		return str_replace("%s%", $e, $this->delimiter);
	}
	/**
	 * check shortcode existence
	 *
	 * @param string $shortcode 
	 * @return boolean
	 */
	public function shortcodeIn($shortcode)
	{
		$start = substr($this->delimiter, 0, 1);
		$end = substr($this->delimiter, -1, 1);

		// catch all shortcodes with current delimiter
		if ($start == '[')
		{
			$start = '\\' . $start;
		}
		$pattern = '/' . $start . '(.*?)' . $end . '/';

		preg_match_all($pattern, $this->file->content, $match);
		$list = array_shift($match);

		// search target shortcode
		if (in_array($shortcode, $list))
		{
			return true;
		}
	}
	/**
	 * clear unreplaced shortcodes
	 *
	 * @param void
	 * @return void
	 */
	public function clear()
	{
		$start = substr($this->delimiter, 0, 1);
		$end = substr($this->delimiter, -1, 1);

		// catch all shortcodes with current delimiter
		if ($start == '[') 
		{
			$start = '\\' . $start;
		}
		$pattern = '/' . $start . '(.*?)' . $end . '/';

		preg_match_all($pattern, $this->response, $match);
		$list = array_shift($match);

		foreach ($list as $shortcode) {
			$this->response = str_replace($shortcode, '', $this->response);
		}
		return $this;
	}
	/**
	 * replace keys of array
	 *
	 * @param array $replace, string $target 
	 * @return boolean
	 */
	private function replace($replace, $target = null)
	{
		if (is_null($target)) {
			return str_replace(array_keys($replace), $replace, $this->file->content);
		}else{
			return str_replace(array_keys($replace), $replace, $target);
		}
	}
	/**
	 * @todo Exception
	 */
	private function isMultiple(array $array)
	{
		foreach ($array as $sub)
		{
		    if (is_array($sub)){
		      return true;
		    }else{
		    	throw new Exception("Cannot use transformAll on single array, use transform instead", 0);
		    }
		}
	}
	/**
	 * @todo Exception
	 */
	private function isSingle(array $array)
	{
		foreach ($array as $sub)
		{
		    if (!is_array($sub)){
		      return true;
		    }else{
		    	throw new Exception("Cannot use transform on multiple array, use transformAll instead", 0);
		    }
		}
	}
}
