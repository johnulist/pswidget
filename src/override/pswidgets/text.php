<?php

/**
* @package TwoFace
* @version $Id: PSWidget.php,v 1.1 2013/02/15 18:00:22 jack Exp $
* @copyright (c) 2007 4style
* @author surgeon <r00t@skillz.ru>
*/  

class TextPSWidget extends PSWidgetWidget {
  
  
  function _run() {       
      
      $id = $this->getData('id');
      
      /** @var Module */      
      $m = Module::getInstanceByName('pswidget');
      
      $model = new PSWidgetModel();
      
      $this->setData(
        $model->getByName($id)
      );
      
      if ($this->getData('active'))
      if (!$this->getData('plain') && ($text = $this->getData('text')) && !empty($text)) {
            $text = 'string: ' . $text;  
            $text = $this->_context->smarty->fetch($text);
            $this->setData('text', $text);
      }                                   
      
      //Tools::dprint(__METHOD__ . ' ok');
  }
  
}