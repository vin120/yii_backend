<?php  

class CruiseinfoController extends Controller 
{
	public function actionPort()
	{
		$this->setauth();
		$db = Yii::app()->m_db;
		if(isset($_GET['id']))
		{
			$result = VcosPort::model()->count();
			if($result <= 1)
			{
				die(Helper::show_message(Yii::t('vcos','不能把所有记录删除！')));
			}
			$did = $_GET['id'];

			$transaction  = $db->beginTransaction();
			try
			{
				$count = VcosPort::model()->deleteByPk($did);
				$count2 =VcosPortLanguage::model()->deleteAll("port_id in ('$did')");
				$transaction->commit();
				Helper::show_message(Yii::t('vcos','删除成功。'),Yii::app()->createUrl("Cruiseinfo/port"));			
			}
			catch(Exception $e)
			{
				$transaction->rollBack();
				Helper::show_message(Yii::t('vcos','删除失败。'));
			}
		}

		$count_sql = "SELECT count(*) count FROM vcos_port a LEFT JOIN vcos_port_language b ON a.port_id = b.port_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.port_id DESC";
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize = 0;
		$pager->applyLimit($criteria);
		$sql = "SELECT * FROM vcos_port a LEFT JOIN vcos_port_language b ON a.port_id = b.port_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.port_id DESC LIMIT {$criteria->offset} ,{$pager->pageSize}";
		$port = $db->createCommand($sql)->queryAll();
		$this->render('port',array('pages'=>$pager,'auth'=>$this->auth,'port'=>$port));
	}

