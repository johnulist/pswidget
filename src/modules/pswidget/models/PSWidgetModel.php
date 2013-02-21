<?php

/**
 * @package    PSWidget
 * @author     Golovkin Vladimir <rustyj4ck@gmail.com> http://www.skillz.ru
 * @copyright  SurSoft (C) 2008
 * @version    $Id$
 */

class PSWidgetModel extends ObjectModel {
	
	/** @var int pk */                          public $id_widget;	
    /** @var string */                          public $title;
    /** @var string */                          public $name;
    /** @var string */                          public $text;         
    /** @var bool   */                          public $active;       
	/** @var bool append some borders  */       public $raw;          
    /** @var bool with smarty pass  */          public $plain;
    
	
	public static $definition = array(
  		'table' 	=> 'pswidget',
        
  		'primary' 	=> 'id_widget',
        
  		'multilang' => false,
 		
        'fields' => array(
   			// 'id_widget' => array('type' => ObjectModel::TYPE_INT),

            'plain'  =>     array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'active' =>     array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),            
            'raw'    =>     array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        
            // no lang?
            'class'  =>     array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'size' => 64),
            'name'   =>     array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'size' => 127),
            'text'   =>     array('type' => self::TYPE_HTML,   'lang' => false, 'validate' => 'isString'),
            'title'  =>     array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'size' => 255),
  		),
	);
	

    function getByName($name) {   
                $sql = new DbQuery();
                $sql->from($this->def['table'], 'a');
                $sql->where('a.name = "' .  $name . '"');

                $return = array();
                
                if ($row = ObjectModel::$db->getRow($sql))  {
                    foreach ($row as $key => $value)
                        if (array_key_exists($key, $this)) {
                            $return[$key] = $this->{$key} = $value;
                        }
                } 
                
                return $return;
    }
}