<?php

/**
* @package TwoFace
* @version $Id: PSWidget.php,v 1.1 2013/02/15 18:00:22 jack Exp $
* @copyright (c) 2007 4style
* @author surgeon <r00t@skillz.ru>
*/  

class IndexTestPSWidget extends PSWidgetWidget {
  
  function _run() {
      $this->setData('test', __METHOD__ . '::hello');      
  }
  
}

