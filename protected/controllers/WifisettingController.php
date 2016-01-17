<?php

class WifisettingController extends Controller
{
    public function actionWifi_config_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        $wifi = VcosWifiConfig::model()->findAll();
        
        if($_POST){
        	$a = count($_POST['ids']);
            $ids=implode('\',\'', $_POST['ids']);
            $result = VcosWifiConfig::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosWifiConfig::model()->deleteAll("config_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Wifisetting/Wifi_config_list"));   
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
        	$result = VcosWifiConfig::model()->count();
        	if($result<=1){
        		die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
        	}
        	$did=$_GET['id'];
        	//事务处理
        	$transaction2=$db->beginTransaction();
        	try{
        		$count = VcosWifiConfig::model()->deleteByPk($did);
        		$transaction2->commit();
        		Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Wifisetting/Wifi_config_list"));
        	}catch(Exception $e){
        		$transaction2->rollBack();
        		Helper::show_message(yii::t('vcos', '删除失败。'));
        	}
        }
        
        $count_sql = "SELECT count(*) count FROM vcos_wifi_config ";
        $count = $db->createCommand($count_sql)->queryRow();
        
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        
        
        $this->render('wifi_config_list',array('wifi'=>$wifi,'auth'=>$this->auth,'pages'=>$pager));
    }
    
    /**更改wifi配置***/
    public function actionWifi_config_set_state(){
    	$sql = "UPDATE vcos_wifi_config t1,vcos_wifi_config t2 SET t1.config_state =  '1',t2.config_state = '0' WHERE t1.config_id = {$_GET['id']} AND t2.config_id NOT IN ( {$_GET['id']} )";
    	$wifis = Yii::app()->m_db->createCommand($sql)->execute();
    	if($wifis>0){
    		//Helper::show_message(yii::t('vcos', '保存成功'), Yii::app()->createUrl("Wifisetting/wifi_config_list"));
    		echo json_encode(1);
    	}else{
    		//Helper::show_message(yii::t('vcos', '保存失败'));
    		echo json_encode(0);
    	}
    }

    public function actionWifi_config_add()
    {
        $this->setauth();//检查有无权限
        $wifi = new VcosWifiConfig();
        if($_POST){
            if($_POST['describe']!=''&&$_POST['loginurl']!=''&&$_POST['logouturl']!=''&&$_POST['change']!=''&&$_POST['notice']!=''&&$_POST['policy']!=''&&$_POST['ssid']!=''&&$_POST['acip']!=''&&$_POST['apmac']!=''){
                $wifi->config_describe = $_POST['describe'];
                $wifi->config_login_url = $_POST['loginurl'];
                $wifi->config_logout_url = $_POST['logouturl'];
                $wifi->config_change_url = $_POST['change'];
                $wifi->config_notice = $_POST['notice'];
                $wifi->config_policy = $_POST['policy'];
                $wifi->config_ssid = $_POST['ssid'];
                $wifi->config_acip = $_POST['acip'];
                $wifi->config_apmac = $_POST['apmac'];
                if($wifi->save()>0){
                    Helper::show_message(yii::t('vcos', '添加成功'), Yii::app()->createUrl("Wifisetting/wifi_config_list"));
                }else{
                    Helper::show_message(yii::t('vcos', '添加失败'));
                }
            }else{
                Helper::show_message(yii::t('vcos', '添加失败'));
            }
        }
        $this->render('wifi_config_add');
    }

    public function actionWifi_config_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $wifi= VcosWifiConfig::model()->findByPk($id);
        if($_POST){
            if($_POST['describe']!=''&&$_POST['loginurl']!=''&&$_POST['logouturl']!=''&&$_POST['change']!=''&&$_POST['notice']!=''&&$_POST['policy']!=''&&$_POST['ssid']!=''&&$_POST['acip']!=''&&$_POST['apmac']!=''){
                $wifi->config_id = $id;
                $wifi->config_describe = $_POST['describe'];
                $wifi->config_login_url = $_POST['loginurl'];
                $wifi->config_logout_url = $_POST['logouturl'];
                $wifi->config_change_url = $_POST['change'];
                $wifi->config_notice = $_POST['notice'];
                $wifi->config_policy = $_POST['policy'];
                $wifi->config_ssid = $_POST['ssid'];
                $wifi->config_acip = $_POST['acip'];
                $wifi->config_apmac = $_POST['apmac'];
                if($wifi->save()>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("Wifisetting/wifi_config_list"));
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
                }
            }else{
                Helper::show_message(yii::t('vcos', '修改失败'));
            }
        }
        $this->render('wifi_config_edit',array('wifi'=>$wifi));
    }
	
}