<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Feed.php';

class Zend_Gdata_DouBan_CollectionFeed extends Zend_Gdata_App_Feed
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_CollectionEntry';
	protected $_feedClassName = 'Zend_Gdata_DouBan_CollectionFeed';
	
	public function __construct($element)
	{
		parent::__construct($element);
	}
}
?>
