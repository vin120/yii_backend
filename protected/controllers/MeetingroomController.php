<?php

class MeetingroomController extends Controller
{
    public function actionMeetingroom_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //多条删除
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosMeetingroom::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count = VcosMeetingroom::model()->deleteAll("m_id in('$ids')");
                $count2 = VcosMeetingroomLanguage::model()->deleteAll("m_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Meetingroom/meetingroom_list"));   
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosMeetingroom::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count = VcosMeetingroom::model()->deleteByPk($did);
                $count2 = VcosMeetingroomLanguage::model()->deleteAll("m_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Meetingroom/meetingroom_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_meetingroom a LEFT JOIN vcos_meetingroom_language b ON a.m_id = b.m_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.m_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_meetingroom a LEFT JOIN vcos_meetingroom_language b ON a.m_id = b.m_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.m_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}"; 
        $detail = $db->createCommand($sql)->queryAll();
        $this->render('meetingroom_list',array('pages'=>$pager,'auth'=>$this->auth,'detail'=>$detail));
    }
    
    public function actionMeetingroom_add()
    {
        $this->setauth();//检查有无权限
        $detail = new VcosMeetingroom();
        $detail_language = new VcosMeetingroomLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'meetingroom_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $detail->state = $state;
            $detail->img_url = 'meetingroom_images/'.Yii::app()->params['month'].'/'.$photo;
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != ''){
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $detail->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_meetingroom_language` (`m_id`, `iso`, `title`) VALUES ('{$detail->primaryKey}', '".Yii::app()->params['language']."', '{$describe}'), ('{$detail->primaryKey}', '{$_POST['language']}', '{$describe_iso}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Meetingroom/meetingroom_list"));
                }  else {//只添加系统语言时
                    $detail_language->m_id = $detail->primaryKey;
                    $detail_language->iso = Yii::app()->params['language'];
                    $detail_language->title = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Meetingroom/meetingroom_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('meetingroom_add',array('detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionMeetingroom_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $detail= VcosMeetingroom::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_meetingroom a LEFT JOIN vcos_meetingroom_language b ON a.m_id = b.m_id WHERE a.m_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $detail_language = VcosMeetingroomLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'meetingroom_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != ''){
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('state'=>$state);
                    if($photo){//判断有无上传图片
                        $columns['img_url'] = 'meetingroom_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_meetingroom',$columns,'m_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_meetingroom_language', array('title'=>$describe), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_meetingroom_language',array('m_id'=>$id,'iso'=>$_POST['language'],'title'=>$describe_iso));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_meetingroom_language', array('title'=>$describe_iso), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Meetingroom/meetingroom_list"));
                }  else {//只编辑系统语言状态下
                    $detail->m_id = $id;
                    $detail->state = $state;
                    if($photo){
                        $detail->img_url = 'meetingroom_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $detail->save();
                    $detail_language->id = $id2['id'];
                    $detail_language->title = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Meetingroom/meetingroom_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $this->render('meetingroom_edit',array('detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.title FROM vcos_meetingroom a LEFT JOIN vcos_meetingroom_language b ON a.m_id = b.m_id WHERE a.m_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
}