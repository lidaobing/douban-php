<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/DouBan/SubjectEntry.php';
class Zend_Gdata_DouBan_Subject extends Zend_Gdata_DouBan_SubjectEntry
{
	#protected $_entryClassName = 'Zend_Gdata_DouBan_Subject';
	protected $_rootElement =  'subject';
	protected $_rootNamespace = 'db';
	public function __construct($element = null)
	{
		parent::__construct($element);
	}
}
?>
