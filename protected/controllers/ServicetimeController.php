<?php 

class ServicetimeController extends Controller
{
	public function actionServiceTime_list()
	{
		$this->setauth();
		$db = Yii::app()->m_db;

		if($_POST)
		{
			$a = count($_POST['ids']);
			$result = VcosServiceTime::model()->count();
			if($a == $result)
			{
				die(Helper::show_message(Yii::t('vcos','不能把所有记录删除！')));
			}

			$ids = implode('\',\'',$_POST['ids']);

			$transaction = $db->beginTransaction();

			try{
				$count = VcosServiceTime::model()->deleteAll("service_id in ('$ids')");
				$count2 = VcosServiceTimeLanguage::model()->deleteAll("service_id in ('$ids')");
				$transaction->commit();
				Helper::show_message(Yii::t('vcos','删除成功。'),Yii::app()->createUrl("Servicetime/Servicetime_list"));
			}
			catch(Exception $e)
			{
				$transaction->rollBacl();
				Helper::show_message(Yii::t('vcos','删除失败。'));
			}
		}

		if(isset($_GET['id']))
		{
			$result = VcosServiceTime::model()->count();
			if($result <= 1)
			{
				die(Helper::show_message(Yii::t('vcos','不能把所有记录删除！')));
			}
			$did = $_GET['id'];

			$transaction2 =$db->beginTransaction();
			try
			{
				$count = VcosServiceTime::model()->deleteByPk($did);
				$count2 = VcosServiceTimeLanguage::model()->deleteAll("Service_id in ('$did')");
				$transaction2->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Servicetime/ServiceTime_list"));
	            }catch(Exception $e){
	                $transaction2->rollBack();
	                Helper::show_message(yii::t('vcos', '删除失败。'));
	            }
			}
			$count_sql = "SELECT count(*) count FROM vcos_service_time a LEFT JOIN vcos_service_time_language b ON a.service_id = b.service_id WHERE b.iso ='".Yii::app()->language."' ORDER BY a.service_id DESC";
			$count = $db->createCommand($count_sql)->queryRow();

			$criteria = new CDbCriteria();
			$count = $count['count'];
			$pager = new CPagination($count);
			$pager->pageSize = 10;
			$pager->applyLimit($criteria);
			$sql = "SELECT * FROM vcos_service_time a LEFT JOIN vcos_service_time_language b ON a.service_id = b.service_id WHERE b.iso ='".Yii::app()->language."' ORDER BY a.service_id DESC LIMIT {$criteria->offset},{$pager->pageSize}";
			$service = $db->createCommand($sql)->queryAll();
			$this->render('index',array('pages'=>$pager,'auth'=>$this->auth,'service'=>$service));
	}
	 public function actionServiceTime_add()
    {
        $this->setauth();//检查有无权限
        $service = new VcosServiceTime();
        $service_language = new VcosServiceTimeLanguage();
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $service->service_tel = $_POST['tel'];
            $service->service_state = $state;
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $service->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_service_time_language` (`service_id`, `iso`, `service_department`, `service_address`, `service_opening_time`) VALUES ('{$service->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$_POST['address']}', '{$_POST['time']}'), ('{$service->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$_POST['address_iso']}', '{$_POST['time_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Servicetime/ServiceTime_list"));
                }  else {//只添加系统语言时
                    $service_language->service_id = $service->primaryKey;
                    $service_language->iso = Yii::app()->params['language'];
                    $service_language->service_department = $_POST['title'];
                    $service_language->service_address = $_POST['address'];
                    $service_language->service_opening_time = $_POST['time'];
                    $service_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Servicetime/ServiceTime_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('add',array('service'=>$service,'service_language'=>$service_language));
    }

     public function actionServiceTime_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $service= VcosServiceTime::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_service_time a LEFT JOIN vcos_service_time_language b ON a.service_id = b.service_id WHERE a.service_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $service_language = VcosServiceTimeLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_service_time',array('service_tel'=>$_POST['tel'],'service_state'=>$state),'service_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_service_time_language', array('service_department'=>$_POST['title'],'service_address'=>$_POST['address'],'service_opening_time'=>$_POST['time']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_service_time_language',array('service_id'=>$id,'iso'=>$_POST['language'],'service_department'=>$_POST['title_iso'],'service_address'=>$_POST['address_iso'],'service_opening_time'=>$_POST['time_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_service_time_language', array('service_department'=>$_POST['title_iso'],'service_address'=>$_POST['address_iso'],'service_opening_time'=>$_POST['time_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Servicetime/ServiceTime_list"));
                }  else {//只编辑系统语言状态下
                    $service->service_id = $id;
                    $service->service_tel = $_POST['tel'];
                    $service->service_state = $state;
                    $service->save();
                    $service_language->id = $id2['id'];
                    $service_language->service_department = $_POST['title'];
                    $service_language->service_address = $_POST['address'];
                    $service_language->service_opening_time = $_POST['time'];
                    $service_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Servicetime/ServiceTime_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $this->render('edit',array('service'=>$service,'service_language'=>$service_language));
    }

    /**判断部门名称是否存在**/
    public function actionServiceGetAgain(){
    	$service_name = $_POST['title'];
    	$this_id = isset($_POST['this_id'])?$_POST['this_id']:0;
    	
    	if($this_id != 0){
    		$sql = "SELECT count(*) count FROM `vcos_service_time_language` WHERE service_department='{$service_name}' AND iso='zh_cn' AND service_id !=".$this_id;
    	}else{
    		$sql = "SELECT count(*) count FROM `vcos_service_time_language` WHERE service_department='{$service_name}' AND iso='zh_cn'";
    	}
    	
    	$count = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($count['count']){
    		echo 1;
    	}  else {
    		echo 0;
    	}
    }
    
    
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.service_department, b.service_address, b.service_opening_time FROM vcos_service_time a LEFT JOIN vcos_service_time_language b ON a.service_id = b.service_id WHERE a.service_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }

}