<?php

class SystemsettingController extends Controller
{
    public function actionLscategoryadd()
    {
        if($this->auth[0] == '0'){
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $lc = new VcosLifeserviceCategory();
        $lc_language = new VcosLifeserviceCategoryLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',  Yii::app()->params['img_save_url'].'lifeservice_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $lc->bg_color = $_POST['bgcolor'];
            $lc->lc_state = $state;
            $lc->lc_img_url = 'lifeservice_images/'.Yii::app()->params['month'].'/'.$photo;
            
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $lc->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_lifeservice_category_language` (`lc_id`, `iso`, `lc_name`) VALUES ('{$lc->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}'), ('{$lc->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Lifeservice/Service_category"));
                }  else {//只添加系统语言时
                    $lc_language->lc_id = $lc->primaryKey;
                    $lc_language->iso = Yii::app()->params['language'];
                    $lc_language->lc_name = $_POST['title'];
                    $lc_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Lifeservice/Service_category"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('lscategoryadd',array('lc'=>$lc,'lc_language'=>$lc_language));
    }
    
    public function actionCruiseinfocategory()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $count=VcosCruiseInfoCategory::model()->deleteAll("id in('$ids')");
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Systemsetting/cruiseinfocategory")); 
            }else{
                Helper::show_message(yii::t('vcos', '删除失败')); 
            }
        }
        if($_GET){
            $did=$_GET['id'];
            $count=VcosCruiseInfoCategory::model()->deleteByPk($did);
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Systemsetting/cruiseinfocategory")); 
            }else{
                Helper::show_message(yii::t('vcos', '删除失败')); 
            }
        }
        $category = VcosCruiseInfoCategory::model()->findAll($params=array('order'=>'id'));
        $this->render('cruiseinfocategory',array('category'=>$category));
    }
    
    public function actionCruiseinfocategory_add()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $category = new VcosCruiseInfoCategory();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['url']!=''&&$_POST['bgcolor']!=''){
                $category->cruise_info_category_name = $_POST['name'];
                $category->category_href_url = $_POST['url'];
                $category->bg_color = $_POST['bgcolor'];
                $category->state = $state;
                $category->cruise_info_category_img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                //print_r($category);die;
                if($category->save()>0){
                    Helper::show_message(yii::t('vcos', '添加成功'), Yii::app()->createUrl("Systemsetting/cruiseinfocategory")); 
                }else{
                    Helper::show_message(yii::t('vcos', '添加失败')); 
                }
            }else{
                Helper::show_message(yii::t('vcos', '添加失败')); 
            }
        }
        $this->render('cruiseinfocategoryadd',array('access'=>$access));
    }
    
    public function actionCruiseinfocategory_edit()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $id=$_GET['id'];
        $category= VcosCruiseInfoCategory::model()->findByPk($id);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',Yii::app()->params['img_save_url'].'cruiseinfo_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['url']!=''&&$_POST['bgcolor']!=''){
                $category->id = $id;
                $category->cruise_info_category_name = $_POST['name'];
                $category->category_href_url = $_POST['url'];
                $category->bg_color = $_POST['bgcolor'];
                $category->state = $state;
                if($photo){
                    $old=Yii::app()->params['img_save_url'].$category['cruise_info_category_img_url'];
                    if(file_exists($old)&&$category['cruise_info_category_img_url']){
                        unlink($old);
                    }
                    $category->cruise_info_category_img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo;
                }
                if($category->save()>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("Systemsetting/cruiseinfocategory"));  
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
                }
            }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
            }
        }
        $this->render('cruiseinfocategory_edit',array('category'=>$category));
    }
    
    public function actionNet_category()
    {
        $this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		//批量删除
		if($_POST){
			$a = count($_POST['ids']);
			$ids=implode('\',\'', $_POST['ids']);
			$result = VcosWifi::model()->count();
			/*
			$count_sql = "SELECT count(*) count FROM `vcos_strategy_city` WHERE country_id in('$ids')";
			$count_num = Yii::app()->m_db->createCommand($count_sql)->queryRow();*/
			if($a == $result){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}/*else if($count_num['count'] >0){
				die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
			}*/
		
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count = VcosWifi::model()->deleteAll("wifi_id in('$ids')");
				$count2 = VcosWifiLanguage::model()->deleteAll("wifi_id in('$ids')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Systemsetting/net_category"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosWifi::model()->count();
			/*$sql = "SELECT count(*) count FROM `vcos_strategy_city` WHERE country_id = ".$_GET['id'];
			$count_num = $db->createCommand($sql)->queryRow();*/
			
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}/*else if($count_num['count'] > 0){
				die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
			}*/
			
			$did=$_GET['id'];
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count=VcosWifi::model()->deleteByPk($did);
				$count2 = VcosWifiLanguage::model()->deleteAll("wifi_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Systemsetting/net_category"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_wifi` a LEFT JOIN `vcos_wifi_language` b ON a.wifi_id = b.wifi_id WHERE b.iso = '".Yii::app()->language."'";
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT * FROM `vcos_wifi` a LEFT JOIN `vcos_wifi_language` b ON a.wifi_id = b.wifi_id WHERE b.iso = '".Yii::app()->language."' LIMIT {$criteria->offset}, {$pager->pageSize}";
		$wifi = $db->createCommand($sql)->queryAll();
		
		$this->render('net_category',array('wifi'=>$wifi,'pages'=>$pager,'auth'=>$this->auth));
    }
    
    public function actionNet_category_add()
    {
        $this->setauth();//检查有无权限
        $wifi = new VcosWifi();
        $wifi_language = new VcosWifiLanguage();
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $time = (int)$_POST['hour']*60+(int)$_POST['minute'];
            $wifi->wifi_price = $_POST['price']*100;
            $wifi->wifi_time = $time; 
            $wifi->wifi_state = $state;
           
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $wifi->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_wifi_language` (`wifi_id`, `iso`, `wifi_name`) VALUES ('{$wifi->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['name']}'), ('{$wifi->primaryKey}', '{$_POST['language']}', '{$_POST['name_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Systemsetting/net_category"));
                }  else {//只添加系统语言时
                    $wifi_language->wifi_id = $wifi->primaryKey;
                    $wifi_language->iso = Yii::app()->params['language'];
                    $wifi_language->wifi_name = $_POST['name'];
                    $wifi_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Systemsetting/net_category"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('net_category_add',array('wifi'=>$wifi,'wifi_language'=>$wifi_language));
    }
    
    public function actionNet_category_edit()
    {
        $this->setauth();//检查有无权限
		$id=$_GET['id'];
		$wifi= VcosWifi::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_wifi a LEFT JOIN vcos_wifi_language b ON a.wifi_id = b.wifi_id WHERE a.wifi_id = {$id} AND b.iso ='".Yii::app()->language."'";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$wifi_language = VcosWifiLanguage::model()->findByPk($id2['id']);
		 
		if($_POST){
			 $state = isset($_POST['state'])?$_POST['state']:'0';
			 $time = (int)$_POST['hour']*60+(int)$_POST['minute'];
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
					//编辑主表
					$columns = array('wifi_state'=>$state,'wifi_price'=>$_POST['price']*100,'wifi_time'=>$time);
					$db->createCommand()->update('vcos_wifi',$columns,'wifi_id = :id',array(':id'=>$id));
					//编辑系统语言
					$db->createCommand()->update('vcos_wifi_language', array('wifi_name'=>$_POST['name']), 'id=:id', array(':id'=>$id2['id']));
					//判断外语是新增OR编辑
					if($_POST['judge']=='add'){
						//新增外语
						$db->createCommand()->insert('vcos_wifi_language',array('wifi_id'=>$id,'iso'=>$_POST['language'],'wifi_name'=>$_POST['name_iso']));
					}  else {
						//编辑外语
						$db->createCommand()->update('vcos_wifi_language', array('wifi_name'=>$_POST['name_iso']), 'id=:id', array(':id'=>$_POST['judge']));
					}
					//事务提交
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Systemsetting/net_category"));
				}  else {//只编辑系统语言状态下
					$wifi->wifi_id = $id;
					$wifi->wifi_state = $state;
					$wifi->wifi_price = $_POST['price']*100;
					$wifi->wifi_time = $time;
					$wifi->save();
					$wifi_language->id = $id2['id'];
					$wifi_language->wifi_name = $_POST['name'];
					$wifi_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Systemsetting/net_category"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		
		$this->render('net_category_edit',array('wifi'=>$wifi,'wifi_language'=>$wifi_language));
    }
    public function actionGetiso_wifi(){
    	$sql = "SELECT b.id, b.wifi_name FROM vcos_wifi a LEFT JOIN vcos_wifi_language b ON a.wifi_id = b.wifi_id WHERE a.wifi_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
    	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($iso){
    		echo json_encode($iso);
    	}  else {
    		echo 0;
    	}
    }
    
    public function actionLocation_category()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $count = VcosLocationCategory::model()->deleteAll("id in('$ids')");
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Systemsetting/Location_category"));
            }else{
                Helper::show_message(yii::t('vcos', '删除失败'));
            }
        }
        if($_GET){
            $did=$_GET['id'];
            $count = VcosLocationCategory::model()->deleteByPk($did);
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Systemsetting/Location_category"));
            }else{
                Helper::show_message(yii::t('vcos', '删除失败'));
            }
        }
        $category = VcosLocationCategory::model()->findAll($params=array('order'=>'id'));
        $this->render('location_category',array('category'=>$category));
    }
    
    public function actionLocation_category_add()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $category = new VcosLocationCategory();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',Yii::app()->params['img_save_url'].'system_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['url']!=''&&$_POST['bgcolor']!=''){
                $category->location_category_name = $_POST['name'];
                $category->location_category_herf_url = $_POST['url'];
                $category->bg_color = $_POST['bgcolor'];
                $category->state = $state;
                $category->location_category_img_url = 'system_images/'.Yii::app()->params['month'].'/'.$photo;
                if($category->save()>0){
                    Helper::show_message(yii::t('vcos', '添加成功'), Yii::app()->createUrl("Systemsetting/location_category")); 
                }else{
                    Helper::show_message(yii::t('vcos', '添加失败')); 
                }
            }else{
                Helper::show_message(yii::t('vcos', '添加失败')); 
            }
        }
        $this->render('location_category_add',array('access'=>$access));
    }
    
    public function actionLocation_category_edit()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $id=$_GET['id'];
        $category= VcosLocationCategory::model()->findByPk($id);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',Yii::app()->params['img_save_url'].'system_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['url']!=''&&$_POST['bgcolor']!=''){
                $category->id = $id;
                $category->location_category_name = $_POST['name'];
                $category->location_category_herf_url = $_POST['url'];
                $category->bg_color = $_POST['bgcolor'];
                $category->state = $state;
                if($photo){
                    $old=Yii::app()->params['img_save_url'].$category['location_category_img_url'];
                    if(file_exists($old)&&$category['location_category_img_url']){
                        unlink($old);
                    }
                    $category->location_category_img_url = 'system_images/'.Yii::app()->params['month'].'/'.$photo;
                }
                if($category->save()>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("Systemsetting/location_category"));  
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
                }
            }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
            }
        }
        $this->render('location_category_edit',array('category'=>$category));
    }
    
    public function actionCommentandhelp_category()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $count = VcosCommentAndHelpCategory::model()->deleteAll("id in('$ids')");
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Systemsetting/Commentandhelp_category"));
            }else{
                Helper::show_message(yii::t('vcos', '删除失败'));
            }
        }
        if($_GET){
            $did=$_GET['id'];
            $count = VcosCommentAndHelpCategory::model()->deleteByPk($did);
            if ($count>0){
                Helper::show_message(yii::t('vcos', '删除成功'), Yii::app()->createUrl("Systemsetting/Commentandhelp_category"));
            }else{
                Helper::show_message(yii::t('vcos', '删除失败'));
            }
        }
        $category = VcosCommentAndHelpCategory::model()->findAll($params=array('order'=>'id'));
        $this->render('commentandhelp_category',array('category'=>$category));
    }
    
    public function actionCommentandhelp_category_add()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $category = new VcosCommentAndHelpCategory();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',Yii::app()->params['img_save_url'].'system_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['url']!=''&&$_POST['bgcolor']!=''){
                $category->cnh_category_name = $_POST['name'];
                $category->cnh_herf_url = $_POST['url'];
                $category->bg_color = $_POST['bgcolor'];
                $category->state = $state;
                $category->cnh_img_url = 'system_images/'.Yii::app()->params['month'].'/'.$photo;
                if($category->save()>0){
                    Helper::show_message(yii::t('vcos', '添加成功'), Yii::app()->createUrl("Systemsetting/Commentandhelp_category")); 
                }else{
                    Helper::show_message(yii::t('vcos', '添加失败')); 
                }
            }else{
                Helper::show_message(yii::t('vcos', '添加失败')); 
            }
        }
        $this->render('commentandhelp_category_add',array('access'=>$access));
    }
    
    public function actionCommentandhelp_category_edit()
    {
        if($this->auth[0] == '0'){
            $access = TRUE;
        }else{
            $error = Yii::app()->createUrl('error/index');
            $this->redirect($error);
        }
        $id=$_GET['id'];
        $category= VcosCommentAndHelpCategory::model()->findByPk($id);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo',Yii::app()->params['img_save_url'].'system_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($_POST['name']!=''&&$_POST['url']!=''&&$_POST['bgcolor']!=''){
                $category->id = $id;
                $category->cnh_category_name = $_POST['name'];
                $category->cnh_herf_url = $_POST['url'];
                $category->bg_color = $_POST['bgcolor'];
                $category->state = $state;
                if($photo){
                    $old=Yii::app()->params['img_save_url'].$category['cnh_img_url'];
                    if(file_exists($old)&&$category['cnh_img_url']){
                        unlink($old);
                    }
                    $category->cnh_img_url = 'system_images/'.Yii::app()->params['month'].'/'.$photo;
                }
                if($category->save()>0){
                    Helper::show_message(yii::t('vcos', '修改成功'), Yii::app()->createUrl("Systemsetting/Commentandhelp_category"));  
                }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
                }
            }else{
                    Helper::show_message(yii::t('vcos', '修改失败'));
            }
        }
        $this->render('commentandhelp_category_edit',array('category'=>$category));
    }

}