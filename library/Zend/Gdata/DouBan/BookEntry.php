<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Feed.php';
require_once 'DouBan/SubjectEntry.php';
class Zend_Gdata_DouBan_BookEntry extends Zend_Gdata_DouBan_SubjectEntry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_BookEntry';
	public function __construct($element)
	{
		parent::__construct($element);
	}
}
?>
