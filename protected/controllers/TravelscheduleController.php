<?php

class TravelscheduleController extends Controller
{
    public function actionTravelSchedule_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //多条删除
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosTravelSchedule::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count = VcosTravelSchedule::model()->deleteAll("ts_id in('$ids')");
                $count2 = VcosTravelScheduleLanguage::model()->deleteAll("ts_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Travelschedule/TravelSchedule_list"));   
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosTravelSchedule::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count = VcosTravelSchedule::model()->deleteByPk($did);
                $count2 = VcosTravelScheduleLanguage::model()->deleteAll("ts_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Travelschedule/TravelSchedule_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_travel_schedule a LEFT JOIN vcos_travel_schedule_language b ON a.ts_id = b.ts_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.ts_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_travel_schedule a LEFT JOIN vcos_travel_schedule_language b ON a.ts_id = b.ts_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.ts_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $schedule = $db->createCommand($sql)->queryAll();
        $this->render('index',array('pages'=>$pager,'auth'=>$this->auth,'schedule'=>$schedule));
    }

    public function actionTravelSchedule_add()
    {
        $this->setauth();//检查有无权限
        $schedule = new VcosTravelSchedule();
        $schedule_language = new VcosTravelScheduleLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'ts_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $schedule->ts_time = $_POST['time'];
            $schedule->ts_start_time = $_POST['stime'];
            $schedule->ts_end_time = $_POST['etime'];
            $schedule->ts_state = $state;
            $schedule->ts_img_url = 'ts_images/'.Yii::app()->params['month'].'/'.$photo;
            //匹配替换编辑器中图片路径
            $msg = $_POST['contents'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['contents_iso'] != ''){
            	$msg_iso = $_POST['contents_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $schedule->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_travel_schedule_language` (`ts_id`, `iso`, `ts_title`, `ts_address`, `ts_content`,`ts_desc`) VALUES ('{$schedule->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$_POST['address']}', '{$describe}','{$_POST['desc']}'), ('{$schedule->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$_POST['address_iso']}', '{$describe_iso}','{$_POST['desc_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Travelschedule/TravelSchedule_list"));
                }  else {//只添加系统语言时
                    $schedule_language->ts_id = $schedule->primaryKey;
                    $schedule_language->iso = Yii::app()->params['language'];
                    $schedule_language->ts_title = $_POST['title'];
                    $schedule_language->ts_address = $_POST['address'];
                    $schedule_language->ts_content = $describe;
                    $schedule_language->ts_desc = $_POST['desc'];
                    $schedule_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Travelschedule/TravelSchedule_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('add',array('schedule'=>$schedule,'schedule_language'=>$schedule_language));
    }

    public function actionTravelSchedule_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $schedule=  VcosTravelSchedule::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_travel_schedule a LEFT JOIN vcos_travel_schedule_language b ON a.ts_id = b.ts_id WHERE a.ts_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $schedule_language = VcosTravelScheduleLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'ts_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //匹配替换编辑器中图片路径
            $msg = $_POST['contents'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['contents_iso'] != ''){
            	$msg_iso = $_POST['contents_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('ts_time'=>$_POST['time'],'ts_start_time'=>$_POST['stime'],'ts_end_time'=>$_POST['etime'],'ts_state'=>$state);
                    if($photo){//判断有无上传图片
                        $columns['ts_img_url'] = 'ts_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_travel_schedule',$columns,'ts_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_travel_schedule_language', array('ts_title'=>$_POST['title'],'ts_address'=>$_POST['address'],'ts_content'=>$describe,'ts_desc'=>$_POST['desc']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_travel_schedule_language',array('ts_id'=>$id,'iso'=>$_POST['language'],'ts_title'=>$_POST['title_iso'],'ts_address'=>$_POST['address_iso'],'ts_content'=>$describe_iso,'ts_desc'=>$_POST['desc_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_travel_schedule_language', array('ts_title'=>$_POST['title_iso'],'ts_address'=>$_POST['address_iso'],'ts_content'=>$describe_iso,'ts_desc'=>$_POST['desc_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Travelschedule/TravelSchedule_list"));
                }  else {//只编辑系统语言状态下
                    $schedule->ts_id = $id;
                    $schedule->ts_time = $_POST['time'];
                    $schedule->ts_start_time = $_POST['stime'];
                    $schedule->ts_end_time = $_POST['etime'];
                    $schedule->ts_state = $state;
                    if($photo){
                        $schedule->ts_img_url = 'ts_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $schedule->save();
                    $schedule_language->id = $id2['id'];
                    $schedule_language->ts_title = $_POST['title'];
                    $schedule_language->ts_address = $_POST['address'];
                    $schedule_language->ts_content = $describe;
                    $schedule_language->ts_desc = $_POST['desc'];
                    $schedule_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Travelschedule/TravelSchedule_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $this->render('edit',array('schedule'=>$schedule,'schedule_language'=>$schedule_language));
    }
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.ts_title, b.ts_address, b.ts_content,b.ts_desc FROM vcos_travel_schedule a LEFT JOIN vcos_travel_schedule_language b ON a.ts_id = b.ts_id WHERE a.ts_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
}