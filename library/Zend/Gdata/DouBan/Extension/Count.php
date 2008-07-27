<?php
require_once 'Zend/Gdata/Extension.php';
class Zend_Gdata_DouBan_Extension_Count extends Zend_Gdata_Extension
{

    protected $_rootElement = 'count';
    protected $_rootNamespace = 'db';

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
	    if ($this->_count !== null) {
		    $element->setAttribute('count', $this->_name);
	    }
	    return $element;
    }  
    
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
	case 'count':
            $this->_count = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
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
