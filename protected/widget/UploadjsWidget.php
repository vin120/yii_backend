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
class UploadjsWidget extends CWidget
{
    public $form_id;
    public function run()
    {
        $this->render('uploadjs_view',array('form_id'=>$this->form_id));  
    }
}

?>
