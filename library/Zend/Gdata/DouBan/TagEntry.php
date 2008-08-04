<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'DouBan/Extension/Count.php';

class Zend_Gdata_DouBan_TagEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_TagEntry';
	
	protected $_count = null;

	public function __construct($element = NULL)
	{
		
		foreach (Zend_Gdata_DouBan::$namespaces as $nsPrefix => $nsUri) {
			$this->registerNamespace($nsPrefix, $nsUri);
		}
		parent::__construct($element);
	}
	
	public function getDOM($doc = null)
	{
		$element = parent::getDOM($doc);
		if ($this->_count != null) {
			$element->appendChild($this->_count->getDOM($element->ownerDocument));
		}
		
		return $element;
	}
	protected function takeChildFromDOM($child)
	{
		$absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
		switch ($absoluteNodeName) {
			case $this->lookupNamespace('db') . ':' . 'count':
				$count = new Zend_Gdata_DouBan_Extension_Count();
				$count->transferFromDOM($child);
				$this->_count = $count;
				break;
			default:
				parent::takeChildFromDOM($child);
				break;
		}
	}

	public function setCount($count = null)
	{
		$this->_count = $count;
	}

	public function getCount()
	{
		return $this->_count;
	}
}
?>
