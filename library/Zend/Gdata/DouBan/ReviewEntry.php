<?php
require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Entry.php';
require_once 'Zend/Gdata/DouBan/Extension/Rating.php';
require_once 'Zend/Gdata/DouBan/Subject.php';

class Zend_Gdata_DouBan_ReviewEntry extends Zend_Gdata_App_Entry
{
	protected $_entryClassName = 'Zend_Gdata_DouBan_ReviewEntry';
	
	protected $_rating = null;
	protected $_subject = null;

	public function __construct($element = null)
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
		
		return $element;
	}
	protected function takeChildFromDOM($child)
	{
		$absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
		switch ($absoluteNodeName) {
			case $this->lookupNamespace('db') . ':' . 'subject':
				$subject = new Zend_Gdata_DouBan_Subject();
				$subject->transferFromDOM($child);
				$this->_subject = $subject;
				break;
			case $this->lookupNamespace('gd') . ':' . 'rating':
				$rating = new Zend_Gdata_DouBan_Extension_Rating();
				$rating->transferFromDOM($child);
				$this->_rating = $rating;
				break;
			default:
				parent::takeChildFromDOM($child);
				break;
		}
	}

	public function setSubject($subject = null)
	{
		$this->_subject = $subject;
		return $this;
	}

	public function getSubject()
	{
		return $this->_subject;
	}
	
	public function setRating($rating = null)
	{
		$this->_rating = $rating;
		return $this;
	}

	public function getRating()
	{
		return $this->_rating;
	}
	
}
?>