	public function actionPort_add()
    {
        $this->setauth();//检查有无权限
        $port = new VcosPort();
        $port_language = new VcosPortLanguage();
        if($_POST)
        {
        	$photo='';
        	if($_FILES['photo']['error']!=4)
        	{
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	$photo_iso = '';
        	if(isset($_POST['language']) && $_POST['language'] != '')
        	{
        		if($_FILES['photo_iso']['error']!=4)
        		{
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $port->port_state = $state;
            
            $photo_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
            $photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
            
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try
            {
                $port->save();
                if(isset($_POST['language']) && $_POST['language'] != '')
                {//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_port_language` (`port_id`, `iso`, `port_name`,`img_url`,`describe`) VALUES ('{$port->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}','{$photo_url}','{$_POST['desc']}'), ('{$port->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}','{$photo_iso_url}','{$_POST['desc_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/port"));
                }  
                else 
                {//只添加系统语言时
                    $port_language->port_id = $port->primaryKey;
                    $port_language->iso = Yii::app()->params['language'];
                    $port_language->port_name = $_POST['title'];
                    $port_language->img_url = $photo_url;
                    $port_language->describe = $_POST['desc'];
                    $port_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/port"));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('port_add',array('port'=>$port,'port_language'=>$port_language));
    }
   public function actionPort_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $port= VcosPort::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_port a LEFT JOIN vcos_port_language b ON a.port_id = b.port_id WHERE a.port_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $port_language = VcosPortLanguage::model()->findByPk($id2['id']);
        if($_POST)
        {
        	$photo='';
        	$photo_iso='';
        	if($_FILES['photo']['error']!=4)
        	{
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	if(isset($_POST['language']) && $_POST['language'] != '')
        	{
        		if($_FILES['photo_iso']['error']!=4)
        		{
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            
            if($photo_iso != '')
            {
            	//判断有无上传图片
            	$photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
            }
            if($photo != '')
            {
            	//判断有无上传图片
            	$photo_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try
            {
                if(isset($_POST['language']) && $_POST['language'] != '')
                {
                	//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_port',array('port_state'=>$state),'port_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $port_columns = array('port_name'=>$_POST['title'],'describe'=>$_POST['desc']);
                    if($photo)
                    {
                    	//判断有无上传图片
                    	$port_columns['img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    //编辑系统语言
                    $db->createCommand()->update('vcos_port_language', $port_columns, 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add')
                    {
                        //新增外语
                        $db->createCommand()->insert('vcos_port_language',array('port_id'=>$id,'iso'=>$_POST['language'],'port_name'=>$_POST['title_iso'],'img_url'=>$photo_iso_url,'describe'=>$_POST['desc_iso']));
                    }  
                    else 
                    {
                        //编辑外语
                    	$columns = array('port_name'=>$_POST['title_iso'],'describe'=>$_POST['desc_iso']);
                    	if($photo_iso != '')
                    	{
                    		//判断有无上传图片
                    		$columns['img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
                    	}
                        $db->createCommand()->update('vcos_port_language',$columns , 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/port"));
                }  else {//只编辑系统语言状态下
                    $port->port_id = $id;
                    $port->port_state = $state;
                    $port->save();
                    $port_language->id = $id2['id'];
                    $port_language->port_name = $_POST['title'];
                    $port_language->describe = $_POST['desc'];
                    if($photo){//判断有无上传图片
                    	$port_language->img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    //$port_language->img_url = $photo_url;
                    $port_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/port"));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
            }         
        }
        $this->render('port_edit',array('port'=>$port,'port_language'=>$port_language));
    }

     /**查看港口名是否已经存在**/
    public function actionPortNamegetAgain()
    {
    	$port_name = $_POST['title'];
    	$this_id = isset($_POST['this_id'])?$_POST['this_id']:0;
    	if($this_id != 0)
    	{
    		$sql = "SELECT count(*) count FROM `vcos_port_language` WHERE port_name='{$port_name}' AND iso='zh_cn' AND port_id !=".$this_id;
    	}
    	else
    	{
    		$sql = "SELECT count(*) count FROM `vcos_port_language` WHERE port_name='{$port_name}' AND iso='zh_cn'";
    	}
    	
    	$count = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($count['count'])
    	{
            echo 1;
        }  
        else 
        {
            echo 0;
        }
    	
    }

    public function actionGetiso_port()
    {
        $sql = "SELECT b.id, b.port_name,b.describe FROM vcos_port a LEFT JOIN vcos_port_language b ON a.port_id = b.port_id WHERE a.port_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso)
        {
            echo json_encode($iso);
        }  
        else 
        {
            echo 0;
        }
    }

    public function actionPort_detail_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //批量删除
        if($_POST)
        {
            $a = count($_POST['ids']);
            $result = VcosPortDetail::model()->count();
            if($a == $result)
            {
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try
            {
                $count=VcosPortDetail::model()->deleteAll("detail_id in('$ids')");
                $count2 = VcosPortDetailLanguage::model()->deleteAll("detail_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/port_detail_list"));
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id']))
        {
            $result = VcosPortDetail::model()->count();
            if($result<=1)
            {
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try
            {
                $count=VcosPortDetail::model()->deleteByPk($did);
                $count2 = VcosPortDetailLanguage::model()->deleteAll("detail_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/port_detail_list"));
            }
            catch(Exception $e)
            {
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_port_detail a, vcos_port_detail_language b, vcos_port c, vcos_port_language d WHERE a.detail_id = b.detail_id AND a.port_id = c.port_id AND a.port_id = d.port_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.detail_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_port_detail a, vcos_port_detail_language b, vcos_port c, vcos_port_language d WHERE a.detail_id = b.detail_id AND a.port_id = c.port_id AND a.port_id = d.port_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.detail_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $detail = $db->createCommand($sql)->queryAll();
        $this->render('port_detail_list',array('pages'=>$pager,'auth'=>$this->auth,'detail'=>$detail));  
    }
    
    public function actionPort_detail_add()
    {
        $this->setauth();//检查有无权限
        $detail = new VcosPortDetail();
        $detail_language = new VcosPortDetailLanguage(); 
        if($_POST)
        {
            $photo='';
            if($_FILES['photo']['error']!=4)
            {
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $detail->port_id = $_POST['port'];
            $detail->detail_state = $state;
            $detail->detail_img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != '')
            {
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try
            {
                $detail->save();
                if(isset($_POST['language']) && $_POST['language'] != '')
                {
                	//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_port_detail_language` (`detail_id`, `iso`, `detail`) VALUES ('{$detail->primaryKey}', '".Yii::app()->params['language']."', '{$describe}'), ('{$detail->primaryKey}', '{$_POST['language']}', '{$describe_iso}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/port_detail_list"));
                }  
                else 
                {
                	//只添加系统语言时
                    $detail_language->detail_id = $detail->primaryKey;
                    $detail_language->iso = Yii::app()->params['language'];
                    $detail_language->detail = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/port_detail_list"));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT * FROM vcos_port a LEFT JOIN vcos_port_language b ON a.port_id = b.port_id WHERE a.port_state = '1' AND b.iso = '".Yii::app()->language."'";
        $port = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('port_detail_add',array('port'=>$port,'detail'=>$detail, 'detail_language'=>$detail_language));
    }
    
    public function actionPort_detail_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $detail= VcosPortDetail::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_port_detail a LEFT JOIN vcos_port_detail_language b ON a.detail_id = b.detail_id WHERE a.detail_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $detail_language = VcosPortDetailLanguage::model()->findByPk($id2['id']);
        if($_POST)
        {
            $photo='';
            if($_FILES['photo']['error']!=4)
            {
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != '')
            {
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try
            {
                if(isset($_POST['language']) && $_POST['language'] != '')
                {
                	//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('port_id'=>$_POST['port'],'detail_state'=>$state);
                    if($photo)
                    {
                    	//判断有无上传图片
                        $columns['detail_img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_port_detail',$columns,'detail_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_port_detail_language', array('detail'=>$describe), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add')
                    {
                        //新增外语
                        $db->createCommand()->insert('vcos_port_detail_language',array('detail_id'=>$id,'iso'=>$_POST['language'],'detail'=>$describe_iso));
                    }  
                    else 
                    {
                        //编辑外语
                        $db->createCommand()->update('vcos_port_detail_language', array('detail'=>$describe_iso), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/port_detail_list"));
                }  
                else 
                {
                	//只编辑系统语言
                    $detail->detail_id = $id;
                    $detail->port_id = $_POST['port'];
                    $detail->detail_state = $state;
                    //$detail->detail_img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    if($photo)
                    {
                    	//判断有无上传图片
                    	$detail->detail_img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $detail->save();
                    $detail_language->id = $id2['id'];
                    $detail_language->detail = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/port_detail_list"));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $sql = "SELECT * FROM vcos_port a LEFT JOIN vcos_port_language b ON a.port_id = b.port_id WHERE a.port_state = '1' AND b.iso = '".Yii::app()->language."'";
        $port = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('port_detail_edit',array('port'=>$port,'detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    /**判断甲板名称是否存在**/
    public function actionDeckGetAgain()
    {
    	$deck_name = $_POST['title'];
    	$this_id = isset($_POST['this_id'])?$_POST['this_id']:0;
    	 
    	if($this_id != 0)
    	{
    		$sql = "SELECT count(*) count FROM `vcos_cruise_deck_language` WHERE deck_name='{$deck_name}' AND iso='zh_cn' AND deck_id !=".$this_id;
    	}
    	else
    	{
    		$sql = "SELECT count(*) count FROM `vcos_cruise_deck_language` WHERE deck_name='{$deck_name}' AND iso='zh_cn'";
    	}
    	 
    	$count = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($count['count'])
    	{
    		echo 1;
    	}  
    	else 
    	{
    		echo 0;
    	}
    }
    
    public function actionGetiso_portdetail()
    {
        $sql = "SELECT b.id, b.detail FROM vcos_port_detail a LEFT JOIN vcos_port_detail_language b ON a.detail_id = b.detail_id WHERE a.detail_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso)
        {
            echo json_encode($iso);
        }  
        else 
        {
            echo 0;
        }
    }
    
    public function actionCruiseinfo_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //批量删除
        if($_POST)
        {
            $a = count($_POST['ids']);
            $result = VcosCruiseInfo::model()->count();
            if($a == $result)
            {
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try
            {
                $count=VcosCruiseInfo::model()->deleteAll("info_id in('$ids')");
                $count2 = VcosCruiseInfoLanguage::model()->deleteAll("info_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/cruiseinfo_list")); 
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id']))
        {
            $result = VcosCruiseInfo::model()->count();
            if($result<=1)
            {
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try
            {
                $count=VcosCruiseInfo::model()->deleteByPk($did);
                $count2 = VcosCruiseInfoLanguage::model()->deleteAll("info_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/cruiseinfo_list"));    
            }
            catch(Exception $e)
            {
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_cruise_info a LEFT JOIN vcos_cruise_info_language b ON a.info_id = b.info_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.info_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_cruise_info a LEFT JOIN vcos_cruise_info_language b ON a.info_id = b.info_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.info_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $detail = $db->createCommand($sql)->queryAll();
        //渲染页面
        $this->render('cruiseinfo_list',array('pages'=>$pager,'auth'=>$this->auth,'detail'=>$detail));
    }
    
    public function actionCruiseinfo_add()
    {
        $this->setauth();//检查有无权限
        $detail = new VcosCruiseInfo();
        $detail_language = new VcosCruiseInfoLanguage();
        if($_POST)
        {
            $photo='';
            if($_FILES['photo']['error']!=4)
            {
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != '')
            {
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            
            //$detail->cruise_info = $_POST['describe'];
            $detail->state = $state;
            $detail->cruise_img = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try
            {
                $detail->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_cruise_info_language` (`info_id`, `iso`, `cruise_info`) VALUES ('{$detail->primaryKey}', '".Yii::app()->params['language']."', '{$describe}'), ('{$detail->primaryKey}', '{$_POST['language']}', '{$describe_iso}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/cruiseinfo_list"));
                }  
                else 
                {
                	//只添加系统语言时
                    $detail_language->info_id = $detail->primaryKey;
                    $detail_language->iso = Yii::app()->params['language'];
                    $detail_language->cruise_info = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/cruiseinfo_list"));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('cruiseinfo_add',array('detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionCruiseinfo_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $detail= VcosCruiseInfo::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_cruise_info a LEFT JOIN vcos_cruise_info_language b ON a.info_id = b.info_id WHERE a.info_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $detail_language = VcosCruiseInfoLanguage::model()->findByPk($id2['id']);
        if($_POST)
        {
            $photo='';
            if($_FILES['photo']['error']!=4)
            {
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != '')
            {
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != '')
                {
                	//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('state'=>$state);
                    if($photo)
                    {
                    	//判断有无上传图片
                        $columns['cruise_img'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_cruise_info',$columns,'info_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_cruise_info_language', array('cruise_info'=>$describe), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add')
                    {
                        //新增外语
                        $db->createCommand()->insert('vcos_cruise_info_language',array('info_id'=>$id,'iso'=>$_POST['language'],'cruise_info'=>$describe_iso));
                    }  
                    else 
                    {
                        //编辑外语
                        $db->createCommand()->update('vcos_cruise_info_language', array('cruise_info'=>$describe_iso), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/cruiseinfo_list"));
                }  
                else 
                {
                	//只编辑系统语言
                    $detail->info_id = $id;
                    $detail->state = $state;
                    if($photo != '')
                    {
                    	$detail->cruise_img = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $detail->save();
                    $detail_language->id = $id2['id'];
                    $detail_language->cruise_info = $describe;
                    $detail_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/cruiseinfo_list"));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $this->render('cruiseinfo_edit',array('detail'=>$detail,'detail_language'=>$detail_language));
    }
    
    public function actionGetiso_cruiseinfo()
    {
        $sql = "SELECT b.id, b.cruise_info FROM vcos_cruise_info a LEFT JOIN vcos_cruise_info_language b ON a.info_id = b.info_id WHERE a.info_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso)
        {
            echo json_encode($iso);
        }  
        else 
        {
            echo 0;
        }
    }
    
    public function actionCheckport()
    {
        $result = VcosPortDetail::model()->count('port_id=:num',array(':num'=>$_POST['pid']));
        if($result>0)
        {
            echo 1;
        }
    }
    
    
    /**甲板添加**/
    public function actionCruise_deck_add()
    {
    	$this->setauth();//检查有无权限
    	$deck = new VcosCruiseDeck();
    	$deck_language = new VcosCruiseDeckLanguage();
    	if($_POST)
    	{
    		$photo='';
    		if($_FILES['photo']['error']!=4)
    		{
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		$photo_iso = '';
    		if(isset($_POST['language']) && $_POST['language'] != '')
    		{
    			if($_FILES['photo_iso']['error']!=4)
    			{
    				$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    				$photo_iso=$result['filename'];
    			}
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    	
    		$deck->deck_state = $state;
    		$deck->deck_layer = $_POST['layer'];
    		
    		$photo_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
    		$photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    		
    		//处理事务
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try
    		{
    			$deck->save();
    			if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
    				$sql = "INSERT INTO `vcos_cruise_deck_language` (`deck_id`,`img_url`,`deck_name`, `iso`) VALUES ('{$deck->primaryKey}','{$photo_url}', '{$_POST['name']}' ,'".Yii::app()->params['language']."'), ('{$deck->primaryKey}','{$photo_iso_url}','{$_POST['name_iso']}', '{$_POST['language']}')";
    				$db->createCommand($sql)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/cruise_deck_list"));
    			}  
    			else 
    			{//只添加系统语言时
    				$deck_language->deck_id = $deck->primaryKey;
    				$deck_language->img_url = $photo_url;
    				$deck_language->deck_name = $_POST['name'];
    				$deck_language->iso = Yii::app()->params['language'];
    				$deck_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/cruise_deck_list"));
    			}
    		}catch(Exception $e)
    		{
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
    		}
    	}
    	$this->render('cruise_deck_add',array('deck'=>$deck,'deck_language'=>$deck_language));
    }
    
    /**甲板列表**/
    public function actionCruise_deck_list()
    {
    	$this->setauth();//检查有无权限
    	$db = Yii::app()->m_db;
    	
    	//多条删除
    	if($_POST)
    	{
    		$a = count($_POST['ids']);
    		$ids=implode('\',\'', $_POST['ids']);
    		$result = VcosCruiseDeck::model()->count();
    		$count_sql = "select count(*) count from `vcos_cruise_deck_point` WHERE deck_id in ('$ids')";
    		$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    	
    		if($a == $result)
    		{
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		else if($count_category['count'] > 0)
    		{
    			die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
    		}
    	
    		//事务处理
    		$transaction=$db->beginTransaction();
    		try
    		{
    			$count=VcosCruiseDeck::model()->deleteAll("deck_id in('$ids')");
    			$count2 = VcosCruiseDeckLanguage::model()->deleteAll("deck_id in('$ids')");
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/Cruise_deck_list"));
    		}
    		catch(Exception $e)
    		{
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	//单条删除
    	if(isset($_GET['id']))
    	{
    		$result = VcosCruiseDeck::model()->count();
    		$count_sql = "select count(*) count from `vcos_cruise_deck_point` WHERE deck_id =" .$_GET['id'];
    		$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    		if($result<=1)
    		{
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		else if($count_category['count'] > 0)
    		{
    			die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
    		}
    		$did=$_GET['id'];
    		//事务处理
    		$transaction2=$db->beginTransaction();
    		try
    		{
    			$count = VcosCruiseDeck::model()->deleteByPk($did);
    			$count2 = VcosCruiseDeckLanguage::model()->deleteAll("deck_id in('$did')");
    			$transaction2->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/Cruise_deck_list"));
    		}
    		catch(Exception $e)
    		{
    			$transaction2->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	$count_sql = "SELECT count(*) count FROM `vcos_cruise_deck` a
		LEFT JOIN `vcos_cruise_deck_language` b ON a.deck_id = b.deck_id
		WHERE b.iso = '".Yii::app()->language."'";
    	$count =$db->createCommand($count_sql)->queryRow();
    	//分页
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	//$count = count($restaurant);
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$sql = "SELECT * FROM `vcos_cruise_deck` a
		LEFT JOIN `vcos_cruise_deck_language` b ON a.deck_id = b.deck_id
		WHERE b.iso = '".Yii::app()->language."'LIMIT {$criteria->offset}, {$pager->pageSize}";
    	$cruise_deck = $db->createCommand($sql)->queryAll();
    	$this->render('cruise_deck_list',array('pages'=>$pager,'auth'=>$this->auth,'cruise_deck'=>$cruise_deck));
    }
    
    
    
    /**编辑甲板**/
    public function actionCruise_deck_edit()
    {
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$cruise_deck= VcosCruiseDeck::model()->findByPk($id);
    	$sql = "SELECT b.id FROM vcos_cruise_deck a LEFT JOIN vcos_cruise_deck_language b ON a.deck_id = b.deck_id WHERE a.deck_id = {$id} AND b.iso ='".Yii::app()->language."'";
    	$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
    	$cruise_deck_language = VcosCruiseDeckLanguage::model()->findByPk($id2['id']);
    	if($_POST)
    	{
    		
    		$photo='';
    		$photo_iso='';
    		if($_FILES['photo']['error']!=4)
    		{
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		if(isset($_POST['language']) && $_POST['language'] != '')
    		{
	    		if($_FILES['photo_iso']['error']!=4)
	    		{
	    			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
	    			$photo_iso=$result['filename'];
	    		}
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try
    		{
    			if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
    				//编辑主表
    				$columns = array('deck_state'=>$state,'deck_layer'=>$_POST['layer']);
    				$db->createCommand()->update('vcos_cruise_deck',$columns,'deck_id = :id',array(':id'=>$id));
    				
    				if($photo_iso){//判断有无上传图片
    					$photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    				}	
    				$columns_deck =  array('deck_name'=>$_POST['name']);
    				if($photo){//判断有无上传图片
    					$columns_deck['img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
    				}
    				//编辑系统语言
    				$db->createCommand()->update('vcos_cruise_deck_language', $columns_deck, 'id=:id', array(':id'=>$id2['id']));
    				//判断外语是新增OR编辑
    				if($_POST['judge']=='add'){
    					//新增外语
    					$db->createCommand()->insert('vcos_cruise_deck_language',array('deck_id'=>$id,'iso'=>$_POST['language'],'img_url'=>$photo_iso_url,'deck_name'=>$_POST['name_iso']));
    				}  else {
    					//编辑外语
    					$columns_deck_language =  array('deck_name'=>$_POST['name_iso']);
    					if($photo_iso){//判断有无上传图片
    						$columns_deck_language['img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    					}
    					$db->createCommand()->update('vcos_cruise_deck_language', $columns_deck_language, 'id=:id', array(':id'=>$_POST['judge']));
    				}
    				//事务提交
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/Cruise_deck_list"));
    			}  else {//只编辑系统语言状态下
    				$cruise_deck->deck_state = $state;
    				$cruise_deck->deck_layer = $_POST['layer'];
    				$cruise_deck->save();
    				$cruise_deck_language->id = $id2['id'];	
    				//$cruise_deck_language->img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    				if($photo){//判断有无上传图片
    					$cruise_deck_language->img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
    				}
    				$cruise_deck_language->deck_name = $_POST['name'];
    				$cruise_deck_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/Cruise_deck_list"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '修改失败。'), '#');
    		}
    	}
    	$this->render('cruise_deck_edit',array('cruise_deck'=>$cruise_deck,'cruise_deck_language'=>$cruise_deck_language));
    }
    
    
    public function actionGetiso_deck()
    {
    	$sql = "SELECT b.id, b.img_url,b.deck_name FROM vcos_cruise_deck a LEFT JOIN vcos_cruise_deck_language b ON a.deck_id = b.deck_id WHERE a.deck_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
    	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($iso){
    		echo json_encode($iso);
    	}  else {
    		echo 0;
    	}
    }
    
    /**甲板点介绍添加**/
    public function actionCruise_deck_point_add(){
    	$this->setauth();//检查有无权限
    	$deck_point = new VcosCruiseDeckPoint();
    	$deck_point_language = new VcosCruiseDeckPointLanguage();
    	if($_POST){
    		
    		$photo='';
    		if($_FILES['photo']['error']!=4){
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		$photo_iso = '';
    		if(isset($_POST['language']) && $_POST['language'] != ''){
    			if($_FILES['photo_iso']['error']!=4){
    				$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    				$photo_iso=$result['filename'];
    			}
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		$deck_point->deck_id = $_POST['deck'];
    		$deck_point->deck_point_state = $state;
    		$deck_point->deck_number = $_POST['number'];
    	
    		$photo_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
    		$photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    		
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
    			$deck_point->save();
    			if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
    				$sql = "INSERT INTO `vcos_cruise_deck_point_language` (`deck_point_id`,`img_url`,`deck_point_name`,`deck_point_describe`,`deck_point_info`, `iso`) VALUES ('{$deck_point->primaryKey}','{$photo_url}', '{$_POST['name']}','{$_POST['desc']}' ,'{$describe}','".Yii::app()->params['language']."'), ('{$deck_point->primaryKey}','{$photo_iso_url}','{$_POST['name_iso']}','{$_POST['desc_iso']}' ,'{$describe_iso}', '{$_POST['language']}')";
    				$db->createCommand($sql)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/cruise_deck_point_list"));
    			}  else {//只添加系统语言时
    				$deck_point_language->deck_point_id = $deck_point->primaryKey;
    				$deck_point_language->img_url = $photo_url;
    				$deck_point_language->deck_point_name = $_POST['name'];
    				$deck_point_language->deck_point_describe = $_POST['desc'];
    				$deck_point_language->deck_point_info = $describe;
    				$deck_point_language->iso = Yii::app()->params['language'];
    				$deck_point_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Cruiseinfo/cruise_deck_point_list"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
    		}
    	}
    	$sql = "SELECT a.deck_id,b.deck_name FROM `vcos_cruise_deck` a LEFT JOIN `vcos_cruise_deck_language` b ON a.deck_id = b.deck_id WHERE b.iso = '".Yii::app()->language."'";
    	$deck_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('cruise_deck_point_add',array('deck_sel'=>$deck_sel,'deck_point'=>$deck_point,'deck_point_language'=>$deck_point_language));
    }
    
    
    
    /**甲板点列表**/
    public function actionCruise_deck_point_list(){
    	$this->setauth();//检查有无权限
    	$db = Yii::app()->m_db;
    	 
    	//批量删除
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosCruiseDeckPoint::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosCruiseDeckPoint::model()->deleteAll("deck_point_id in('$ids')");
                $count2 = VcosCruiseDeckPointLanguage::model()->deleteAll("deck_point_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/cruise_deck_point_list"));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosCruiseDeckPoint::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosCruiseDeckPoint::model()->deleteByPk($did);
                $count2 = VcosCruiseDeckPointLanguage::model()->deleteAll("deck_point_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Cruiseinfo/cruise_deck_point_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM `vcos_cruise_deck_point` a
		LEFT JOIN `vcos_cruise_deck_point_language` b ON a.deck_point_id=b.deck_point_id
		LEFT JOIN (SELECT * FROM `vcos_cruise_deck_language` c WHERE c.iso = '".Yii::app()->language."') c ON a.deck_id = c.deck_id
		WHERE b.iso = '".Yii::app()->language."'";
        $count = $db->createCommand($count_sql)->queryRow();
    	//分页
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	//$count = count($restaurant);
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$sql = "SELECT * FROM `vcos_cruise_deck_point` a
		LEFT JOIN `vcos_cruise_deck_point_language` b ON a.deck_point_id=b.deck_point_id
		LEFT JOIN (SELECT * FROM `vcos_cruise_deck_language` c WHERE c.iso = '".Yii::app()->language."') c ON a.deck_id = c.deck_id
		WHERE b.iso = '".Yii::app()->language."' LIMIT {$criteria->offset}, {$pager->pageSize}";
    	$cruise_deck_point = $db->createCommand($sql)->queryAll();
    	$this->render('cruise_deck_point_list',array('pages'=>$pager,'auth'=>$this->auth,'cruise_deck_point'=>$cruise_deck_point));
    }
    
    
    /**编辑甲板点介绍**/
    public function actionCruise_deck_point_edit(){
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$cruise_deck_point= VcosCruiseDeckPoint::model()->findByPk($id);
    	$sql = "SELECT b.id FROM vcos_cruise_deck_point a LEFT JOIN vcos_cruise_deck_point_language b ON a.deck_point_id = b.deck_point_id WHERE a.deck_point_id = {$id} AND b.iso ='".Yii::app()->language."'";
    	$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
    	$cruise_deck_point_language = VcosCruiseDeckPointLanguage::model()->findByPk($id2['id']);
    	if($_POST){
    		$photo='';
    		$photo_iso='';
    		if($_FILES['photo']['error']!=4){
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		if(isset($_POST['language']) && $_POST['language'] != ''){
    			if($_FILES['photo_iso']['error']!=4){
    				$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
    				$photo_iso=$result['filename'];
    			}
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
    				$columns = array('deck_point_state'=>$state,'deck_number'=>$_POST['number'],'deck_id'=>$_POST['deck']);
    				$db->createCommand()->update('vcos_cruise_deck_point',$columns,'deck_point_id = :id',array(':id'=>$id));
    	
    				if($photo_iso){//判断有无上传图片
    					$photo_iso_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    				}
    				$columns_deck_point =  array('deck_point_name'=>$_POST['name'],'deck_point_describe'=>$_POST['desc'],'deck_point_info'=>$describe);
    				if($photo != ''){//判断有无上传图片
    					$columns_deck_point['img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
    				}
    				//编辑系统语言
    				$db->createCommand()->update('vcos_cruise_deck_point_language', $columns_deck_point, 'id=:id', array(':id'=>$id2['id']));
    				//判断外语是新增OR编辑
    				if($_POST['judge']=='add'){
    					//新增外语
    					$db->createCommand()->insert('vcos_cruise_deck_point_language',array('deck_point_id'=>$id,'iso'=>$_POST['language'],'img_url'=>$photo_iso_url,'deck_point_name'=>$_POST['name_iso'],'deck_point_describe'=>$_POST['desc_iso'],'deck_point_info'=>$describe_iso));
    				}  else {
    					//编辑外语
    					$columns_deck_point_language =  array('deck_point_name'=>$_POST['name_iso'],'deck_point_describe'=>$_POST['desc_iso'],'deck_point_info'=>$describe_iso);
    					if($photo_iso != ''){//判断有无上传图片
    						$columns_deck_point_language['img_url'] = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    					}
    					$db->createCommand()->update('vcos_cruise_deck_point_language', $columns_deck_point_language, 'id=:id', array(':id'=>$_POST['judge']));
    				}
    				//事务提交
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/Cruise_deck_point_list"));
    			}  else {//只编辑系统语言状态下
    				$cruise_deck_point->deck_point_state = $state;
    				$cruise_deck_point->deck_number = $_POST['number'];
    				$cruise_deck_point->deck_id = $_POST['deck'];
    				$cruise_deck_point->save();
    				$cruise_deck_point_language->id = $id2['id'];
    				if($photo != ''){//判断有无上传图片
    					$cruise_deck_point_language->img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
    				}
    				//$cruise_deck_point_language->img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    				$cruise_deck_point_language->deck_point_name = $_POST['name'];
    				$cruise_deck_point_language->deck_point_describe = $_POST['desc'];
    				$cruise_deck_point_language->deck_point_info = $describe;
    				$cruise_deck_point_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Cruiseinfo/Cruise_deck_point_list"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '修改失败。'), '#');
    		}
    	}
    	$sql = "SELECT a.deck_id,b.deck_name FROM `vcos_cruise_deck` a LEFT JOIN `vcos_cruise_deck_language` b ON a.deck_id = b.deck_id WHERE b.iso = '".Yii::app()->language."'";
    	$deck_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('cruise_deck_point_edit',array('deck_sel'=>$deck_sel,'cruise_deck_point'=>$cruise_deck_point,'cruise_deck_point_language'=>$cruise_deck_point_language));
    }
    
    public function actionGetiso_deck_point(){
    	$sql = "SELECT b.id, b.img_url,b.deck_point_name,b.deck_point_describe,b.deck_point_info FROM vcos_cruise_deck_point a LEFT JOIN vcos_cruise_deck_point_language b ON a.deck_point_id = b.deck_point_id WHERE a.deck_point_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
    	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($iso){
    		echo json_encode($iso);
    	}  else {
    		echo 0;
    	}
    }
    

}