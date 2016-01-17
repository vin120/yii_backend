<?php 

class menuWidget extends CWidget
{
    public $menu_type;

    public function run()
    {
        $admin_id = Yii::app()->user->id;
        $sql = "SELECT b.permission_menu FROM vcos_admin a ,vcos_admin_role b WHERE b.role_id = a.role_id AND a.admin_id = {$admin_id} ";
        $permission = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($permission['permission_menu'] != '0')
        {
            $permission = json_decode($permission['permission_menu'],true);
            $auth = array();
            foreach($permission as $key=>$row)
            {
                $auth[] = $key;
                foreach($row as $k=>$val)
                {
                    if(is_array($val))
                    {
                        $auth[]=$k;
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
        $sql_value = "SELECT * FROM vcos_permission_menux WHERE permission_state = '1' AND is_show = '1' ORDER BY menu_id";
        $temp_array = Yii::app()->m_db->createCommand($sql_value)->queryAll();

        foreach($temp_array as $val)
        {
            if($val['parent_menu_id'] == 0) //找到所有的顶级父类
            {
                $item1[] = $val; //parentid=0的数组
            }
        }
        foreach($item1 as $value)   //循环每个父类
        {
            foreach($temp_array as $item2)
            {
                if($item2['parent_menu_id'] == $value['menu_id']) //将符合条件的子类装到对应的父类里
                {
                    $value['child'][] = $item2;
                }
            }
            $permissions[] = $value;    //将每个父类都装好
        }

        foreach($permissions as $key=>$row)
        {
            foreach($row['child'] as $k => $rows)
            {
                foreach($temp_array as $rowss)
                {
                    if($rowss['parent_menu_id'] == $rows['menu_id'])
                    {
                        $rows['child'][] = $rowss;
                    }
                }
                $permissions[$key]['child'][$k] = $rows;
            }
        }
        $this->render('menu_view',array('menu_type'=>$this->menu_type,'auth'=>$auth,'permissions'=>$permissions));
    }
}