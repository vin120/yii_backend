<?php

class LineController extends Controller
{
    public function actionLine_list()
    {   
        $this->setauth();//检查有无权限
        $db= Yii::app()->m_db;
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosLine::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count = VcosLine::model()->deleteByPk($did);
                $count2 = VcosLineLanguage::model()->deleteAll("line_id in('$did')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("line/line_list"));    
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_line a LEFT JOIN vcos_line_language b ON a.line_id = b.line_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.line_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_line a LEFT JOIN vcos_line_language b ON a.line_id = b.line_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.line_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $line = $db->createCommand($sql)->queryAll();
        $this->render('line_list',array('pages'=>$pager,'auth'=>$this->auth,'line'=>$line));
    }
    
    public function actionLine_add()
    {   
        $this->setauth();//检查有无权限
        $line = new VcosLine();
        $line_language = new VcosLineLanguage();
        if($_POST){
            $time = explode(" - ", $_POST['time']);
            $stime = date('Y/m/d H:i:s',strtotime($time[0]));
            $etime = date('Y/m/d H:i:s',strtotime($time[1])+"86399");
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $line->state = $state;
            $line->start_time = $stime;
            $line->end_time = $etime;
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $line->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_line_language` (`line_id`, `iso`, `line_name`, `voyage_time`) VALUES ('{$line->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$_POST['vtime']}'), ('{$line->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$_POST['vtime_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Line/line_list"));
                }  else {//只添加系统语言时
                    $line_language->line_id = $line->primaryKey;
                    $line_language->iso = Yii::app()->params['language'];
                    $line_language->line_name = $_POST['title'];
                    $line_language->voyage_time =  $_POST['vtime'];
                    $line_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Line/line_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('line_add',array('line'=>$line,'line_language'=>$line_language));
    }
    
    public function actionLine_edit()
    {   
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $line= VcosLine::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_line a LEFT JOIN vcos_line_language b ON a.line_id = b.line_id WHERE a.line_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $line_language = VcosLineLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $time = explode(" - ", $_POST['time']);
            $stime = date('Y/m/d H:i:s',strtotime($time[0]));
            $etime = date('Y/m/d H:i:s',strtotime($time[1])+"86399");
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_line',array('start_time'=>$stime,'end_time'=>$etime,'state'=>$state),'line_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_line_language', array('line_name'=>$_POST['title'], 'voyage_time'=>$_POST['vtime']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_line_language',array('line_id'=>$id,'iso'=>$_POST['language'],'line_name'=>$_POST['title_iso'], 'voyage_time'=>$_POST['vtime_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_line_language', array('line_name'=>$_POST['title_iso'], 'voyage_time'=>$_POST['vtime_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Line/line_list"));
                }  else {//只编辑系统语言
                    $line->line_id = $id;
                    $line->start_time = $stime;
                    $line->end_time = $etime;
                    $line->state = $state;
                    $line->save();
                    $line_language->id = $id2['id'];
                    $line_language->line_name = $_POST['title'];
                    $line_language->voyage_time =  $_POST['vtime'];
                    $line_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Line/line_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $this->render('line_edit',array('line'=>$line,'line_language'=>$line_language));
    }
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.line_name, b.voyage_time FROM vcos_line a LEFT JOIN vcos_line_language b ON a.line_id = b.line_id WHERE a.line_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionLine_detail_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosLineDetail::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosLineDetail::model()->deleteAll("detail_id in('$ids')");
                $count2 = VcosLineDetailLanguage::model()->deleteAll("detail_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Line/line_detail_list")); 
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        if(isset($_GET['id'])){
            $result = VcosLineDetail::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosLineDetail::model()->deleteByPk($did);
                $count2 = VcosLineDetailLanguage::model()->deleteAll("detail_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Line/line_detail_list"));    
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_line_detail a, vcos_line_detail_language b, vcos_line c, vcos_line_language d WHERE a.detail_id = b.detail_id AND a.line_id = c.line_id AND a.line_id = d.line_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.detail_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_line_detail a, vcos_line_detail_language b, vcos_line c, vcos_line_language d WHERE a.detail_id = b.detail_id AND a.line_id = c.line_id AND a.line_id = d.line_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.detail_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $detail = $db->createCommand($sql)->queryAll();
        $this->render('line_detail_list',array('pages'=>$pager,'auth'=>$this->auth,'detail'=>$detail));  
    }
    
    public function actionLine_detail_add()
    {
        $this->setauth();//检查有无权限
        $detail = new VcosLineDetail();
        $detail_language = new VcosLineDetailLanguage();
        if($_POST){
        	
        	$photo='';
        	if($_FILES['photo']['error']!=4){
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'line_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	$photo_iso = '';
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		if($_FILES['photo_iso']['error']!=4){
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'line_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $detail->line_id = $_POST['line'];
            $detail->sequence = $_POST['sequence'];
            $detail->detail_state = $state;
            $photo_url = 'line_images/'.Yii::app()->params['month'].'/'.$photo;
            $photo_iso_url = 'line_images/'.Yii::app()->params['month'].'/'.$photo_iso;
            
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != ''){
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
          
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $detail->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_line_detail_language` (`detail_id`, `iso`, `title`, `content`,`img_url`) VALUES ('{$detail->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$describe}','{$photo_url}'), ('{$detail->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$describe_iso}','{$photo_iso_url}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Line/line_detail_list"));
                }  else {//只添加系统语言时
                    $detail_language->detail_id = $detail->primaryKey;
                    $detail_language->iso = Yii::app()->params['language'];
                    $detail_language->title = $_POST['title'];
                    $detail_language->content =  $describe;
                    $detail_language->img_url = $photo_url;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Line/line_detail_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT * FROM vcos_line a LEFT JOIN vcos_line_language b ON a.line_id = b.line_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
        $line = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('line_detail_add',array('line'=>$line,'detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionLine_detail_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $detail = VcosLineDetail::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_line_detail a LEFT JOIN vcos_line_detail_language b ON a.detail_id = b.detail_id WHERE a.detail_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $detail_language = VcosLineDetailLanguage::model()->findByPk($id2['id']);
        if($_POST){
        	$photo='';
        	$photo_iso='';
        	if($_FILES['photo']['error']!=4){
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'line_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		if($_FILES['photo_iso']['error']!=4){
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'line_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
        	if($photo_iso != ''){//判断有无上传图片
        		$photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
        	}
        	if($photo != ''){//判断有无上传图片
        		$photo_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
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
                    $db->createCommand()->update('vcos_line_detail',array('line_id'=>$_POST['line'],'sequence'=>$_POST['sequence'],'detail_state'=>$state),'detail_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $port_columns = array('title'=>$_POST['title'],'content'=>$describe);
                    if($photo){//判断有无上传图片
                    	$port_columns['img_url'] = 'line_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_line_detail_language',$port_columns , 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_line_detail_language',array('detail_id'=>$id,'img_url'=>$photo_iso_url,'iso'=>$_POST['language'],'title'=>$_POST['title_iso'],'content'=>$describe_iso));
                    }  else {
                        //编辑外语
                    	$columns = array('title'=>$_POST['title_iso'],'content'=>$describe_iso);
                    	if($photo_iso != ''){//判断有无上传图片
                    		$columns['img_url'] = 'line_images/'.Yii::app()->params['month'].'/'.$photo_iso;
                    	}
                        $db->createCommand()->update('vcos_line_detail_language', $columns, 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Line/line_detail_list"));
                }  else {//只编辑系统语言
                    $detail->detail_id = $id;
                    $detail->line_id = $_POST['line'];
                    $detail->sequence = $_POST['sequence'];
                    $detail->detail_state = $state;
                    $detail->save();
                    $detail_language->id = $id2['id'];
                    $detail_language->title = $_POST['title'];
                    if($photo){//判断有无上传图片
                    	$detail_language->img_url = 'line_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $detail_language->content =  $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Line/line_detail_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            } 
        }
        $sql = "SELECT * FROM vcos_line a LEFT JOIN vcos_line_language b ON a.line_id = b.line_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
        $line = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('line_detail_edit',array('line'=>$line,'detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionGetiso_detail()
    {
        $sql = "SELECT b.id, b.title, b.content,b.img_url FROM vcos_line_detail a LEFT JOIN vcos_line_detail_language b ON a.detail_id = b.detail_id WHERE a.detail_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
     public function actionCheckline()
    {
        $result = VcosLineDetail::model()->count('line_id=:num',array(':num'=>$_POST['lid']));
        if($result>0){
            echo 1;
        }
    }
	
}