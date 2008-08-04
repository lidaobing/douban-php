<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'Zend/Gdata/DouBan/Extension/Attribute.php';
require_once 'Zend/Gdata/DouBan/Extension/Rating.php';
require_once 'Zend/Gdata/DouBan/Extension/Tag.php';

class Zend_Gdata_DouBan_SubjectEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_SubjectEntry';
	
	protected $_attribute = array();
	protected $_rating = null;
	protected $_tag = array();

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
		if ($this->_attribute != null) {
            		foreach ($this->_attribute as $attribute) {
                		$element->appendChild($attribute->getDOM($element->ownerDocument));
            		}
        	}

		if ($this->_rating != null) {
			$element->appendChild($this->_rating->getDOM($element->ownerDocument));
		}
		
		if ($this->_tag != null) {
			foreach ($this->_tag as $tag) {
				$element->appendChild($this->_tag->getDOM($element->ownerDocument));
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
			case $this->lookupNamespace('gd') . ':' . 'rating':
				$rating = new Zend_Gdata_DouBan_Extension_Rating();
				$rating->transferFromDOM($child);
				$this->_rating = $rating;
				break;
			case $this->lookupNamespace('db') . ':' . 'tag':
				$tag = new Zend_Gdata_DouBan_Extension_Tag();
				$tag->transferFromDOM($child);
				$this->_tag[] = $tag;
				break;
			default:
				parent::takeChildFromDOM($child);
				break;
		}
	}

	public function setAttribute($attribute = null)
	{
		$this->_attribute = $attribute;
	}

	public function getAttribute()
	{
		return $this->_attribute;
	}
	
	public function setRating($rating = null)
	{
		$this->_rating = $rating;
	}

	public function getRating()
	{
		return $this->_rating;
	}
	
	public function setTag($tag = null)
	{
		$this->_tag = $tag;
	}

	public function getTag()
	{
		return $this->_tag;
	}
}
?>
