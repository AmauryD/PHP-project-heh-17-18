<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 20-02-18
 * Time: 10:50
 */

namespace Framework\View;

use Exception;
use framework\Exception\FatalErrorException;

class ViewBlock
{
    /** blocks list
     * @var array $blocks
     */
    private $blocks;
    /** current view block
     * @var string $current_block
     */
    private $current_block;

    /**
     * ViewBlock constructor.
     */
    public function __construct()
    {
        $this->blocks = [];
    }

    /**
     * add/override a block with @value
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->blocks[$name] = (string)$value;
    }

    /**
     * Begin registering block content
     * @param $name
     * @throws Exception
     */
    public function begin($name)
    {
        if ($this->current_block)
            throw new FatalErrorException("Block " . $this->current_block . " is not closed");

        $this->current_block = $name;
        ob_start();
    }


    /**
     * Check if block exists
     * @param $blockName
     * @return bool
     */
    public function hasBlock($blockName)
    {
        return array_key_exists($blockName,$this->blocks);
    }

    /**
     * Ends registering current block content
     * @throws Exception
     */
    public function end()
    {
        if (!$this->current_block)
            throw new FatalErrorException("No block is opened");

        $this->blocks[$this->current_block] = (string)ob_get_clean();
        $this->current_block = null;
    }

    /**
     * Gets a block content
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function get($name)
    {
        if (!$this->hasBlock($name))
            throw new FatalErrorException("Block $name does not exists");

        return $this->blocks[$name];
    }
}