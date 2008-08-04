<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'DouBan/Extension/Location.php';

class Zend_Gdata_DouBan_PeopleEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_PeopleEntry';
	
	protected $_location = null;

	public function __construct($element)
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
}
?>
