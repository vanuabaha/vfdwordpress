<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 *
 * @copyright Copyright (c)2006-2015 Nicholas K. Dionysopoulos
 * @license   GNU GPL version 3 or, at your option, any later version
 * @package   akeebaengine
 *
 */

namespace Akeeba\Engine\Archiver;

// Protection against direct access
defined('AKEEBAENGINE') or die();

use Akeeba\Engine\Util\Transfer\Ftp;
use Psr\Log\LogLevel;
use Akeeba\Engine\Factory;

/**
 * Direct Transfer Over FTP archiver class
 *
 * Transfers the files to a remote FTP server instead of putting them in
 * an archive
 *
 */
class Directftp extends Base
{
	/** @var Ftp FTP resource handle */
	private $ftpTransfer;

	/** @var string FTP hostname */
	private $host;

	/** @var string FTP port */
	private $port;

	/** @var string FTP username */
	private $user;

	/** @var string FTP password */
	private $pass;

	/** @var bool Should we use FTP over SSL? */
	private $usessl;

	/** @var bool Should we use passive FTP? */
	private $passive;

	/** @var string FTP initial directory */
	private $initdir;

	/** @var bool Could we connect to the server? */
	public $connect_ok = false;

	/**
	 * Initialises the archiver class, seeding the remote installation
	 * from an existent installer's JPA archive.
	 *
	 * @param string $targetArchivePath Absolute path to the generated archive (ignored in this class)
	 * @param array  $options           A named key array of options (optional)
	 *
	 * @return  void
	 */
	public function initialize($targetArchivePath, $options = array())
	{
		Factory::getLog()->log(LogLevel::DEBUG, __CLASS__ . " :: new instance");

		$registry = Factory::getConfiguration();

		$this->host    = $registry->get('engine.archiver.directftp.host', '');
		$this->port    = $registry->get('engine.archiver.directftp.port', '21');
		$this->user    = $registry->get('engine.archiver.directftp.user', '');
		$this->pass    = $registry->get('engine.archiver.directftp.pass', '');
		$this->initdir = $registry->get('engine.archiver.directftp.initial_directory', '');
		$this->usessl  = $registry->get('engine.archiver.directftp.ftps', false);
		$this->passive = $registry->get('engine.archiver.directftp.passive_mode', true);

		if (isset($options['host']))
		{
			$this->host = $options['host'];
		}

		if (isset($options['port']))
		{
			$this->port = $options['port'];
		}

		if (isset($options['user']))
		{
			$this->user = $options['user'];
		}

		if (isset($options['pass']))
		{
			$this->pass = $options['pass'];
		}

		if (isset($options['initdir']))
		{
			$this->initdir = $options['initdir'];
		}

		if (isset($options['usessl']))
		{
			$this->usessl = $options['usessl'];
		}

		if (isset($options['passive']))
		{
			$this->passive = $options['passive'];
		}

		// You can't fix stupid, but at least you get to shout at them
		if (strtolower(substr($this->host, 0, 6)) == 'ftp://')
		{
			Factory::getLog()->log(LogLevel::WARNING, 'YOU ARE *** N O T *** SUPPOSED TO ENTER THE ftp:// PROTOCOL PREFIX IN THE FTP HOSTNAME FIELD OF THE DirectFTP ARCHIVER ENGINE.');
			Factory::getLog()->log(LogLevel::WARNING, 'I am trying to fix your bad configuration setting, but the backup might fail anyway. You MUST fix this in your configuration.');
			$this->host = substr($this->host, 6);
		}

		$this->connect_ok = $this->connectFTP();

		Factory::getLog()->log(LogLevel::DEBUG, __CLASS__ . " :: FTP connection status: " . ($this->connect_ok ? 'success' : 'FAIL'));
	}

	/**
	 * Returns a string with the extension (including the dot) of the files produced
	 * by this class.
	 *
	 * @return string
	 */
	public function getExtension()
	{
		return '';
	}


	/**
	 * The most basic file transaction: add a single entry (file or directory) to
	 * the archive.
	 *
	 * @param bool   $isVirtual        If true, the next parameter contains file data instead of a file name
	 * @param string $sourceNameOrData Absolute file name to read data from or the file data itself is $isVirtual is
	 *                                 true
	 * @param string $targetName       The (relative) file name under which to store the file in the archive
	 *
	 * @return boolean True on success, false otherwise
	 */
	protected function _addFile($isVirtual, &$sourceNameOrData, $targetName)
	{
		// Are we connected to a server?
		if ( !$this->ftpTransfer)
		{
			if ( !$this->connectFTP())
			{
				return false;
			}
		}

		// See if it's a directory
		$isDir = $isVirtual ? false : is_dir($sourceNameOrData);

		if ($isDir)
		{
			// Just try to create the remote directory
			return $this->makeDirectory($targetName);
		}
		else
		{
			// We have a file we need to upload
			if ($isVirtual)
			{
				// Create a temporary file, upload, rename it
				$tempFileName = Factory::getTempFiles()->createRegisterTempFile();

				if (function_exists('file_put_contents'))
				{
					// Easy writing using file_put_contents
					if (@file_put_contents($tempFileName, $sourceNameOrData) === false)
					{
						$this->setError('Could not store virtual file ' . $targetName . ' to ' . $tempFileName . ' using file_put_contents() before uploading.');

						return false;
					}
				}
				else
				{
					// The long way, using fopen() and fwrite()
					$fp = @fopen($tempFileName, 'wb');

					if ($fp === false)
					{
						$this->setError('Could not store virtual file ' . $targetName . ' to ' . $tempFileName . ' using fopen() before uploading.');

						return false;
					}
					else
					{
						$result = @fwrite($fp, $sourceNameOrData);

						if ($result === false)
						{
							$this->setError('Could not store virtual file ' . $targetName . ' to ' . $tempFileName . ' using fwrite() before uploading.');

							return false;
						}

						@fclose($fp);
					}
				}

				// Upload the temporary file under the final name
				$res = $this->upload($tempFileName, $targetName);

				// Remove the temporary file
				Factory::getTempFiles()->unregisterAndDeleteTempFile($tempFileName, true);

				return $res;
			}
			else
			{
				// Upload a file
				return $this->upload($sourceNameOrData, $targetName);
			}
		}
	}

