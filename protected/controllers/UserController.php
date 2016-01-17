<?php

class UserController extends Controller
{
    public function actionUser_list()
    {
        $this->setauth();//检查有无权限
        $temp_sql = "SELECT a.member_id,a.member_code,a.cn_name,a.last_name,a.first_name,b.country_name,a.passport_number,a.passport_date_issue,a.passport_expiry_date FROM vcos_member a, vcos_country b WHERE a.country_code = b.country_short_code";
        $criteria = new CDbCriteria();
        if($_POST){
            $count = VcosMember::model()->countBySql("SELECT * FROM vcos_member WHERE member_code LIKE :search",array(':search'=>'%'.$_POST['search'].'%'));
            //echo $count;die;
            $pager = new CPagination($count);
            $pager->pageSize=15;
            $pager->applyLimit($criteria); 
            $sql = $temp_sql." AND a.member_code LIKE '%{$_POST['search']}%' LIMIT {$criteria->offset}, 15";
        }  else {
            $count = VcosMember::model()->count();
            $pager = new CPagination($count);
            $pager->pageSize=15;
            $pager->applyLimit($criteria); 
            $sql = $temp_sql." ORDER BY a.member_id LIMIT {$criteria->offset}, 15";
        }
        $user = Yii::app()->db->createCommand($sql)->queryAll();
        $this->render('user_list',array('user'=>$user,'pages'=>$pager));
        
    }
    
    public function actionUser_detail() 
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $sql = "SELECT * FROM vcos_member a, vcos_country b, vcos_member_nation c WHERE a.country_code = b.country_short_code AND a.nation_code = c.nation_code AND a.member_id = {$id}";
        $detail = Yii::app()->db->createCommand($sql)->queryRow();
        $this->render('user_detail',array('detail'=>$detail));
    }
    
    public function actionUser_edit()
    {
        $this->setauth();//检查有无权限
        $id = $_GET['id'];
        $detail = VcosMember::model()->findByPk($id);
        $country = VcosCountry::model()->findAll();
        $nation = VcosMemberNation::model()->findAll();
        if($_POST){
            $sql = "SELECT * FROM vcos_member WHERE passport_number = '{$_POST['passport']}' AND member_code NOT IN ({$_POST['member_id']})";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            if($result){
                die(Helper::show_message(yii::t('vcos', '此护照已被使用'))); 
            }
            if($_POST['member_id']!=''&&$_POST['cn_name']!=''&&$_POST['last_name']!=''&&$_POST['first_name']!=''&&$_POST['dob']!=''&&$_POST['birth_place']!=''&&$_POST['passport']!=''&&$_POST['passport_validate']!=''&&$_POST['issue_place']!=''&&$_POST['ic_number']!=''){
                $passport_validate = explode(" - ", $_POST['passport_validate']);
                $detail->member_id = $id;
                $detail->cn_name = $_POST['cn_name'];
                $detail->last_name = $_POST['last_name'];
                $detail->first_name = $_POST['first_name'];
                $detail->sex = $_POST['sex'];
                $detail->date_of_birth = strtotime($_POST['dob']);
                $detail->birth_place = $_POST['birth_place'];
                $detail->country_code = $_POST['country'];
                $detail->nation_code = $_POST['nation'];
                $detail->mobile_number = $_POST['mobile'];
                $detail->passport_number = $_POST['passport'];
                $detail->passport_date_issue = strtotime($passport_validate[0]);
                $detail->passport_expiry_date = strtotime($passport_validate[1]);
                $detail->passport_place_issue = $_POST['issue_place'];
                $detail->resident_id_card = $_POST['ic_number'];
                $detail->member_name = $_POST['member_name'];
                $detail->member_email = $_POST['email'];
                if($detail->save()>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("User/user_list"));
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败')); 
                }
            }else{
                Helper::show_message(yii::t('vcos', '修改失败')); 
            }
        }
        $this->render('user_edit',array('detail'=>$detail,'country'=>$country,'nation'=>$nation));
    }
    
    public function actionResetpassword()
    {
        $id = $_GET['id'];
        $detail = VcosMember::model()->findByPk($id);
        $detail->member_id = $id;
        $detail->member_password = md5('888888');
        if($detail->save()>0){
            Helper::show_message(yii::t('vcos', '重设成功(密码为:12345678)'), Yii::app()->createUrl("User/user_list"));
        }else{
            Helper::show_message(yii::t('vcos', '重设失败')); 
        }
    }
    
    public function actionCheckpassport(){
        $result = explode("|", $_POST['passport']);
        $sql = "SELECT * FROM vcos_member WHERE passport_number = '{$result[0]}' AND member_code NOT IN ({$result[1]})";
        $name = Yii::app()->db->createCommand($sql)->queryAll();
        if($name){
            echo "false";  
        }else{
            echo "true";
        }
    }
    
    
}