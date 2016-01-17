<?php

class AuthController extends Controller
{
    public function actionAdmin()
    {
        $this->setauth();//检查有无权限
//         if($_POST){
//             $ids=implode('\',\'', $_POST['ids']);
//             $count = VcosAdmin::model()->deleteAll("admin_id in('$ids')");
//             if ($count>0){
//                     Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Auth/admin")); 
//             }else{
//                     Helper::show_message(yii::t('vcos', '删除失败。')); 
//             }
//         }
        if(isset($_GET['id']))
        {
            $did=$_GET['id'];
            $count=VcosAdmin::model()->deleteByPk($did);
            if ($count>0)
            {
            	Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Auth/admin")); 
            }
            else
            {
                Helper::show_message(yii::t('vcos', '删除失败。')); 
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_admin a LEFT JOIN vcos_admin_role b ON b.role_id = a.role_id WHERE admin_id > 1 ORDER BY admin_id DESC";
        $count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_admin a LEFT JOIN vcos_admin_role b ON b.role_id = a.role_id WHERE admin_id > 1 ORDER BY admin_id DESC LIMIT {$criteria->offset}, 10";
        $admin = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('admin',array('pages'=>$pager,'auth'=>$this->auth,'admin'=>$admin));
    }

    public function actionAdmin_add()
    {
        $this->setauth();//检查有无权限
        $admin = new VcosAdmin();
        if($_POST){
            if($_POST['real_name']=='超级管理员'){
                die(Helper::show_message(yii::t('vcos', '你不能命名为超级管理员！'), Yii::app()->createUrl("Auth/admin")));
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['real_name']!=''&&$_POST['password']!=''&&$_POST['email']!=''){
                $admin->admin_name = $_POST['name'];
                $admin->admin_real_name = $_POST['real_name'];
                $admin->admin_password = md5($_POST['password']);
                $admin->role_id = $_POST['role'];
                $admin->last_login_ip = Helper::getIp();
                $admin->last_login_time = date('Y-m-d H:i:s',time());
                $admin->admin_email = $_POST['email'];
                $admin->admin_state = $state;
                if($admin->save()>0){
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Auth/admin"));  
                }else{
                    Helper::show_message(yii::t('vcos', '添加失败。'));   
                }
            }else{
                    Helper::show_message(yii::t('vcos', '添加失败。'));   
            }
        }
        $sql = "SELECT * FROM vcos_admin_role WHERE role_id > 1 AND role_state = 1 ORDER BY role_id";
        $role = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('admin_add',array('role'=>$role));
    }
    
    public function actionAdmin_edit()
    {
        $this->setauth();//检查有无权限
        $edit_id = (isset($_POST['edit_id']))?$_POST['edit_id']:FALSE;
        $edit_id2 = (isset($_POST['edit_id2']))?$_POST['edit_id2']:FALSE;
        $id=$edit_id?$edit_id:$edit_id2;
        $admin= VcosAdmin::model()->findByPk($id);
        $sql = "SELECT * FROM vcos_admin_role WHERE role_id > 1 AND role_state = 1 ORDER BY role_id";
        $role = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($_POST){
            if(!$edit_id){
                if($_POST['real_name']=='超级管理员'){
                    die(Helper::show_message(yii::t('vcos', '你不能命名为超级管理员！'), Yii::app()->createUrl("Auth/admin")));
                }
                $state = isset($_POST['state'])?$_POST['state']:'0';
                if($_POST['real_name']!=''&&$_POST['email']!=''){
                    $admin->admin_id = $id;
                    $admin->admin_real_name = $_POST['real_name'];
                    $admin->role_id = $_POST['role'];
                    $admin->admin_email = $_POST['email'];
                    $admin->admin_state = $state;
                    $count=$admin->save();
                    if($count>0){
                        Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Auth/admin"));
                    }else{
                        Helper::show_message(yii::t('vcos', '修改失败。'), Yii::app()->createUrl("Auth/admin"));
                    }
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败。'), Yii::app()->createUrl("Auth/admin"));
                }
            }
        }
        $this->render('admin_edit',array('role'=>$role,'admin'=>$admin,'id'=>$id));
    }

    public function actionRole()
    {
        $this->setauth();//检查有无权限
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $count = VcosAdminRole::model()->deleteAll("role_id in('$ids')");
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Auth/role")); 
            }else{
                Helper::show_message(yii::t('vcos', '删除失败。')); 
            }
        }
        if(isset($_GET['id'])){
            $did=$_GET['id'];
            $count=VcosAdminRole::model()->deleteByPk($did);
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Auth/role")); 
            }else{
                Helper::show_message(yii::t('vcos', '删除失败。')); 
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_admin_role WHERE role_id > 1 ORDER BY role_id DESC";
        $count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_admin_role WHERE role_id > 1 ORDER BY role_id DESC LIMIT {$criteria->offset}, 10";
        $role = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('role',array('pages'=>$pager,'auth'=>$this->auth,'role'=>$role));
    }
    
    public function actionRole_add()
    {
        $this->setauth();//检查有无权限
        $role = new VcosAdminRole();
        if($_POST){
            if($_POST['role']=='超级管理员'){
                die(Helper::show_message(yii::t('vcos', '你不能命名为超级管理员。'), Yii::app()->createUrl("Auth/role")));
            }
            $a = explode(',', $_POST['hidden']);
            $num = count($a);
            unset($a[$num-1]);
            if($a[0] == '12'){
                unset($a[0]);
            }
            foreach($a as $row){
                $sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM vcos_permission_menux a, vcos_permission_menux b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$row}";
                $b = Yii::app()->m_db->createCommand($sql)->queryRow();//跟住自id查找父目录的id，
                if($b['bparent_menu_id']!='0'){//当父目录不为顶级目录时继续查找父目录
                    $sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM vcos_permission_menux a, vcos_permission_menux b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$b['bmenu_id']}";
                    $c = Yii::app()->m_db->createCommand($sql)->queryRow();
                    $permission[$c['bmenu_id']][$c['amenu_id']][] = $row;//封装第三级目录数组
                }else{
                    $permission[$b['bmenu_id']][] = $row;//封装第二级目录数组
                }
            }
            $permission = json_encode($permission);
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['role']!=''&&$_POST['describe']!=''){
                $role->role_name = $_POST['role'];
                $role->role_desc = $_POST['describe'];
                $role->permission_menu = $permission;
                $role->role_state = $state;
                if($role->save()>0){
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Auth/role")); 
                }else{
                    Helper::show_message(yii::t('vcos', '添加失败。'));  
                }
            }else{
                Helper::show_message(yii::t('vcos', '添加失败。')); 
            }
        }
        $permission_click = VcosPermissionClick::model()->findAll();
        $this->render('role_add',array('permission_click'=>$permission_click));
    }

    public function actionRole_edit()
    {
        $this->setauth();//检查有无权限
        $edit_id = (isset($_POST['edit_id']))?$_POST['edit_id']:FALSE;
        $edit_id2 = (isset($_POST['edit_id2']))?$_POST['edit_id2']:FALSE;
        $id=$edit_id?$edit_id:$edit_id2;
        $role= VcosAdminRole::model()->findByPk($id);
        $permission = $role['permission_menu'];
        $permission = json_decode($permission,true);
        $admin_id = Yii::app()->user->id;
        if($_POST){
            if(!$edit_id){
                if($_POST['role']=='超级管理员'){
                    die(Helper::show_message(yii::t('vcos', '你不能命名为超级管理员！'), Yii::app()->createUrl("Auth/role")));
                }
                $sql = "SELECT * FROM vcos_admin_role WHERE role_name = '{$_POST['role']}' AND role_id NOT IN ({$_POST['role_id']})";
                $result = Yii::app()->m_db->createCommand($sql)->queryAll();
                if($result){
                    die(Helper::show_message(yii::t('vcos', '此分组名已被使用。'))); 
                }
                $a = explode(',', $_POST['hidden']);
                $num = count($a);
                unset($a[$num-1]);
                $new_permission = array();
                foreach($a as $row){
                $sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM vcos_permission_menux a, vcos_permission_menux b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$row}";
                $b = Yii::app()->m_db->createCommand($sql)->queryRow();//跟住自id查找父目录的id，
                if($b['bparent_menu_id']!='0'){//当父目录不为顶级目录时继续查找父目录
                    $sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM vcos_permission_menux a, vcos_permission_menux b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$b['bmenu_id']}";
                    $c = Yii::app()->m_db->createCommand($sql)->queryRow();
                    $new_permission[$c['bmenu_id']][$c['amenu_id']][] = $row;//封装第三级目录数组
                }else{
                    $new_permission[$b['bmenu_id']][] = $row;//封装第二级目录数组
                }
            }
                $n_permission = Yii::app()->session[$admin_id.'test'];
                unset($n_permission[0]);
                //var_dump($n_permission);unset(Yii::app()->session[$admin_id.'test']);die;
                foreach ($n_permission as $key=>$row){
                    if(is_array($row)){//判断是否是3级目录
                        foreach($row as $k=>$item){
                            $n_permission[$key][$k] = array();//将点击过的权限组封装成空数组
                        }
                    }else{
                        $n_permission[$key] = array();
                    }
                }
                foreach($new_permission as $key=>$row){
                    if(is_array($row)){//判断是否是3级目录
                        foreach($row as $k=>$item){
                            $n_permission[$key][$k] = $item;
                        }  
                    }else {
                        $n_permission[$key] = $row;
                    }
                }
                foreach ($n_permission as $key=>$row){
                    if(is_array($row)){//判断是否是3级目录
                        foreach ($row as $k=>$item){
                            if(empty($item)){ 
                                unset($permission[$key][$k]);
                            }
                        }
                    }else{
                        if(empty($row)){ 
                            unset($permission[$key]);
                        }
                    }
                }
                foreach($new_permission as $key=>$row){
                    if(is_array($row)){//判断是否是3级目录
                        foreach ($row as $k=>$item){
                            $permission[$key][$k] = $item;
                        }
                    }  else {
                        $permission[$key] = $row;
                    }
                }
                if(empty($permission)){ 
                    die(Helper::show_message(yii::t('vcos', '该分组不能没有权限！'), Yii::app()->createUrl("Auth/role")));
                }
                $permission = json_encode($permission);
                $state = isset($_POST['state'])?$_POST['state']:'0';
                if($_POST['role']!=''&&$_POST['describe']!=''){
                	//var_dump($_POST);
                	//判断若hidden值为空，代表打开分类为全部不选中状态，
                	if($_POST['hidden'] == '' && $_POST['hidden_parent'] != ''){
                		$del_json = $_POST['hidden_parent'];
                		$del_id = explode(',',$del_json);
                		foreach($del_id as $v){
                			$reg = "/\"".$v."\"\:\[(.*?)\](,?)/";
                			$permission = preg_replace($reg,"", $permission);
                		} 
                	}elseif($_POST['hidden'] != '' && $_POST['hidden_parent'] != ''){
                		//查询子类的父级键名，将hidden_parent中去除该父级键名
                		$hidden = trim($_POST['hidden'],',');
                		$hidden_parent = $_POST['hidden_parent'];
                		$hidden_parent = explode(',',$hidden_parent);
                		$sql = "SELECT parent_menu_id FROM `vcos_permission_menux` WHERE menu_id in ({$hidden}) GROUP BY parent_menu_id";
                		//var_dump($sql);exit;
                		$result = Yii::app()->m_db->createCommand($sql)->queryAll();
                		foreach ($result as $val){
                			if(in_array($val['parent_menu_id'], $hidden_parent)){
                				unset($hidden_parent[array_search($val['parent_menu_id'],$hidden_parent)]);
                			}
                		}
                		foreach($hidden_parent as $v){
                			$reg = "/\"".$v."\"\:\[(.*?)\](,?)/";
                			$permission = preg_replace($reg,"", $permission);
                		}
                	}
                	
                	//将最外层{...,}的最后一个逗号去除，有时有有时无
                	$permission = substr($permission , 1 , -1);
                	$permission = trim($permission,",");
                	$permission = '{'.$permission.'}';
                	//var_dump($permission);
                	//exit;
                    $role->role_id = $id;
                    $role->role_name = $_POST['role'];
                    $role->role_desc = $_POST['describe'];
                    $role->permission_menu = $permission;
                    $role->role_state = $state;
                    $count=$role->update('role_id','role_name','role_desc','permission_menu','role_state');
                    if($count>0){
                        unset(Yii::app()->session[$admin_id.'test']);
                        Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Auth/role"));
                    }else{
                        unset(Yii::app()->session[$admin_id.'test']);
                        Helper::show_message(yii::t('vcos', '修改失败。'), Yii::app()->createUrl("Auth/role")); 
                    }
                }else{
                    unset(Yii::app()->session[$admin_id.'test']);
                    Helper::show_message(yii::t('vcos', '修改失败。'), Yii::app()->createUrl("Auth/role")); 
                }
            }
        }
        $permission_click = VcosPermissionClick::model()->findAll();
        $this->render('role_edit',array('role'=>$role,'permission_click'=>$permission_click,'id'=>$id));
    }
    
    public function actionMenu_permission()
    {    
        $roles=array();
        if(isset($_POST['role'])){
            $role = json_decode($_POST['role']);
            foreach($role as $row){
                foreach($row as $val){
                    if(is_array($val)){
                        foreach ($val as $item){
                            $roles[] = $item;
                        }
                    }
                    $roles[] = $val; 
                }
            }
            $admin_id = Yii::app()->user->id;
            if(is_array(Yii::app()->session[$admin_id.'test'])){
                //存入第一个以后的控制器id
                $role_session = Yii::app()->session[$admin_id.'test'];
                $sql = "SELECT a.menu_id AS amenu_id ,a.parent_menu_id AS aparent_menu_id , b.menu_id AS bmenu_id ,b.parent_menu_id AS bparent_menu_id FROM vcos_permission_menux a, vcos_permission_menux b WHERE a.parent_menu_id = b.menu_id AND a.menu_id = {$_POST['id']}";
                $result = Yii::app()->m_db->createCommand($sql)->queryRow();
                //var_dump($result);die;
                if($result){
                    if(is_array($role_session[$result['bmenu_id']])){
                        $role_session[$result['bmenu_id']][$_POST['id']] = $_POST['id'];
                    }else{
                        $role_session[$result['bmenu_id']] = array();
                        $role_session[$result['bmenu_id']][$_POST['id']] = $_POST['id'];
                    }
                }  else {
                    $role_session[$_POST['id']] = $_POST['id']; 
                }
            
                Yii::app()->session[$admin_id.'test'] = $role_session;
            }else{
                //存入第一个控制器id
                $role_session = array();
                $role_session[$_POST['id']] = $_POST['id']; 
                Yii::app()->session[$admin_id.'test'] = $role_session;
            }
        }
        
        $sql = "SELECT a.* ,(SELECT COUNT(*) FROM vcos_permission_menux a2 WHERE a2.parent_menu_id = a.menu_id) as child FROM vcos_permission_menux a WHERE a.parent_menu_id ={$_POST['id']} AND a.permission_state = 1 AND a.is_systemsetting ='0' ";
        $permission = Yii::app()->m_db->createCommand($sql)->queryAll();
        $j=1;
        $a='';
        $i = count($permission);
        foreach ($permission as $row){
            if($row['child']>0){
                if($j<$i){
                    $j++;
                    $a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('vcos',$row['role_name']).'","type" : "folder","additionalParameters":{"id":"'.$row['menu_id'].'","children":true}},';
                }else{
                    $a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('vcos',$row['role_name']).'","type" : "folder","additionalParameters":{"id":"'.$row['menu_id'].'","children":true}}';
                }
            }  else {
                if($j<$i){
                    $j++;
                    if(in_array($row['menu_id'],$roles)){
                        $a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('vcos',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'","item-selected":true}},';
                    }  else {
                        $a .= '"'.$row['menu_id'].'":{"text" : "'.yii::t('vcos',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'"}},';
                    }
                }  else {
                    if(in_array($row['menu_id'],$roles)){
                        $a .= '"'.$row['list_order'].'":{"text" : "'.yii::t('vcos',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'","item-selected":true}}';
                    }  else {
                        $a .= '"'.$row['list_order'].'":{"text" : "'.yii::t('vcos',$row['role_name']).'","type" : "item","additionalParameters":{"id":"'.$row['menu_id'].'"}}';
                    }
                }
            }
        }
        $a = '{"status":"OK","data":{'.$a.'}}';
        echo $a;
    }
    
    public function actionPassword_edit()
    {
        $admin= VcosAdmin::model();
        if($_POST){
            $admin_id = Yii::app()->user->id;
            $admin_password = md5($_POST['old_password']);
            $sql = "SELECT * FROM vcos_admin WHERE admin_id = {$admin_id} AND admin_password = '{$admin_password}'";
            $result = Yii::app()->m_db->createCommand($sql)->queryRow();
            if($result){
                $admin->admin_id = $admin_id;
                $admin->admin_password = md5($_POST['new_password']);
                $count=$admin->update('admin_id','admin_password');
                if($count>0){
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("site/index")); 
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败。')); 
                }
            }  else {
                Helper::show_message(yii::t('vcos', '原密码不正确。'));
            }
        }
        $this->render('password_edit');
    }
    
    public function actionChecknameajax(){
        $sql = "SELECT * FROM vcos_admin WHERE admin_name = '{$_POST['name']}'";
        $name = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($name){
            echo "false";
        }else{
            echo "true";
        }
    }
    
    public function actionCheckroleajax(){
        $result = explode("|", $_POST['role']);
        $sql = "SELECT * FROM vcos_admin_role WHERE role_name = '{$result[0]}'";
        if($result[1] != 'undefined'){
            $sql = $sql." AND role_id NOT IN ({$result[1]})";
        }
        $name = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($name){
            echo "false";
        }else{
            echo "true";
        }
    }
    
    public function actionCheckpasswordajax(){
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM vcos_admin WHERE admin_password = '{$password}' AND admin_id = '{$_POST['id']}'";
        $name = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($name){
            echo "false";
        }else{
            echo "true";
        }
    }
    
    public function actionResetpassword()
    {
        $id = $_GET['id'];
        $admin = VcosAdmin::model()->findByPk($id);
        $admin->admin_id = $id;
        $admin->admin_password = md5('12345678');
        if($admin->save()>0){
            Helper::show_message(yii::t('vcos', '重设成功,密码为12345678。'), Yii::app()->createUrl("Auth/admin"));
        }else{
            Helper::show_message(yii::t('vcos', '重设失败。')); 
        }
    }
    
    public function actionCheckadmin()
    {
        $admin = VcosAdmin::model()->count('role_id=:id',array(':id'=>$_POST['id']));
        echo $admin;
    }
    
    public function actionCheckismyself()
    {
        if($_POST['id'] == Yii::app()->user->id){
            echo '1';
        }
    }
}