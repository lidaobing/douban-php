<?php
require_once 'Zend/Gdata/Extension.php';
class Zend_Gdata_DouBan_Extension_Attribute extends Zend_Gdata_Extension
{

    protected $_rootElement = 'attribute';
    protected $_rootNamespace = 'db';

    protected $_name = null;
    protected $_index = null;
    protected $_lang = null;

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
	    if ($this->_index !== null) {
		    $element->setAttribute('index', $this->_index);
	    }
	    if ($this->_lang !== null) {
		    $element->setAttribute('lang', $this->_lang);
	    }
	    return $element;
    }  
    
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'name':
            $this->_name = $attribute->nodeValue;
	    break;
	case 'index':
            $this->_index = $attribute->nodeValue;
	    break;
        case 'lang':
	    $this->_lang = $attribute->nodeValue;
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

    public function getIndex()
    {
	return $this->_index;
    }
   
    public function setIndex($index)
    {
	$this->_index = $index;
    }
 
    public function getLang()
    {
	return $this->_lang;
    }
    
    public function setLang($lang)
    {
	$this->_lang = $lang;
    }

    
}
?>
