<?php
require_once 'Zend/Gdata/Extension/Rating.php';
class Zend_Gdata_DouBan_Extension_Rating extends Zend_Gdata_Extension_Rating
{

    protected $_rootElement = 'rating';
    protected $_rootNamespace = 'db';

    protected $_value = null;

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
		    $element->setAttribute('value', $this->_value);
	    }
	    return $element;
    }  
    
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'value':
            $this->_value = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    public function getValue()
    {
	return $this->_value;
    }
    
    public function setValue($lang)
    {
	$this->_lang = $value;
    }

    
}
?>