	/**
	 * "Magic" function called just before serialization of the object. Disconnects
	 * from the FTP server and allows PHP to serialize like normal.
	 *
	 * @return array The variables to serialize
	 */
	public function _onSerialize()
	{
        // Explicitally unset the ftpTransfer class so the destructor magic method is called (and the connection is closed)
		unset($this->ftpTransfer);

		return array_keys(get_object_vars($this));
	}

	/**
	 * Tries to connect to the remote FTP server and change into the initial directory
	 *
	 * @return bool True is connection successful, false otherwise
	 */
	protected function connectFTP()
	{
		Factory::getLog()->log(LogLevel::DEBUG, 'Connecting to remote FTP');

        $options = array(
            'host'      => $this->host,
            'port'      => $this->port,
            'username'  => $this->user,
            'password'  => $this->pass,
            'directory' => $this->initdir,
            'ssl'       => $this->usessl,
            'passive'   => $this->passive
        );

        try
        {
            $this->ftpTransfer = new Ftp($options);
        }
        catch(\RuntimeException $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

		$this->resetErrors();

		return true;
	}

	/**
	 * Changes to the requested directory in the remote server. You give only the
	 * path relative to the initial directory and it does all the rest by itself,
	 * including doing nothing if the remote directory is the one we want. If the
	 * directory doesn't exist, it creates it.
	 *
	 * @param $dir string The (realtive) remote directory
	 *
	 * @return bool True if successful, false otherwise.
	 */
	protected function ftp_chdir($dir)
	{
		// Calculate "real" (absolute) FTP path
        $realdir = $this->ftpTransfer->getPath($dir);

		if ($this->initdir == $realdir)
		{
			// Already there, do nothing
			return true;
		}

		$result = $this->ftpTransfer->isDir($realdir);

		if ($result === false)
		{
			// The directory doesn't exist, let's try to create it...
			if ( !$this->makeDirectory($dir))
			{
				return false;
			}
        }

		return true;
	}

	/**
	 * Recursively create a directory in the FTP server
	 *
	 * @param   string $dir The directory to create
	 *
	 * @return  bool  True on success
	 */
	protected function makeDirectory($dir)
	{
		$alldirs     = explode('/', $dir);
		$previousDir = substr($this->initdir, -1) == '/' ? substr($this->initdir, 0, strlen($this->initdir) - 1) : $this->initdir;
		$previousDir = substr($previousDir, 0, 1) == '/' ? $previousDir : '/' . $previousDir;

		foreach ($alldirs as $curdir)
		{
			$check = $previousDir . '/' . $curdir;

			if ( !$this->ftpTransfer->isDir($check))
			{
				if (@$this->ftpTransfer->mkdir($check) === false)
				{
					$this->setError('Could not create directory ' . $new_dir);

					return false;
				}
			}

			$previousDir = $check;
		}

		return true;
	}

	/**
	 * Uploads a file to the remote server
	 *
	 * @param $sourceName string The absolute path to the source local file
	 * @param $targetName string The relative path to the targer remote file
	 *
	 * @return bool True if successful
	 */
	protected function upload($sourceName, $targetName)
	{
		// Try to change into the remote directory, possibly creating it if it doesn't exist
		$dir = dirname($targetName);

		if ( !$this->ftp_chdir($dir))
		{
			return false;
		}

		// Upload
		$realdir = substr($this->initdir, -1) == '/' ? substr($this->initdir, 0, strlen($this->initdir) - 1) : $this->initdir;
		$realdir .= '/' . $dir;
		$realdir  = substr($realdir, 0, 1) == '/' ? $realdir : '/' . $realdir;
		$realname = $realdir . '/' . basename($targetName);

        try
        {
            $res = $this->ftpTransfer->upload($sourceName, $realname);
        }
        catch(\RuntimeException $e)
        {
            $res = false;
        }

		if ( !$res)
		{
			// If the file was unreadable, just skip it...
			if (is_readable($sourceName))
			{
				$this->setError('Uploading ' . $targetName . ' has failed.');

				return false;
			}
			else
			{
				$this->setWarning('Uploading ' . $targetName . ' has failed because the file is unreadable.');

				return true;
			}
		}
		else
		{
            $this->ftpTransfer->chmod($realdir, 0755);

			return true;
		}
	}
}