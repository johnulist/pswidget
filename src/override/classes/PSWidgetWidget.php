<?php

/**
* @package TwoFace
* @version $Id: PSWidget.php,v 1.3 2013/02/20 19:52:48 jack Exp $
* @copyright (c) 2007 4style
* @author surgeon <r00t@skillz.ru>
*/  
  
class PSWidgetWidget
{
    protected $_context;
    
    protected $_data;
    protected $_template; 
    protected $_name;
    
    function __construct($data) {
        $this->_data = $data;
        $this->_name = get_class($this);
        $this->_name = strtolower(str_replace(__CLASS__, '', $this->_name));
        $this->_template = isset($data['template']) ? $data['template'] : $this->_name; 
        $this->_name = str_replace('/', '_', $this->_name);
        $this->getContext();
        $this->init();
    }                 
    
    /*abstract*/ function init() {;}    
    
    function getContext() {
        return isset($this->_context) ? $this->_context : ($this->_context = Context::getContext());
    }
    
    function getTemplate() {
        return $this->_template;
    }
    
    function setTemplate($t) {
        $this->_template = $t;
        return $this;
    }    
        
    function setData($d, $value = null) {
        if (!isset($value)) {
            $this->_data = is_array($d) ? $d : array();
        }
        else {
            $this->_data[$d] = $value;
        }
    }
    
    function getData($k = null) {
        return !$k 
            ? $this->_data 
            : (isset($this->_data[$k]) ? $this->_data[$k] : null)
            ;
    }
    
    function run() {  
        
        $this->_run(); 
        
        $template = _PS_THEME_DIR_ . 'pswidgets/' . $this->getTemplate() . '.tpl';
        //Tools::dprint(array("[BLOCK] %s, %s.tpl", $this->_name, $this->getTemplate()), 30);
        
        /** @var Smarty */
        $s = $this->getContext()->smarty;
        
        $s->assign('pswidget', $this->getData());
        
        return $s->fetch(
            $template
        );
    }
    
    /** abstract */ protected function _run() {}
    
    
    /**
    * Usage PSWidget::render($action, $params)
    * 
    * @param mixed $action
    * @param mixed $params
    * @return PSWidget
    */
    static function render($action, $params) {
        
        $action = $action ? $action : 'block';
        $className = ucfirst($action) . 'PSWidget';
        
        // index/action => IndexAction
        $className = preg_replace_callback(
                    '@\/[a-z]@',
                    create_function(
                        '$matches',
                        'return strtoupper(substr($matches[0],1));'
                    ),
                    $className
                );
        
        $classFile = _PS_OVERRIDE_DIR_ . "/pswidgets/" . $action . '.php';
        if (!class_exists($className, false) && file_exists($classFile)) {
            require $classFile;
        }
        
        if (!class_exists($className, false)) {
            return "Widget $action class not found : $className";
        }
        
        if (!isset($params['template'])) {
            $params['template'] = $action;
        }
        
        $widget = new $className($params);
        return $widget->run();
    }

    
}