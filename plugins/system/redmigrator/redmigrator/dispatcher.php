<?php
/**
 * @package     redMIGRATOR.Backend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2012 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 *  redMIGRATOR is based on JUpgradePRO made by Matias Aguirre
 */
defined('_JEXEC') or die;

/**
 * REST Request Dispatcher class
 *
 * @package     Joomla.Platform
 * @subpackage  REST
 * @since       3.0
 */
class JRESTDispatcher
{
	/**
	 * @var    array  Associative array of parameters for the REST message.
	 * @since  3.0
	 */
	private $_parameters = array();

	/**
	 * @var    redMigratorTable  redMigratorTable object
	 * @since  3.0
	 */
	private $_table = array();

	/**
	 *
	 *
	 * @param $parameters
	 *
	 * @return bool
	 * @since   3.0
	 */
	public function execute($parameters)
	{
		// Getting the database instance
		$db = JFactory::getDbo();

		// Loading params
		$this->_parameters = $parameters;

		$task  = isset($this->_parameters['HTTP_TASK']) ? $this->_parameters['HTTP_TASK'] : '';
		$name  = $table = isset($this->_parameters['HTTP_TABLE']) ? $this->_parameters['HTTP_TABLE'] : '';
		$files = isset($this->_parameters['HTTP_FILES']) ? $this->_parameters['HTTP_FILES'] : '';

		// Fixing table if is extension
		$table = (substr($table, 0, 4) == 'ext_') ? substr($table, 4) : $table;

		// Check task is only to test the connection
		if ($task == 'check')
		{
			return true;
		}

		// Loading table
		if (isset($table))
		{
			JTable::addIncludePath(JPATH_ROOT . DS . 'plugins' . DS . 'system' . DS . 'redmigrator' . DS . 'table');
			$class = @redMigratorTable::getInstance($name, 'redMigratorTable');

			if (!is_object($class))
			{
				$class = redMigratorTable::getInstance('generic', 'redMigratorTable');
				$class->changeTable($table);
			}
		}
		elseif (isset($files))
		{
			require_once JPATH_ROOT . DS . 'plugins' . DS . 'system' . DS . 'redmigrator' . DS . 'files.php';
			$class = new redMigratorFiles();
		}

		// Get the method name
		$method = 'get' . ucfirst($task);

		// Does the method exist?
		if (method_exists($class, $method))
		{
			return $class->$method();
		}
		else
		{
			return false;
		}
	}
}
