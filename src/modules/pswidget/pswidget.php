<?php

/**
 * @package    PSWidget
 * @author     Golovkin Vladimir <rustyj4ck@gmail.com> http://www.skillz.ru
 * @copyright  SurSoft (C) 2008
 * @version    $Id$
 */


require_once _PS_MODULE_DIR_ . 'pswidget/models/PSWidgetModel.php';

class PSWidget extends Module {
	
	public function __construct() {
		
		$this->name 		= 'pswidget';
		$this->tab 		    = 'front_office_features';
		$this->version 		= 1.0;
		$this->author 		= 'Golovkin Vladimir';
		$this->displayName 	= $this->l('PSWidget');
		$this->description 	= $this->l('Allows user to use smarty {pswidget}');
		
		parent :: __construct();
		
	}
	
	public function install() {
        
        $tabClass = 'AdminPSWidget';
        $idTab = Tab::getIdFromClassName($tabClass);

//        Tools::dprint(__METHOD__ . '' .$idTab);
        
       // if (!$idTab) {
            $tab = new Tab();
            $tab->name = 'PSWidget';
            $tab->module = $this->name;
            
            // Controller
            $tab->class_name = 'AdminPSWidget';
            $tab->id_parent = 16; // Root tab
            $tab->save();
       // }   
       
		return parent :: install()
			&& $this->resetDb()
			&& $this->registerHook('leftColumn')            
			;
	}
    
    public function uninstall(){
                return parent::uninstall()
                        && $this->uninstallModuleTab();
    }
    
    private function uninstallModuleTab($tabClass = 'AdminPSWidget')
    {
            $idTab = Tab::getIdFromClassName($tabClass);
            if($idTab != 0)
            {
                    $tab = new Tab($idTab);
                    $tab->delete();
                    @unlink( _PS_IMG_DIR."t/".$tabClass.".png");
            }
            return true;
    }    
    
	
	private function resetDb() {
		
		$prefix = _DB_PREFIX_;
		$engine = _MYSQL_ENGINE_;
		
		$statements = array();
		
		$statements[] 	= "DROP TABLE IF EXISTS `${prefix}pswidget`";
		$statements[] 	= 

sprintf(<<<'SQL'
        CREATE TABLE `%spswidget` (
        
          `id_widget` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255),
          `text` text,
          `title` varchar(255),
          `class` varchar(255),
          `raw` tinyint(1) unsigned NOT NULL DEFAULT '0',
          `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
          `plain` tinyint(1) NOT NULL DEFAULT '0',                        

          PRIMARY KEY (`id_widget`)
          ) ENGINE=%s;
SQL
, $prefix
, $engine
);


		foreach ($statements as $statement) {
			if (!Db::getInstance()->Execute($statement)) {
				return false;
			}
		}
		
		return true;
						
	}
	
	public function hookDisplayLeftColumn($params) {
		return $this->display(__FILE__, 'left-column.tpl');
	}
    
    
	
}