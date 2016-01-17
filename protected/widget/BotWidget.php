<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of breadcrumbWidget
 *
 * @author Rock.Lei
 */
class BotWidget extends CWidget
{
    public $ControllerName;
    public $MethodName;
    public $canadd;
    public $candelete;
    public function run()
    {
        $this->render('bot_view',array('ControllerName'=>$this->ControllerName,'MethodName'=>$this->MethodName,'canadd'=>$this->canadd,'candelete'=>$this->candelete));  
    }
}

?>
