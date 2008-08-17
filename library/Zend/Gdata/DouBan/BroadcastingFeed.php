<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Feed.php';

class Zend_Gdata_DouBan_BroadcastingFeed extends Zend_Gdata_App_Feed
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_BroadcastingEntry';
	protected $_feedClassName = 'Zend_Gdata_DouBan_BroadcastingFeed';
	public function __construct($element)
	{
		parent::__construct($element);
	}
}
?>
