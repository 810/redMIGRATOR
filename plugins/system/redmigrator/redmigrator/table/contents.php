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
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();


/**
 * Content table
 *
 * @package 	Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class redMigratorTableContents extends redMigratorTable
{
	/** @var int Primary key */
	var $id					= null;
	/** @var string */
	var $title				= null;
	/** @var string */
	var $alias				= null;
	/** @var string */
	var $title_alias		= null;
	/** @var string */
	var $introtext			= null;
	/** @var string */
	var $fulltext			= null;
	/** @var int */
	var $state				= null;
	/** @var int The id of the category section*/
	var $sectionid			= null;
	/** @var int DEPRECATED */
	var $mask				= null;
	/** @var int */
	var $catid				= null;
	/** @var datetime */
	var $created			= null;
	/** @var int User id*/
	var $created_by			= null;
	/** @var string An alias for the author*/
	var $created_by_alias	= null;
	/** @var datetime */
	var $modified			= null;
	/** @var int User id*/
	var $modified_by		= null;
	/** @var boolean */
	var $checked_out		= 0;
	/** @var time */
	var $checked_out_time	= 0;
	/** @var datetime */
	var $publish_up			= null;
	/** @var datetime */
	var $publish_down		= null;
	/** @var string */
	var $images				= null;
	/** @var string */
	var $urls				= null;
	/** @var string */
	var $attribs			= null;
	/** @var int */
	var $version			= null;
	/** @var int */
	var $parentid			= null;
	/** @var int */
	var $ordering			= null;
	/** @var string */
	var $metakey			= null;
	/** @var string */
	var $metadesc			= null;
	/** @var string */
	var $metadata			= null;
	/** @var int */
	var $access				= null;
	/** @var int */
	var $hits				= null;

	/**
	 * Table type
	 *
	 * @var string
	 */	
	var $_type = 'contents';	

	/**
	* @param database A database connector object
	*/
	function __construct( &$db ) {
		parent::__construct( '#__content', 'id', $db );
	}

	/**
	 * 
	 *
	 * @access	public
	 * @param		Array	Result to migrate
	 * @return	Array	Migrated result
	 */
	function migrate( )
	{	
		$this->attribs = $this->convertParams($this->attribs);
		$this->access = $this->access == 0 ? 1 : $this->access + 1;
		$this->language = '*';

		// Correct state
		if ($this->state == -1) {
			$this->state = 2;
		}

		// Prevent JGLOBAL_ARTICLE_MUST_HAVE_TEXT error
		if (trim($this->introtext) == '' && trim($this->fulltext) == '')
		{
			$this->introtext = '&nbsp;';
		}
	}

	/**
	 * A hook to be able to modify params prior as they are converted to JSON.
	 *
	 * @param	object	$object	A reference to the parameters as an object.
	 *
	 * @return	void
	 * @since	0.4.
	 * @throws	Exception
	 */
	protected function convertParamsHook(&$object)
	{
		$object->show_parent_category = isset($object->show_parent_category) ? $object->show_parent_category : "";
		$object->link_parent_category = isset($object->link_parent_category) ? $object->link_parent_category : "";
		$object->show_author = isset($object->show_author) ? $object->show_author : "";
		$object->link_author = isset($object->link_author) ? $object->link_author : "";
		$object->show_publish_date = isset($object->show_publish_date) ? $object->show_publish_date : "";
		$object->show_item_navigation = isset($object->show_item_navigation) ? $object->show_item_navigation : "";
		$object->show_print_icons = isset($object->show_print_icons) ? $object->show_print_icons : "";
		$object->show_icons = isset($object->show_icons) ? $object->show_icons : "";
		$object->show_vote = isset($object->show_vote) ? $object->show_vote : "";
		$object->show_hits = isset($object->show_hits) ? $object->show_hits : "";
		$object->show_noauth = isset($object->show_noauth) ? $object->show_noauth : "";
		$object->alternative_readmore = isset($object->alternative_readmore) ? $object->alternative_readmore : "";
		$object->article_layout = isset($object->article_layout) ? $object->article_layout : "";
		$object->show_publishing_options = isset($object->show_publishing_options) ? $object->show_publishing_options : "";
		$object->show_article_options = isset($object->show_article_options) ? $object->show_article_options : "";
		$object->show_urls_images_backend = isset($object->show_urls_images_backend) ? $object->show_urls_images_backend : "";
		$object->show_urls_images_frontend = isset($object->show_urls_images_frontend) ? $object->show_urls_images_frontend : "";

		// Component params
		$object->list_show_hits = isset($object->show_hits) ? $object->show_hits : "";
		$object->list_show_author = isset($object->show_author) ? $object->show_author : "";
		$object->show_readmore = isset($object->show_readmore) ? $object->show_readmore : "";

		unset($object->show_section);
		unset($object->link_section);
		unset($object->show_vote);
		unset($object->show_pdf_icon);
		unset($object->language);
		unset($object->keyref);
		unset($object->readmore);
		unset($object->urls_position);
		unset($object->feed_show_readmore);
	}
}
