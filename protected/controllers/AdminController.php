<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Rock.Lei
 */

class AdminController extends Controller
{
     public function actionAdminjsondate() {
        $_search = $_GET['_search'];
        $page = $_GET['page']; // get the requested page 
        $limit = $_GET['rows']; // get how many rows we want to have into the grid 
        $sidx = $_GET['sidx']; // get index row - i.e. user click to sort 
        $sord = $_GET['sord']; // get the direction
        
        $sidx = empty($sidx) ? 'admin_id' : $sidx;
        $where_value = '';
        //value eq false is not search
        if ('true' == $_search)
        {
            $filters=$_GET['filters'];
            $filters_object =json_decode($filters);
            $groupOp = $filters_object->groupOp;
            $rules_array = $filters_object->rules;
            $where_value = OperatorFuncs::setOperator($filters_object);
        }        
        
        $filed = 'SELECT admin.admin_id,admin.admin_name,admin.admin_password,admin.admin_email,admin.real_name,admin.admin_post,admin.admin_state,admin.role_id,role.role_name ';
        $filed_count = 'SELECT count(*) ';
        
        $admin_sql = 'FROM vcos_admin admin, vcos_admin_role role 
                            WHERE admin.role_id = role.role_id ';
        
        $where_sql =' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . ($page-1)*$limit . ',' . $limit;
        
        $count_sql = $filed_count.$admin_sql.$where_value;

        $count = Yii::app()->db->createCommand($count_sql)->queryScalar();
        $admin_array = array();
        
        if( $count >0 ) 
        {
            $total_pages = ceil($count/$limit); 
            $all_sql = $filed.$admin_sql.$where_value.$where_sql;
            
            $admin_array = Yii::app()->db->createCommand($all_sql)->queryAll();
        } 
        else 
        {
            $total_pages = 0; 
        }
        
        $responce['page']=$page;
        $responce['total']=$total_pages;
        $responce['records']=$count;
        $responce['rows']=$admin_array;
        
        $json_value = json_encode($responce);
        exit($json_value);
     }
     
     public function actionDummy()
     {
         print_r($_GET);
         echo '<br>';
         print_r($_POST);
         exit;
         //$this->render('index');
     }
     public function actionRolejsondate()
     {
         $role_sql = 'SELECT role_id,role_name,role_state FROM vcos_admin_role WHERE role_state=0';
         $role_array = Yii::app()->db->createCommand($role_sql)->queryAll();
         exit(json_encode($role_array));
     }
     public function actionManageAdmin()
     {
         $oper = $_POST['oper'];
         $vcosAdmin = new VcosAdmin();
         $vcosAdmin->admin_id = empty($_POST['admin_id']) ? $_POST['id'] : $_POST['admin_id'];
         $vcosAdmin->admin_name = $_POST['admin_name'];
         $vcosAdmin->admin_password = $_POST['admin_password'];
         $vcosAdmin->admin_email = $_POST['admin_email'];
         $vcosAdmin->real_name = $_POST['real_name'];
         $vcosAdmin->admin_post = $_POST['admin_post'];
         $vcosAdmin->role_id = $_POST['role_name'];
         $vcosAdmin->admin_state = $_POST['admin_state'];

         switch ($oper) {
             case 'add':
                AdminService::addAdmin($vcosAdmin);
                break;
            case 'edit':
                AdminService::editAdmin($vcosAdmin);
                break;
            case 'del':
                AdminService::delAdmin($vcosAdmin);
                break;
             default:
                 break;
         }
     }
     
     public function actionRoleList() {
        $this->render('role_list_view');
     }
     
     public function actionRoleListJsonData() {
        $page = $_GET['page']; // get the requested page 
        $limit = $_GET['rows']; // get how many rows we want to have into the grid 
        $sidx = $_GET['sidx']; // get index row - i.e. user click to sort 
        $sord = $_GET['sord']; // get the direction

        $sidx = empty($sidx) ? 'role_id' : $sidx;
                

        $filed = 'SELECT role_id,role_name,if(role_state=0,"Yes","No") as role_state ';
        $filed_count = 'SELECT count(*) ';

        $role_sql = 'FROM vcos_admin_role ';

        $where_sql =' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . ($page-1)*$limit . ',' . $limit;

        $count_sql = $filed_count.$role_sql;
        $count = Yii::app()->db->createCommand($count_sql)->queryScalar();
        $role_array = array();

        if( $count >0 ) 
        {
            $total_pages = ceil($count/$limit); 
            $all_sql = $filed.$role_sql.$where_sql;

            $role_array = Yii::app()->db->createCommand($all_sql)->queryAll();
        } 
        else 
        {
            $total_pages = 0; 
        }

        $responce['page']=$page;
        $responce['total']=$total_pages;
        $responce['records']=$count;
        $responce['rows']=$role_array;

        $json_value = json_encode($responce);
        exit($json_value);
     }
     public function actionManageRole()
     {
         $oper = $_POST['oper'];
         $role_id = empty($_POST['role_id']) ? $_POST['id'] : $_POST['role_id'];
         $role_name = $_POST['role_name'];
         $role_state = $_POST['role_state'];
         if ('Yes' == $role_state){
             $role_state = 0;
         }else{
             $role_state = 1;
         }
         switch ($oper) {
             case 'add':
                $vcosAdminRole = new VcosAdminRole();
                $vcosAdminRole->role_name = $role_name;
                $vcosAdminRole->role_state = $role_state;
                $vcosAdminRole->save();
                break;
            case 'edit':
                $vcosAdminRole = VcosAdminRole::model()->findByPk($role_id);
                $vcosAdminRole->role_name = $role_name;
                $vcosAdminRole->role_state = $role_state;
                $vcosAdminRole->update();
                break;
            case 'del':
                $vcosAdminRole=VcosAdminRole::model()->findByPk($role_id);
                $vcosAdminRole->delete();
                break;
             default:
                 break;
         }
     }
}
?>
