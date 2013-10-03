<?php
/**
 * @package     RedMIGRATOR.Backend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2005 - 2013 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * 
 *  redMIGRATOR is based on JUpgradePRO made by Matias Aguirre
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Users table
 *
 * @since  1.0
 */
class RedMigratorTableUsers extends RedMigratorTable
{
	/**
	 * Unique id
	 *
	 * @var int
	 */
	var $id				= null;

	/**
	 * The users real name (or nickname)
	 *
	 * @var string
	 */
	var $name			= null;

	/**
	 * The login name
	 *
	 * @var string
	 */
	var $username		= null;

	/**
	 * The email
	 *
	 * @var string
	 */
	var $email			= null;

	/**
	 * MD5 encrypted password
	 *
	 * @var string
	 */
	var $password		= null;

	/**
	 * Description
	 *
	 * @var string
	 */
	var $usertype		= null;

	/**
	 * Description
	 *
	 * @var int
	 */
	var $block			= null;

	/**
	 * Description
	 *
	 * @var int
	 */
	var $sendEmail		= null;

	/**
	 * Description
	 *
	 * @var datetime
	 */
	var $registerDate	= null;

	/**
	 * Description
	 *
	 * @var datetime
	 */
	var $lastvisitDate	= null;

	/**
	 * Description
	 *
	 * @var string activation hash
	 */
	var $activation		= null;

	/**
	 * Description
	 *
	 * @var string
	 */
	var $params			= null;

	/**
	 * Table type
	 *
	 * @var string
	 */	
	var $_type = 'users';

	/**
	* @param database A database connector object
	*/
	function __construct ( &$db )
	{
		parent::__construct('#__users', 'id', $db);

		// Initialise
		$this->id        = 0;
		$this->sendEmail = 0;
	}

	/**
	 *
	 * @access	public
	 * @param   Array	Result to migrate
	 * @return	Array	Migrated result
	 */
	function migrate ()
	{
		// Fixing the params compatible with 2.5/3.0
		$this->params = $this->convertParams($this->params);

		// Chaging admin username and email
		if ($this->id == 62)
		{
			$this->username = $this->username . 'v15';
			$this->email = $this->email . 'v15';
		}
	}

	/**
	 * A hook to be able to modify params prior as they are converted to JSON.
	 *
	 * @param	object	$object	A reference to the parameters as an object.
	 *
	 * @return	void
	 *
	 * @since	0.4.
	 * @throws	Exception
	 */
	protected function convertParamsHook(&$object)
	{
		$object->timezone = 'UTC';
	}
}
