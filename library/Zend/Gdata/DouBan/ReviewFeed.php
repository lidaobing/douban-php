<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Feed.php';

class Zend_Gdata_DouBan_ReviewFeed extends Zend_Gdata_App_Feed
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_ReviewEntry';
	protected $_feedClassName = 'Zend_Gdata_DouBan_ReviewFeed';
	
	public function __construct($element)
	{
		parent::__construct($element);
	}
}
?>
