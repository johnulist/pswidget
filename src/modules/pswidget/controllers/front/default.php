<?php

/**
 * @package    PSWidget
 * @author     Golovkin Vladimir <rustyj4ck@gmail.com> http://www.skillz.ru
 * @copyright  SurSoft (C) 2008
 * @version    $Id$
 */


class PSWidgetDefaultModuleFrontController extends ModuleFrontController {
	
	public function initContent() {
		
		parent :: initContent();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if ($opinion = Tools :: getValue('pswidget', false)) {
				
				
				$opinionObj = new PSWidgetModel();
				//$opinionObj->id_customer = $this->context->customer->id;
				$opinionObj->active = false;
				$opinionObj->opinion = $opinion;
				$opinionObj->add();
				
				$link = new Link();
				Tools :: redirect($link->getModuleLink('pswidget', 'default'));
				
			}
			
		}
		
		$opinions = Opinion :: findAll();
		$this->context->smarty->assign('opinions', $opinions);
		
		$this->setTemplate('form.tpl');
		
	}
	
}