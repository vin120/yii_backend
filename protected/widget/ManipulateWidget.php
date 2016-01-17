<?php 

class ManipulateWidget extends CWidget
{
	public $ControllerName;
	public $MethodName;
	public $id;
	public $canedit;
	public $candelete;
	public function run()
	{
        $this->render('manipulate_view',array('ControllerName'=>$this->ControllerName,'MethodName'=>$this->MethodName,'id'=>$this->id,'canedit'=>$this->canedit,'candelete'=>$this->candelete));  
    }
}