<?php
/**
 * @package		solo
 * @copyright	2014 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license		GNU GPL version 3 or later
 */

namespace Solo\Pythia\Oracle;

use Solo\Pythia\OracleInterface;

class Magento2 implements OracleInterface
{
	protected $path = null;

    /**
	 * Creates a new oracle objects
	 *
	 * @param   string  $path  The directory path to scan
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}

	/**
	 * Does this class recognises the site as a Moodle installation?
	 *
	 * @return  boolean
	 */
	public function isRecognised()
	{
        if (!@file_exists($this->path . '/bin/magento'))
        {
            return false;
        }

        if (!@file_exists($this->path . '/app/etc/env.php'))
        {
            return false;
        }

        if (!@is_dir($this->path . '/app'))
        {
            return false;
        }

        return true;
	}

    /**
	 * Return the name of the CMS / script (joomla)
	 *
	 * @return  string
	 */
	public function getName()
	{
		return 'magento2';
	}

	/**
	 * Return the default installer name for this CMS / script (angie)
	 *
	 * @return  string
	 */
	public function getInstaller()
	{
		return 'angie-magento2';
	}

	/**
	 * Return the database connection information for this CMS / script
	 *
	 * @return  array
	 */
	public function getDbInformation()
	{
		$ret = array(
			'driver'	=> 'mysqli',
			'host'		=> '',
			'port'		=> '',
			'username'	=> '',
			'password'	=> '',
			'name'		=> '',
			'prefix'	=> '',
		);

        $config = include_once $this->path . '/app/etc/env.php';

        $ret['host']     = $config['db']['connection']['default']['host'];
        $ret['username'] = $config['db']['connection']['default']['username'];
        $ret['password'] = $config['db']['connection']['default']['password'];
        $ret['name']     = $config['db']['connection']['default']['dbname'];
        $ret['prefix']   = $config['db']['table_prefix'];

        return $ret;
	}

    public function getExtradirs()
	{
		return array();
	}

    public function getExtraDb()
    {
        return array();
    }
}