<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Feed.php';

class Zend_Gdata_DouBan_TagFeed extends Zend_Gdata_App_Feed
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_TagEntry';
	protected $_feedClassName = 'Zend_Gdata_DouBan_TagFeed';
	public function __construct($element)
	{
		parent::__construct($element);
	}
}
?>
