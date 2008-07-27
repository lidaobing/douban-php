<?php
require_once 'Zend/Gdata/Extension.php';
class Zend_Gdata_DouBan_Extension_Status extends Zend_Gdata_Extension
{

    protected $_rootElement = 'status';
    protected $_rootNamespace = 'db';


    public function __construct($text = null)
    {
        foreach (Zend_Gdata_DouBan::$namespaces as $nsPrefix => $nsUri) {
            $this->registerNamespace($nsPrefix, $nsUri);
        }
        parent::__construct();
        $this->_text = $text;
    }
    
}
?>
