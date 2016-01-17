<?php

class LifeserviceController extends Controller
{
    public function actionService_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        
        $where = 1;
        $res_but = 0;
      
        if(isset($_GET['category']) && $_GET['category'] != ''){
        	if($_GET['category'] == 0){
        		$where = 1;
        		$res_but = 0;
        	}else{
        		$where = "a.ls_category = ".$_GET['category'];
        		$res_but = $_GET['category'];
        	}
        }
    	
        //批量删除
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosLifeservice::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count = VcosLifeservice::model()->deleteAll("ls_id in('$ids')");
                $count2 = VcosLifeserviceLanguage::model()->deleteAll("ls_id in('$ids')");
                $count3 = VcosLifeserviceImg::model()->deleteAll("lifeservice_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Lifeservice/Service_list"));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosLifeservice::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosLifeservice::model()->deleteByPk($did);
                $count2 = VcosLifeserviceLanguage::model()->deleteAll("ls_id in('$did')");
                $count3 = VcosLifeserviceImg::model()->deleteAll("lifeservice_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Lifeservice/Service_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_lifeservice a, vcos_lifeservice_language b, vcos_lifeservice_category c, vcos_lifeservice_category_language d WHERE a.ls_id = b.ls_id AND a.ls_category = c.lc_id AND a.ls_category = d.lc_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' AND ".$where." ORDER BY a.ls_id DESC ";
        $count = $db->createCommand($count_sql)->queryRow();
        
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT a.lc_id,b.lc_name FROM `vcos_lifeservice_category` a LEFT JOIN `vcos_lifeservice_category_language` b ON a.lc_id = b.lc_id WHERE a.lc_state = '1' AND b.iso = '".Yii::app()->language."'";
        $category_sel = $db->createCommand($sql)->queryAll(); 
        $sql = "SELECT * FROM vcos_lifeservice a, vcos_lifeservice_language b, vcos_lifeservice_category c, vcos_lifeservice_category_language d WHERE a.ls_id = b.ls_id AND a.ls_category = c.lc_id AND a.ls_category = d.lc_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' AND ".$where." AND c.lc_state=1 ORDER BY a.ls_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $lifeservice = $db->createCommand($sql)->queryAll();
        $this->render('index',array('res_but'=>$res_but,'category_sel'=>$category_sel,'pages'=>$pager,'auth'=>$this->auth,'lifeservice'=>$lifeservice));
    }
        
    public function actionService_add()
    {
        $this->setauth();//检查有无权限
        $ls = new VcosLifeservice();
        $ls_language = new VcosLifeserviceLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'lifeservice_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $ls->ls_price = $_POST['price']*100;
            $ls->ls_tel = $_POST['tel'];
            $ls->ls_category = $_POST['type'];
            $ls->ls_state = $state;
            $ls->ls_img_url = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
            //匹配替换编辑器中图片路径
            $msg = $_POST['contents'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['contents_iso'] != ''){
            	$msg_iso = $_POST['contents_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $ls->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_lifeservice_language` (`ls_id`, `iso`, `ls_title`, `ls_desc`,`ls_info`, `ls_address`, `ls_opening_time`) VALUES ('{$ls->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}','{$_POST['desc']}', '{$describe}', '{$_POST['address']}', '{$_POST['time']}'), ('{$ls->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}','{$_POST['desc_iso']}', '{$describe_iso}', '{$_POST['address_iso']}', '{$_POST['time_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Lifeservice/Service_list"));
                }  else {//只添加系统语言时
                    $ls_language->ls_id = $ls->primaryKey;
                    $ls_language->iso = Yii::app()->params['language'];
                    $ls_language->ls_title = $_POST['title'];
                    $ls_language->ls_desc = $_POST['desc'];
                    $ls_language->ls_address = $_POST['address'];
                    $ls_language->ls_opening_time = $_POST['time'];
                    $ls_language->ls_info = $describe;
                    $ls_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Lifeservice/Service_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT * FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE a.lc_state = '1' AND b.iso = '".Yii::app()->language."'";
        $lifeservice_category = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('add',array('lifeservice_category'=>$lifeservice_category,'ls'=>$ls,'ls_language'=>$ls_language));
    }
        
    public function actionService_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $ls= VcosLifeservice::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON a.ls_id = b.ls_id WHERE a.ls_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $ls_language = VcosLifeserviceLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',  Yii::app()->params['img_save_url'].'lifeservice_images/'.Yii::app()->params['month'], 'image', 3);
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
                    $columns = array('ls_price'=>($_POST['price']*100),'ls_state'=>$state,'ls_category'=>$_POST['type'],'ls_tel'=>$_POST['tel']);
                    if($photo){//判断有无上传图片
                        $columns['ls_img_url'] = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_lifeservice',$columns,'ls_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_lifeservice_language', array('ls_title'=>$_POST['title'],'ls_desc'=>$_POST['desc'],'ls_info'=>$describe,'ls_address'=>$_POST['address'],'ls_opening_time'=>$_POST['time']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_lifeservice_language',array('ls_id'=>$id,'iso'=>$_POST['language'],'ls_title'=>$_POST['title_iso'],'ls_desc'=>$_POST['desc_iso'],'ls_info'=>$describe_iso,'ls_address'=>$_POST['address_iso'],'ls_opening_time'=>$_POST['time_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_lifeservice_language', array('ls_title'=>$_POST['title_iso'],'ls_desc'=>$_POST['desc_iso'],'ls_info'=>$describe_iso,'ls_address'=>$_POST['address_iso'],'ls_opening_time'=>$_POST['time_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Lifeservice/Service_list"));
                }  else {//只编辑系统语言
                    $ls->ls_id = $id;
                    $ls->ls_price = $_POST['price']*100;
                    $ls->ls_category = $_POST['type'];
                    $ls->ls_state = $state;
                    $ls->ls_tel = $_POST['tel'];
                    if($photo){
                        $ls->ls_img_url = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $ls->save();
                    $ls_language->id = $id2['id'];
                    $ls_language->ls_title = $_POST['title'];
                    $ls_language->ls_desc = $_POST['desc'];
                    $ls_language->ls_address = $_POST['address'];
                    $ls_language->ls_opening_time = $_POST['time'];
                    $ls_language->ls_info = $describe;
                    $ls_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Lifeservice/Service_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $sql = "SELECT * FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE a.lc_state = '1' AND b.iso = '".Yii::app()->language."'";
        $lifeservice_category = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('edit',array('ls'=>$ls,'lifeservice_category'=>$lifeservice_category,'ls_language'=>$ls_language));
    }
    
    public function actionGetiso_ls()
    {
        $sql = "SELECT b.id, b.ls_title,b.ls_desc, b.ls_info, b.ls_address, b.ls_opening_time FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON a.ls_id = b.ls_id WHERE a.ls_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }

    public function actionService_category()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //单条删除
        if(isset($_GET['id'])){
        	
        	$result = VcosLifeserviceCategory::model()->count();
        	$count_sql = "select count(*) count from `vcos_lifeservice` WHERE ls_category =" .$_GET['id'];
        	$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        	if($result<=1){
        		die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
        	}else if($count_category['count'] > 0){
            	die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
            }
        	$did=$_GET['id'];
        	//事务处理
        	$transaction=$db->beginTransaction();
        	try{
        		$count=VcosLifeserviceCategory::model()->deleteByPk($did);
        		$count2 = VcosLifeserviceCategoryLanguage::model()->deleteAll("lc_id in('$did')");
        		$transaction->commit();
        		Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Lifeservice/Service_category"));
        	}catch(Exception $e){
        		$transaction->rollBack();
        		Helper::show_message(yii::t('vcos', '删除失败。'));
        	}
        }
        if($_POST){
        	$a = count($_POST['ids']);
        	$ids=implode('\',\'', $_POST['ids']);
        	$result = VcosLifeserviceCategory::model()->count();
        	$count_sql = "select count(*) count from `vcos_lifeservice` WHERE ls_category in ('$ids')";
        	$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        	if($a == $result){
        		die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
        	}else if($count_category['count'] > 0){
            	die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
            }
        	
        	//事务处理
        	$transaction=$db->beginTransaction();
        	try{
        		$count=VcosLifeserviceCategory::model()->deleteAll("lc_id in('$ids')");
        		$count2 = VcosLifeserviceCategoryLanguage::model()->deleteAll("lc_id in('$ids')");
        		$transaction->commit();
        		Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Lifeservice/Service_category"));
        	}catch(Exception $e){
        		$transaction->rollBack();
        		Helper::show_message(yii::t('vcos', '删除失败。'));
        	}
        }
        $sql = "SELECT * FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE b.iso = '".Yii::app()->language."'";
        $lifeservice_category = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('category',array('lifeservice_category'=>$lifeservice_category,'auth'=>$this->auth));
    }
        
    public function actionService_categoryedit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $lc = VcosLifeserviceCategory::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE a.lc_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $lc_language = VcosLifeserviceCategoryLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',  Yii::app()->params['img_save_url'].'lifeservice_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            
            if($state == '0'){
                //$result = VcosLifeservice::model()->count('ls_category=:id',array(':id'=>$id));
                $sql = "SELECT count(*) count FROM vcos_lifeservice WHERE ls_state = 1 AND ls_category =".$id;
                $count = Yii::app()->m_db->createCommand($sql)->queryRow();
                if($count['count']>0){
                    die(Helper::show_message(yii::t('vcos', '此分类正在使用,不能禁用。')));
                }
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('lc_state'=>$state,'bg_color'=>$_POST['bgcolor']);
                    if($photo){//判断有无上传图片
                        $columns['lc_img_url'] = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_lifeservice_category',$columns,'lc_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_lifeservice_category_language', array('lc_name'=>$_POST['title']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_lifeservice_category_language',array('lc_id'=>$id,'iso'=>$_POST['language'],'lc_name'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_lifeservice_category_language', array('lc_name'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Lifeservice/Service_category"));
                }  else {//只编辑系统语言
                    $lc->lc_id = $id;
                    $lc->bg_color = $_POST['bgcolor'];
                    $lc->lc_state = $state;
                    if($photo){
                        $lc->lc_img_url = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $lc->save();
                    $lc_language->id = $id2['id'];
                    $lc_language->lc_name = $_POST['title'];
                    $lc_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Lifeservice/Service_category"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $this->render('categoryedit',array('lifeservice_category'=>$lc,'lc_language'=>$lc_language));
    }
    
    public function actionGetiso_lc()
    {
        $sql = "SELECT b.id, b.lc_name FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE a.lc_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionService_booking_list()
    {
        $this->setauth();//检查有无权限
        $count_sql = "SELECT count(*) count FROM vcos_lifeservice_booking ORDER BY create_time DESC ";
        $count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria); 
        $sql = "SELECT * FROM vcos_lifeservice_booking ORDER BY create_time DESC LIMIT {$criteria->offset}, 10";
        $result = Yii::app()->m_db->createCommand($sql)->queryAll();
        foreach ($result as $key=>$row){
            $sql = "SELECT cn_name FROM vcos_member WHERE member_id = {$row['membership_id']}";
            $result[$key]['cn_name'] = Yii::app()->db->createCommand($sql)->queryRow();
        }
        $this->render('service_booking_list',array('pages'=>$pager,'result'=>$result));
    }
    
    public function actionService_booking_edit()
    {
        $this->setauth();//检查有无权限
        $id = $_GET['id'];
        $detail = VcosLifeserviceBooking::model()->findByPk($id);
        if($_POST){
            if($_POST['num']!=''&&$_POST['remark']!=''){
                $detail->id = $id;
                $detail->booking_num = $_POST['num'];
                $detail->remark = $_POST['remark'];
                $detail->state = $_POST['state'];
                $detail->is_read = '1';
                if($detail->save()>0){
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Lifeservice/service_booking_list"));
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败。'));
                }
            }else{
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $sql = "SELECT cn_name FROM vcos_member WHERE member_id = {$detail->membership_id}";
        $user = Yii::app()->db->createCommand($sql)->queryRow();
        $this->render('service_booking_edit',array('detail'=>$detail,'user'=>$user));
    }
    
    public function actionChangestate()
    {
        $state = VcosLifeserviceBooking::model()->findByPk($_POST['id']);
        $state->id = $_POST['id'];
        $state->state = $_POST['state'];
        $state->is_read = 1;
        if($state->save()>0){
            echo '1';
        }  else {
            echo '0';
        }
    }

    public function actionChecknameajax()
    {
        $sql = "SELECT * FROM vcos_lifeservice WHERE ls_title = '{$_POST['title']}'";
        $name = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($name){
            echo "false";
        }else{
            echo "true";
        }
    }
    
    /**添加休闲服务图片***/
    public function actionService_img_add(){
    	$this->setauth();//检查有无权限
    	$lifeservice_img = new VcosLifeserviceImg();
    	if($_POST){
    		$val = '';
    		$iso = '';
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		$file_img = trim($_POST['file_img'],',');
    		$file_img = explode(",",$file_img);
    		if(isset($_POST['language']) && $_POST['language'] != ''){
    			$iso = $_POST['language'];
    		}else{
    			$iso = Yii::app()->language;
    		}
    		foreach ($file_img as $row){
    			/*$path_arr = explode("/",$row);
    			$path_arr = array_slice($path_arr, -3, 3);
    			$row = $path_arr[0].'/'.$path_arr[1].'/' . $path_arr[2];*/
    			$row = explode('=', $row);
    			$row = $row[1];
    			$val .= "('{$_POST['life_category']}','{$row}','{$iso}','{$state}'),";
    		}
    		$val = trim($val,',');
    		
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			$sql = "INSERT INTO `vcos_lifeservice_img` (`lifeservice_id`, `img_url`, `iso`, `state`) VALUES " .$val;
    			$db->createCommand($sql)->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Lifeservice/Service_img_list"));
    			 
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
    		}
    		 
    	}
    	 
    	$life_sql = "SELECT a.lc_id,b.lc_name FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE b.iso = '".Yii::app()->language."' AND a.lc_state = '1'";
    	$lifeservice_sel = Yii::app()->m_db->createCommand($life_sql)->queryAll();
    	$sql = "SELECT a.ls_id,b.ls_title FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON  a.ls_id = b.ls_id WHERE a.ls_state = '1' AND b.iso = '".Yii::app()->language."' AND a.ls_category = ". $lifeservice_sel[0]['lc_id'];
    	$life_title_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('service_img_add',array('life_title_sel'=>$life_title_sel,'lifeservice_sel'=>$lifeservice_sel,'lifeservice_img'=>$lifeservice_img));
    }
    
    
    /**根据休闲分类获取子标题**/
    public function actionCategoryGetLifeservice(){
    	$title = isset($_GET['title'])?$_GET['title']:'';
    	if(!empty($title)){
    		$sql = "SELECT a.ls_id,b.ls_title FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON a.ls_id = b.ls_id WHERE (a.ls_state = '1' OR a.ls_id={$title}) AND b.iso = '".Yii::app()->language."' AND a.ls_category = {$_GET['lifeservice']}" ;
    	}else{
    		$sql = "SELECT a.ls_id,b.ls_title FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON a.ls_id = b.ls_id WHERE a.ls_state = '1'  AND b.iso = '".Yii::app()->language."' AND a.ls_category = {$_GET['lifeservice']}" ;
    	}
    	$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	echo json_encode($category_sel);
    }
    
    /**休闲服务图片列表***/
    public function actionService_img_list(){
    	$this->setauth();//检查有无权限
    	 
    	$db = Yii::app()->m_db;
    	$where = 1;
    	$res_but = 0;
    	$res = 'all';
    	$la_where = 1;
    	$life_but = 0;
    	$life_where = 1;
    	$life_sel = '';
    	if(isset($_GET['lifeservice']) && $_GET['lifeservice'] != ''){
    		if($_GET['lifeservice'] == 0){
    			$where = 1;
    			$res_but = 0;
    			$life_but = 0;
    		}else{
    			$where = "b.ls_category = ".$_GET['lifeservice'];
    			$life_but = 0;
    			$res_but = $_GET['lifeservice'];
    			$life_sql = "SELECT a.ls_id,b.ls_title FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON a.ls_id = b.ls_id WHERE a.ls_state = '1'  AND b.iso = '".Yii::app()->language."' AND a.ls_category = {$_GET['lifeservice']}";
    			$life_sel = Yii::app()->m_db->createCommand($life_sql)->queryAll();
    		}
    	}
    	if(isset($_GET['life']) && $_GET['life'] != ''){
    		if($_GET['life'] == 0){
    			$life_where = 1;
    			$life_but = 0;
    		}else{
    			$life_where = "a.lifeservice_id = ".$_GET['life'];
    			$life_but = $_GET['life'];
    		}
    	}
    	if(isset($_GET['res']) && $_GET['res'] != ''){
    		if($_GET['res'] == 'all'){
    			$la_where = 1; 
    			$res = 'all';
    		}elseif($_GET['res'] == 'zh_cn'){
    			$la_where = "a.iso = 'zh_cn'";
    			$res = 'zh_cn';
    		}elseif($_GET['res'] == 'en'){
    			$la_where = "a.iso = 'en'";
    			$res = 'en';
    		}
    	}
    	/*
    	if(isset($_GET['res']) && $_GET['res'] != '' && isset($_GET['lifeservice']) && $_GET['lifeservice'] != ''){
    		$res_where = $where .' AND ' .$la_where;
    	}elseif (isset($_GET['res']) && $_GET['res'] != '' && !isset($_GET['lifeservice'])){
    		$res_where = $la_where;
    	}elseif (isset($_GET['lifeservice']) && $_GET['lifeservice'] != '' && !isset($_GET['res'])){
    		$res_where = $where;
    	}else{
    		$res_where = 1;
    	}*/
    	//批量删除
    	if($_POST){
    		
    		$a = count($_POST['ids']);
    		$result = VcosLifeserviceImg::model()->count();
    		if($a == $result){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		$ids=implode('\',\'', $_POST['ids']);
    		//事务处理
    		$transaction=$db->beginTransaction();
    		try{
    			$count = VcosLifeserviceImg::model()->deleteAll("id in('$ids')");
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Lifeservice/Service_img_list"));
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	//单条删除
    	if(isset($_GET['id'])){
    		$result = VcosLifeserviceImg::model()->count();
    		if($result<=1){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		$did=$_GET['id'];
    		//事务处理
    		$transaction2=$db->beginTransaction();
    		try{
    			$count=VcosLifeserviceImg::model()->deleteByPk($did);
    			$transaction2->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Lifeservice/Service_img_list"));
    		}catch(Exception $e){
    			$transaction2->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    		
    	}
    	$count_sql = "SELECT count(*) count FROM `vcos_lifeservice_img` a
		LEFT JOIN `vcos_lifeservice` b ON a.lifeservice_id = b.ls_id
		LEFT JOIN (SELECT * FROM `vcos_lifeservice_category_language` c WHERE c.iso='".Yii::app()->language."') c ON c.lc_id = b.ls_category
		LEFT JOIN (SELECT * FROM `vcos_lifeservice_language` d WHERE d.iso = '".Yii::app()->language."') d ON d.ls_id = a.lifeservice_id Where ".$where." AND ".$la_where." AND ".$life_where." ORDER BY b.ls_category";
    	$count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    	//分页
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$life_sql = "SELECT a.lc_id,b.lc_name FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE b.iso = '".Yii::app()->language."' AND a.lc_state = '1'";
    	$lifeservice_sel = Yii::app()->m_db->createCommand($life_sql)->queryAll();
    	/*
    	$sql = "SELECT  FROM `vcos_lifeservice` a LEFT JOIN `vcos_lifeservice_language` b ON a.ls_id = b.ls_id WHERE a.ls_state = '1' AND b.iso = '".Yii::app()->language."' AND a.ls_category = ".$lifeservice_sel[0]['lc_id'];
    	$life_sel = Yii::app()->m_db->createCommand($sql)->queryAll();*/
    	$sql = "SELECT a.*,b.ls_category,c.lc_name,d.ls_title FROM `vcos_lifeservice_img` a
		LEFT JOIN `vcos_lifeservice` b ON a.lifeservice_id = b.ls_id
		LEFT JOIN (SELECT * FROM `vcos_lifeservice_category_language` c WHERE c.iso='".Yii::app()->language."') c ON c.lc_id = b.ls_category
		LEFT JOIN (SELECT * FROM `vcos_lifeservice_language` d WHERE d.iso = '".Yii::app()->language."') d ON d.ls_id = a.lifeservice_id Where ".$where." AND ".$la_where." AND ".$life_where." ORDER BY b.ls_category LIMIT {$criteria->offset}, {$pager->pageSize}";
    	$lifeservice = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('service_img_list',array('life_sel'=>$life_sel,'life_but'=>$life_but,'res'=>$res,'pages'=>$pager,'lifeservice_sel'=>$lifeservice_sel,'res_but'=>$res_but,'auth'=>$this->auth,'lifeservice'=>$lifeservice));
    }
    
    /**编辑休闲服务图片**/
    public function actionService_img_edit(){
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$lifeservice_img = VcosLifeserviceImg::model()->findByPk($id);
    	$sql = "SELECT ls_category FROM `vcos_lifeservice` WHERE ls_id = ".$lifeservice_img['lifeservice_id'];
    	$lifeservice_category = Yii::app()->m_db->createCommand($sql)->queryRow();

    	if($_POST){
    	
    	 	$photo='';
    		if($_FILES['photo']['error']!=4){
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'lifeservice_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		$iso = isset($_POST['language'])?$_POST['language']:'zh_cn';
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			$lifeservice_img->id = $id;
    			$lifeservice_img->lifeservice_id = $_POST['life_category'];
    			$lifeservice_img->state = $state;
    			$lifeservice_img->iso = $iso;
    			if($photo){
    				$lifeservice_img->img_url = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
    			}
    			$lifeservice_img->save();
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Lifeservice/Service_img_list"));
    			 
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '修改失败。'), '#');
    		}
    	}
    	$life_sql = "SELECT a.lc_id,b.lc_name FROM vcos_lifeservice_category a LEFT JOIN vcos_lifeservice_category_language b ON a.lc_id = b.lc_id WHERE b.iso = '".Yii::app()->language."' AND a.lc_state = '1'";
    	$lifeservice_sel = Yii::app()->m_db->createCommand($life_sql)->queryAll();
    	$sql = "SELECT a.ls_id,b.ls_title FROM vcos_lifeservice a LEFT JOIN vcos_lifeservice_language b ON  a.ls_id = b.ls_id WHERE (a.ls_state = '1' OR a.ls_id={$lifeservice_img['lifeservice_id']}) AND b.iso = '".Yii::app()->language."' AND a.ls_category = ". $lifeservice_category['ls_category'];
    	$life_title_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('service_img_edit',array('life_title_sel'=>$life_title_sel,'lifeservice_sel'=>$lifeservice_sel,'lifeservice_img'=>$lifeservice_img,'lifeservice_category'=>$lifeservice_category['ls_category']));
    	
    }
}