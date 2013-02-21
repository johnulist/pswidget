<?php

/**
 * PSWidget plugin for smarty
 * 
 * @package    TwoFace
 * @author     Golovkin Vladimir <r00t@skillz.ru> http://www.skillz.ru
 * @copyright  SurSoft (C) 2008
 * @version    $Id: function.pswidget.php,v 1.1 2013/02/15 18:19:49 jack Exp $
 */
  
/**
* Block entry point
* 
* @param array
*     action                   widget action
*     cache                    seconds, ttl
*     ...
*/

function smarty_function_pswidget($params, &$smarty) {    
    
    if (!isset($params['action'])) {
        throw new PrestaShopModuleException('Bad action');
        return false;
    }
    
    $action = $params['action'];
    
    $ttl = @$params['cache'];
    unset($params['cache']);
    
    $cache_id = 'pswidget-' . md5(serialize($params));
    $result = false;     
    $cached = false;    
    
    $mtime = microtime(1);
    
    /*
    // Autoloaded
    if (!class_exists('PSWidgetWidget', false)) {
        require _PS_OVERRIDE_DIR_ . 'classes/PSWidgetWidget.php';
    }
    */
    
    $cacher = Cache::getInstance();
    
    if (!$ttl || !$cacher->exists($cache_id)) {
          unset($params['action']);
          try { 
            $result = PSWidgetWidget::render($action, $params);
            if ($ttl) $cacher->set($cache_id, $result, $ttl);
          }
            catch (exception $e) {
            $result = '[pswidget::'.$action.'] ' . $e->getMessage();
          }
          
    }
    else {
        $result = $cacher->get($cache_id);
        $cached = true;        
    }
    
    // Tools::dprint(array('PSwidget %s %s -- %.5f ttl %d', $action, $cached?'cached':'', microtime(1)-$mtime, $ttl), 42);
    
    return $result;
}
