<?php 

class navbarWidget extends CWidget
{
    public $disable;
    public function run()
    {
        $admin_id = Yii::app()->user->id;
        $sql = "SELECT b.permission_menu FROM vcos_admin a , vcos_admin_role b WHERE b.role_id = a.role_id AND a.admin_id = {$admin_id}";
        $permission = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($permission['permission_menu'] != 0)
        {
            $permission = json_decode($permission['permission_menu'] , true);
            $auth = array();
            foreach($permission as $key => $row)
            {
                $auth[] = $key;
                foreach($row as $k=>$val)
                {
                    if(is_array($val))
                    {
                        $auth[] = $k;
                        foreach($val as $item)
                        {
                            $auth[] = $item;
                        }
                    }
                    else
                    {
                        $auth[] = $val;
                    }
                }
            }
        }
        else
        {
            $auth[0] = $permission['permission_menu'];
        }
        $this->render('navbar_view',array('auth'=>$auth,'disable'=>$this->disable));
    }
}