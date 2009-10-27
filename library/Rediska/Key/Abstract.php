<?php

/**
 * @see Rediska
 */
require_once 'Rediska.php';

/**
 * @see Rediska_Key_Exception
 */
require_once 'Rediska/Key/Exception.php';

/**
 * Rediska key abstract class
 * 
 * @author Ivan Shumkov
 * @package Rediska
 * @version 0.2.1
 * @link http://code.google.com/p/rediska
 * @licence http://opensource.org/licenses/gpl-3.0.html
 */
abstract class Rediska_Key_Abstract
{
	/**
	 * Key name
	 * 
	 * @var string
	 */
	protected $_name;

	/**
	 * Rediska instance
	 * 
	 * @var Rediska
	 */
	protected $_rediska;

	/**
	 * Construct key
	 * 
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->_name = $name;

		$this->_setupRediskaDefaultInstance();
	}

	/**
	 * Delete key
	 * 
	 * @return boolean
	 */
	public function delete()
	{
		return $this->getRediska()->delete($this->_name);
	}

	/**
     * Exists in db
     * 
     * @return boolean
     */
	public function isExists()
	{
		return $this->getRediska()->exists($this->_name);
	}

	/**
	 * Get key type
	 * 
	 * @see Rediska#getType
	 * @return string
	 */
	public function getType()
	{
		return $this->getRediska()->getType($this->_name);
	}

	/**
	 * Rename key
	 * 
	 * @param string  $newName
	 * @param boolean $overwrite
	 * @return boolean
	 */
	public function rename($newName, $overwrite = true)
	{
		try {
		  $this->getRediska()->rename($this->_name, $newName, $overwrite);
		} catch (Rediska_Exception $e) {
			return false;
		}

		$this->_name = $newName;

		return true;
	}

	/**
	 * Expire key
	 * 
	 * @param integer $seconds
	 * @return boolean
	 */
	public function expire($seconds)
	{
		return $this->getRediska()->expire($this->_name, $seconds);
	}

	/**
	 * Get key lifetime
	 * 
	 * @return integer
	 */
	public function getLifetime()
	{
		return $this->getRediska()->getLifetime($this->_name);
	}

	/**
	 * Move key to other Db
	 * 
	 * @see Rediska#moveToDb
	 * @param integer $dbIndex
	 * @return boolean
	 */
	public function moveToDb($dbIndex)
	{
		return $this->getRediska()->moveToDb($this->_name, $dbIndex);
	}

	/**
     * Get key name
     * 
     * @return string
     */
	public function getName()
	{
		return $this->_name;
	}

	/**
     * Set key name
     * 
     * @param string $name
     * @return Rediska_Key_Abstract
     */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

    /**
     * Set Rediska instance
     * 
     * @param Rediska $rediska
     * @return Rediska_Key_Abstract
     */
    public function setRediska(Rediska $rediska)
    {
        $this->_rediska = $rediska;
        
        return $this;
    }

    /**
     * Get Rediska instance
     * 
     * @return Rediska
     */
    public function getRediska()
    {
        if (!$this->_rediska instanceof Rediska) {
            throw new Rediska_Key_Exception('Rediska instance not found for ' . get_class($this));
        }

        return $this->_rediska;
    }

	/**
	 * Setup Rediska instance
	 */
    protected function _setupRediskaDefaultInstance()
    {
        $this->_rediska = Rediska::getDefaultInstance();
    }
}