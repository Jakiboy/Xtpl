<?php

/**
 * @author   : JIHAD SINNAOUR
 *
 * @version  : 0.1
 *
 * @category : PHP frameework | FloatPHP
 *
 * @link     : https://www.floatphp.com/
 */

// namespace floatphp\System\Class\Storage;

include 'FileInterface.php';

// use \floatphp\System\Interface\Storage\FileInterface;
/**
 * @ OK
 */
class File implements FileInterface
{
    public $path;
    public $root;
    public $name;
    public $ext;
    public $parent;
    public $content;

    private $handler;

    protected $mode;

    /**
     * File object.
     *
     * @param string $path, $mode
     *
     * @return void
     */
    public function __construct($path = null, $mode = 'r')
    {
        $this->set($path, $mode);
        $this->isReady();
        $this->open();
    }

    /**
     * define properties.
     *
     * @param string $path, $mode
     *
     * @return void
     */
    private function set($path, $mode)
    {
        $this->path = $path;
        $this->mode = $mode;
        $this->parent = dirname($this->path);
        $this->root = realpath($this->path);
        $this->ext = pathinfo($this->path, PATHINFO_EXTENSION);
        $this->name = str_replace('.'.$this->ext, '', $this->path);
    }

    /**
     * check file.
     *
     * @param void
     *
     * @return void
     */
    public function isReady()
    {
        if (!$this->exists()) {
            throw new Exception('File '.$this->path.' doesn\'t exist');
        } elseif (!$this->readable()) {
            throw new Exception('Error reading the file : '.$this->path);
        } else {
            return true;
        }
    }

    /**
     * create file.
     *
     * @param void
     *
     * @return void
     */
    protected function create()
    {
        $this->handler = fopen($this->path, 'w');
    }

    /**
     * open file.
     *
     * @param void
     *
     * @return void
     */
    protected function open()
    {
        if ($this->exists($this->path)) {
            $this->handler = fopen($this->path, $this->mode);
        }
    }

    /**
     * write file.
     *
     * @param void
     *
     * @return void
     */
    public function write($input)
    {
        fwrite(fopen($this->path, 'w'), $input);
    }

    /**
     * add string to file.
     *
     * @param string $input
     *
     * @return void
     */
    public function addString($input)
    {
        fwrite(fopen($this->path, 'a'), $input);
    }

    /**
     * add space to file.
     *
     * @param void
     *
     * @return void
     */
    public function addSpace()
    {
        fwrite(fopen($this->path, 'a'), PHP_EOL);
    }

    /**
     * read file.
     *
     * @param void
     *
     * @return void
     */
    public function read()
    {
        if ($this->exists($this->path) && !$this->isEmpty()) {
            $this->content = fread($this->handler, filesize($this->path));
        }
    }

    /**
     * close file handler.
     *
     * @param void
     *
     * @return void
     */
    public function close()
    {
        fclose($this->handler);
    }

    /**
     * delete file object.
     *
     * @param void
     *
     * @return void
     */
    public function delete()
    {
        $this->close();
        unlink($this->path);
    }

    /**
     * check file exists.
     *
     * @param void
     *
     * @return void
     */
    protected function exists()
    {
        if (is_file($this->path) && file_exists($this->path)) {
            return true;
        }
    }

    /**
     * check file readable.
     *
     * @param void
     *
     * @return void
     */
    protected function readable()
    {
        if (!fopen($this->path, 'r') === false) {
            return true;
        }
    }

    /**
     * check file empty.
     *
     * @param void
     *
     * @return void
     */
    public function isEmpty()
    {
        if ($this->exists($this->path)) {
            if (filesize($this->path) == 0) {
                return true;
            }
        }
    }
}
