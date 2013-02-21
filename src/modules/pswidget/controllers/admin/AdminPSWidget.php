<?php

/**
 * @package    PSWidget
 * @author     Golovkin Vladimir <rustyj4ck@gmail.com> http://www.skillz.ru
 * @copyright  SurSoft (C) 2008
 * @version    $Id$
 */


class AdminPSWidgetController extends ModuleAdminController {
	
	public function __construct() {
		
	 	$this->table 		= 'pswidget';
        
        // ModelClass
	 	$this->className 	= 'PSWidgetModel';
        
        // PK
        $this->identifier = 'id_widget';
	 	
		parent::__construct();
		
        // renderList
		$this->fields_list = array(
            
            'name' =>
            array(
                'type' => 'text',
                'label' => $this->l('Name:'),
                'name' => 'name',
                'size' => 40,
                'lang' => false,
                'title'     => $this->module->l('Name')                
            ),              
            
            'title' =>
            array(
                'type' => 'text',
                'label' => $this->l('Title:'),
                'name' => 'title',
                'size' => 40,
                'lang' => false,
                'title'     => $this->module->l('Title')                
            ),                

            'active' => array(
                'type'      => 'bool',
                'title'     => $this->module->l('active'),
                'active'    => 'status',
                'width'     => 40,
                'align'     => 'center'
            ),
            
            'raw' => array(
                'type'      => 'bool',
                'title'     => $this->module->l('raw'),
                'active'    => 'status',
                'width'     => 40,
                'align'     => 'center'
            ),   
            
            'plain' => array(
                'type'      => 'bool',
                'title'     => $this->module->l('plain'),
              //  'active'    => 'status',
                'width'     => 40,
                'align'     => 'center',
                'callback' => 'printPlainIcon'
            ),                       
            
         
		);
        
		
		$this->actions = array('edit', 'delete');
		
	}
    
    
    public static function printPlainIcon($value, $item)
    {
        return '<a href="index.php?tab=AdminPSWidget&id_widget='
            .(int)$item['id_widget'].'&changePlainVal&token='.Tools::getAdminTokenLite('AdminPSWidget').'">
                '.($value ? '<img src="../img/admin/enabled.gif" />' : '<img src="../img/admin/disabled.gif" />').
            '</a>';
    }
    
    /**
     * Toggle newsletter optin flag
     */
    public function processChangePlainVal()
    {
        
        var_dump($this->id_object);
        die;
        
        $item = new PSWidgetModel($this->id_object);
        if (!Validate::isLoadedObject($item))
            $this->errors[] = Tools::displayError('An error occurred while updating the item.');
        $item->plain = $item->plain ? 0 : 1;
        if (!$item->update())
            $this->errors[] = Tools::displayError('An error occurred while updating the item.');
        Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
    }    
	
    /*
	public function getCustomerName($echo, $row) {
		$id_customer = $row['id_customer'];
		$customer = new Customer($id_customer);
		return $customer->firstname . ' ' . $customer->lastname;
	}
    */
	
    public function renderList()
    {
        
        /*
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('add');
        $this->addRowAction('view');
        */
  
        return parent::renderList();
    }    
	
	function renderForm() {
        
        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('PSWidget'),
                //'image' => '../img/admin/tab-pswidget.gif'
            ),
            'input' => array(
                
                array(
                    'type' => 'text',
                    'label' => $this->l('Name:'),
                    'name' => 'name',
                    'lang' => false,
                    'size' => 48,
                    'required' => false,
                    //'class' => 'copy2friendlyUrl',
                    //'hint' => $this->l('Invalid characters:').' <>;=#{}',
                ),
                
                array(
                    'type' => 'text',
                    'label' => $this->l('Title:'),
                    'name' => 'title',
                    'lang' => false,
                    'size' => 48,                    
                    //'hint' => $this->l('Invalid characters:').' <>;=#{}',
                ),                
                
                
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Description:'),
                    'name' => 'text',
                    'lang' => false,
                    'autoload_rte' => true,
                    'rows' => 17,
                    'cols' => 100,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}'
                ),
                
                array(
                    'type' => 'radio',
                    'label' => $this->l('Active:'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'pswidget-b-1',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'pswidget-b-1',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    )
                ),    
                
                array(
                    'type' => 'radio',
                    'label' => $this->l('Raw:'),
                    'name' => 'raw',
                    'required' => false,
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'pswidget-b-2',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'pswidget-b-2',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    )
                ),      
                
                array(
                    'type' => 'radio',
                    'label' => $this->l('Plain:'),
                    'name' => 'plain',
                    'required' => false,
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'pswidget-b-3',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'pswidget-b-3',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    )
                ),                                         
                
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );        
        
        return parent::renderForm();
    }
    
}