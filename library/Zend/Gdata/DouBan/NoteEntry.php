<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'Zend/Gdata/DouBan/Extension/Attribute.php';

class Zend_Gdata_DouBan_NoteEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_NoteEntry';
	
	protected $_attribute = array();

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
		if ($this->_attribute != null) {
            		foreach ($this->_attribute as $attribute) {
                		$element->appendChild($attribute->getDOM($element->ownerDocument));
            		}
        	}

		return $element;
	}

	protected function takeChildFromDOM($child)
	{
		$absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
		switch ($absoluteNodeName) {
			case $this->lookupNamespace('db') . ':' . 'attribute':
				$attribute = new Zend_Gdata_DouBan_Extension_Attribute();
				$attribute->transferFromDOM($child);
				$this->_attribute[] = $attribute;
				break;
			default:
				parent::takeChildFromDOM($child);
				break;
		}
	}

	public function setAttribute($attribute = null)
	{
		$this->_attribute[] = $attribute;
	}

	public function getAttribute()
	{
		return $this->_attribute;
	}
	
}
?>
