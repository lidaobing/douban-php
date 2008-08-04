<?php
require_once 'Zend/Gdata/Extension.php';
class Zend_Gdata_DouBan_Extension_Tag extends Zend_Gdata_Extension
{

    protected $_rootElement = 'tag';
    protected $_rootNamespace = 'db';

    protected $_name = null;
    protected $_count = null;

    public function __construct($text = null)
    {
        foreach (Zend_Gdata_DouBan::$namespaces as $nsPrefix => $nsUri) {
            $this->registerNamespace($nsPrefix, $nsUri);
        }
        parent::__construct();
        $this->_text = $text;
    }
    
    public function getDOM($doc = null)
    {
	    $element = parent::getDOM($doc);
	    if ($this->_name !== null) {
		    $element->setAttribute('name', $this->_name);
	    }
	    if ($this->_count !== null) {
		    $element->setAttribute('count', $this->_count);
	    }
	    return $element;
    }  
    
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'name':
            $this->_name = $attribute->nodeValue;
	    break;
	case 'count':
            $this->_count = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    public function getName()
    {
	return $this->_name;
    }

    public function setName($name)
    {
	$this->_name = $name;
    }

    public function getCount()
    {
	return $this->_count;
    }
   
    public function setCount($count)
    {
	$this->_count = $count;
    }
}
?>
