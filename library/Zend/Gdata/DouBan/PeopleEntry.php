<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'Zend/Gdata/DouBan/Extension/Location.php';
require_once 'Zend/Gdata/DouBan/Extension/Uid.php';

class Zend_Gdata_DouBan_PeopleEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_PeopleEntry';
	
	protected $_location = null;
	protected $_uid = null;

	public function __construct($element=null)
	{
		
		foreach (Zend_Gdata_DouBan::$namespaces as $nsPrefix => $nsUri) {
			$this->registerNamespace($nsPrefix, $nsUri);
		}
		parent::__construct($element);
	}
	
	public function getDOM($doc = null)
	{
		$element = parent::getDOM($doc);
		if ($this->_location != null) {
			$element->appendChild($this->_location->getDOM($element->ownerDocument));
		}
		if ($this->_uid != null) {
			$element->appendChild($this->_uid->getDOM($element->ownerDocument));
		}
		return $element;
	}

	protected function takeChildFromDOM($child)
	{
		$absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
		switch ($absoluteNodeName) {
			case $this->lookupNamespace('db') . ':' . 'location':
				$location = new Zend_Gdata_DouBan_Extension_Location();
				$location->transferFromDOM($child);
				$this->_location = $location;
				break;
			case $this->lookupNamespace('db') . ':' . 'uid':
				$uid = new Zend_Gdata_DouBan_Extension_Uid();
				$uid->transferFromDOM($child);
				$this->_uid = $uid;
				break;
			default:
				parent::takeChildFromDOM($child);
				break;
		}
	}

	public function setLocation($location = null)
	{
		$this->_location = $location;
	}

	public function getLocation()
	{
		return $this->_location;
	}

	public function setUid($uid = null)
	{
		$this->_uid = $uid;
	}

	public function getUid()
	{
		return $this->_uid;
	}
}
?>
