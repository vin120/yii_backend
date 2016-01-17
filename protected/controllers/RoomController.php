<?php

class RoomController extends Controller
{
    public function actionRoom_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        if(isset($_GET['id'])){
            $result = VcosRoom::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count = VcosRoom::model()->deleteByPk($did);
                $count2 = VcosRoomLanguage::model()->deleteAll("room_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Room/Room_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_room a LEFT JOIN vcos_room_language b ON a.room_id = b.room_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.room_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_room a LEFT JOIN vcos_room_language b ON a.room_id = b.room_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.room_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $room = $db->createCommand($sql)->queryAll();
        $this->render('room_list',array('pages'=>$pager,'auth'=>$this->auth,'room'=>$room));
    }
    
    public function actionRoom_add()
    {
        $this->setauth();//检查有无权限
        $room = new VcosRoom();
        $room_language = new VcosRoomLanguage();
        if($_POST){
        	$photo='';
        	if($_FILES['photo']['error']!=4){
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'room_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	$photo_iso = '';
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		if($_FILES['photo_iso']['error']!=4){
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'room_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //$room->room_name = $_POST['name'];
            $room->room_state = $state;
            
            $photo_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
            $photo_iso_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo_iso;
            
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $room->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_room_language` (`room_id`, `iso`, `room_name` ,`img_url`,`describe`) VALUES ('{$room->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['name']}','{$photo_url}','{$_POST['desc']}'), ('{$room->primaryKey}', '{$_POST['language']}', '{$_POST['name_iso']}','{$photo_iso_url}','{$_POST['desc_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Room/Room_list"));
                }  else {//只添加系统语言时
                    $room_language->room_id = $room->primaryKey;
                    $room_language->iso = Yii::app()->params['language'];
                    $room_language->room_name = $_POST['name'];
                    $room_language->img_url = $photo_url;
                    $room_language->describe = $_POST['desc'];
                    $room_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Room/Room_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('room_add',array('room'=>$room,'room_language'=>$room_language));
    }
    
    public function actionRoom_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $room= VcosRoom::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_room a LEFT JOIN vcos_room_language b ON a.room_id = b.room_id WHERE a.room_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $room_language = VcosRoomLanguage::model()->findByPk($id2['id']);
        if($_POST){
        	
        	$photo='';
        	$photo_iso='';
        	if($_FILES['photo']['error']!=4){
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'room_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		if($_FILES['photo_iso']['error']!=4){
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'room_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($state == '0'){
                $result = VcosRoomDetail::model()->count('room_id=:id',array(':id'=>$id));
                if($result>0){
                    die(Helper::show_message(yii::t('vcos', '此分类正在使用,不能禁用')));
                }
            }
            if($photo_iso){//判断有无上传图片
            	$photo_iso_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo_iso;
            }
            if($photo){//判断有无上传图片
            	$photo_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
            }
            
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_room',array('room_state'=>$state),'room_id = :id',array(':id'=>$id));

                    //编辑系统语言
                    $room_columns = array('room_name'=>$_POST['name']);
                    if($photo){//判断有无上传图片
                    	$room_columns['img_url'] = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    
                    $db->createCommand()->update('vcos_room_language', $room_columns, 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_room_language',array('room_id'=>$id,'iso'=>$_POST['language'],'room_name'=>$_POST['name_iso'],'img_url'=>$photo_iso_url,'describe'=>$_POST['desc_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_room_language', array('room_name'=>$_POST['name_iso'],'img_url'=> $photo_iso_url,'describe'=>$_POST['desc_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Room/Room_list"));
                }  else {//只编辑系统语言状态下
                    $room->room_id = $id;
                    $room->room_state = $state;
                    $room->save();
                    $room_language->id = $id2['id'];
                    $room_language->room_name = $_POST['name'];
                    if($photo){//判断有无上传图片
                    	$room_language->img_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                  
                    $room_language->describe = $_POST['desc'];
                    $room_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Room/Room_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $this->render('room_edit',array('room'=>$room,'room_language'=>$room_language));
    }
    
    /**查看客房分类是否已经存在**/
    public function actionRoomGetAgain(){
    	$room_name = $_POST['title'];
    	$this_id = isset($_POST['this_id'])?$_POST['this_id']:0;
    	if($this_id != 0){
    		$sql = "SELECT count(*) count FROM `vcos_room_language` WHERE room_name='{$room_name}' AND iso='zh_cn' AND room_id !=".$this_id;
    	}else{
    		$sql = "SELECT count(*) count FROM `vcos_room_language` WHERE room_name='{$room_name}' AND iso='zh_cn'";
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
        $sql = "SELECT b.id, b.room_name,b.img_url,b.describe FROM vcos_room a LEFT JOIN vcos_room_language b ON a.room_id = b.room_id WHERE a.room_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionRoom_detail()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //多条删除
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $a = count($_POST['ids']);
            $result = VcosRoomDetail::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count = VcosRoomDetail::model()->deleteAll("detail_id in('$ids')");
                $count2 = VcosRoomDetailLanguage::model()->deleteAll("detail_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Room/Room_detail"));   
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosRoomDetail::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count = VcosRoomDetail::model()->deleteByPk($did);
                $count2 = VcosRoomDetailLanguage::model()->deleteAll("detail_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Room/Room_detail"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_room_detail a, vcos_room_detail_language b, vcos_room c, vcos_room_language d WHERE a.detail_id = b.detail_id AND a.room_id = c.room_id AND a.room_id = d.room_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.room_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_room_detail a, vcos_room_detail_language b, vcos_room c, vcos_room_language d WHERE a.detail_id = b.detail_id AND a.room_id = c.room_id AND a.room_id = d.room_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.room_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $detail = $db->createCommand($sql)->queryAll();
        $this->render('room_detail',array('pages'=>$pager,'auth'=>$this->auth,'detail'=>$detail));
    }
    
    public function actionRoom_detail_add()
    {
        $this->setauth();//检查有无权限
        $detail = new VcosRoomDetail();
        $detail_language = new VcosRoomDetailLanguage();
        if($_POST){
        	
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'room_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $detail->room_id = $_POST['room'];
            //$detail->room_describe = $_POST['describe'];
            $detail->detail_state = $state;
            $detail->room_img_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
            
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
                    $sql = "INSERT INTO `vcos_room_detail_language` (`detail_id`, `iso`, `room_describe`) VALUES ('{$detail->primaryKey}', '".Yii::app()->params['language']."', '{$describe}'), ('{$detail->primaryKey}', '{$_POST['language']}', '{$describe_iso}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Room/room_detail"));
                }  else {//只添加系统语言时
                    $detail_language->detail_id = $detail->primaryKey;
                    $detail_language->iso = Yii::app()->params['language'];
                    $detail_language->room_describe = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Room/room_detail"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT * FROM vcos_room a LEFT JOIN vcos_room_language b ON a.room_id = b.room_id WHERE a.room_state = '1' AND b.iso = '".Yii::app()->language."'";
        $room = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('room_detail_add',array('room'=>$room,'detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionRoom_detail_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $detail= VcosRoomDetail::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_room_detail a LEFT JOIN vcos_room_detail_language b ON a.detail_id = b.detail_id WHERE a.detail_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $detail_language = VcosRoomDetailLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'room_images/'.Yii::app()->params['month'], 'image', 3);
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
                    $columns = array('room_id'=>$_POST['room'],'detail_state'=>$state);
                    if($photo){//判断有无上传图片
                        $columns['room_img_url'] = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_room_detail',$columns,'detail_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_room_detail_language', array('room_describe'=>$describe), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_room_detail_language',array('detail_id'=>$id,'iso'=>$_POST['language'],'room_describe'=>$describe_iso));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_room_detail_language', array('room_describe'=>$describe_iso), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Room/room_detail"));
                }  else {//只编辑系统语言状态下
                    $detail->detail_id = $id;
                    $detail->room_id = $_POST['room'];
                    $detail->detail_state = $state;
                    if($photo != ''){
                    $detail->room_img_url = 'room_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $detail->save();
                    $detail_language->id = $id2['id'];
                    $detail_language->room_describe = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Room/room_detail"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $sql = "SELECT * FROM vcos_room a LEFT JOIN vcos_room_language b ON a.room_id = b.room_id WHERE a.room_state = '1' AND b.iso = '".Yii::app()->language."'";
        $room = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('room_detail_edit',array('room'=>$room,'detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionGetiso_detail()
    {
        $sql = "SELECT b.id, b.room_describe FROM vcos_room_detail a LEFT JOIN vcos_room_detail_language b ON a.detail_id = b.detail_id WHERE a.detail_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionCheckdetail()
    {
        $result = VcosRoomDetail::model()->count('room_id=:id',array(':id'=>$_POST['id']));
        echo $result;
    }
    
    

}