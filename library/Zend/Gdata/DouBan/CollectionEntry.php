<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'DouBan/Extension/Rating.php';
require_once 'DouBan/Extension/Tag.php';
require_once 'DouBan/Extension/Status.php';
require_once 'DouBan/Subject.php';

class Zend_Gdata_DouBan_CollectionEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_CollectionEntry';
	
	protected $_rating = null;
	protected $_subject = null;
	protected $_status = null;
	protected $_tag = array();


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
		if ($this->_rating != null) {
			$element->appendChild($this->_rating->getDOM($element->ownerDocument));
		}
		if ($this->_subject != null) {
			$element->appendChild($this->_subject->getDOM($element->ownerDocument));
		}
		if ($this->_status != null) {
			$element->appendChild($this->_status->getDOM($element->ownerDocument));
		}
		if ($this->_tag != null) {
            		foreach ($this->_tag as $tag) {
                		$element->appendChild($tag->getDOM($element->ownerDocument));
            		}
		}

		return $element;
	}
	protected function takeChildFromDOM($child)
	{
		$absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
		switch ($absoluteNodeName) {
			case $this->lookupNamespace('db') . ':' . 'subject':
				$attribute = new Zend_Gdata_DouBan_Subject();
				$attribute->transferFromDOM($child);
				$this->_subject = $attribute;
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
			case $this->lookupNamespace('db') . ':' . 'status':
				$status = new Zend_Gdata_DouBan_Extension_Status();
				$status->transferFromDOM($child);
				$this->_status = $status;
				break;
			default:
				parent::takeChildFromDOM($child);
				break;
		}
	}

	public function setSubject($subject = null)
	{
		$this->_subject = $subject;
	}

	public function getSubject()
	{
		return $this->_subject;
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

	public function setStatus($status = null)
	{
		$this->_status = $status;
	}

	public function getStatus()
	{
		return $this->_status;
	}
	
}
?>
