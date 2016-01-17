<?php

class MainController extends Controller
{
	public function actionMain_category_list()
	{
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		//批量删除
		if($_POST){
			$a = count($_POST['ids']);
			$ids=implode('\',\'', $_POST['ids']);
			$result = VcosMainCategory::model()->count();
			//查看是否查询攻略是属于该城市
			$count_sql = "SELECT count(*) count FROM `vcos_main_nav` WHERE category_id in('$ids')";
			$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
			if($a == $result){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}
			else if($count_category['count'] >0){
				die(Helper::show_message(yii::t('vcos', '存在关联不能删除！')));
			}
		
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count = VcosMainCategory::model()->deleteAll("main_id in('$ids')");
				$count2 = VcosMainCategoryLanguage::model()->deleteAll("main_id in('$ids')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Main/main_category_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		
		//单条删除
		if(isset($_GET['id'])){
			
			$result = VcosMainCategory::model()->count();
			$count_sql = "SELECT count(*) count FROM `vcos_main_nav` WHERE category_id =".$_GET['id'];
			
			$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
			
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}else if($count_category['count'] >0){
				die(Helper::show_message(yii::t('vcos', '存在关联不能删除！')));
			}
			$did=$_GET['id'];
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count=VcosMainCategory::model()->deleteByPk($did);
				$count2 = VcosMainCategoryLanguage::model()->deleteAll("main_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Main/main_category_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_main_category` a LEFT JOIN `vcos_main_category_language` b ON a.main_id = b.main_id WHERE b.iso = '".Yii::app()->language."'";
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT * FROM `vcos_main_category` a LEFT JOIN `vcos_main_category_language` b ON a.main_id = b.main_id WHERE b.iso = '".Yii::app()->language."' LIMIT {$criteria->offset}, {$pager->pageSize}";
		$category = $db->createCommand($sql)->queryAll();
		
		$this->render('main_category_list',array('category'=>$category,'pages'=>$pager,'auth'=>$this->auth));
	}
	
	public function actionMain_category_add(){
		$this->setauth();//检查有无权限
		$main_category = new VcosMainCategory();
		$main_category_language = new VcosMainCategoryLanguage();
		if($_POST){
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$main_category->state = $state;
			$main_category->sequence = $_POST['sequence'];
			
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
		
			try{
				$main_category->save();
				if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
					$sql = "INSERT INTO `vcos_main_category_language` (`main_id`,`name`, `iso`) VALUES ('{$main_category->primaryKey}','{$_POST['name']}', '".Yii::app()->params['language']."'), ('{$main_category->primaryKey}','{$_POST['name_iso']}', '{$_POST['language']}')";
					$db->createCommand($sql)->execute();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Main/Main_category_list"));
				}  else {//只添加系统语言时
					$main_category_language->main_id = $main_category->primaryKey;
					$main_category_language->iso = Yii::app()->params['language'];
					$main_category_language->name = $_POST['name'];
					$main_category_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Main/Main_category_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$this->render('main_category_add',array('main_category'=>$main_category,'main_category_language'=>$main_category_language));
		
	}
	public function actionMain_category_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$main_category= VcosMainCategory::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_main_category a LEFT JOIN vcos_main_category_language b ON a.main_id = b.main_id WHERE a.main_id = {$id} AND b.iso ='".Yii::app()->language."'";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$main_category_language = VcosMainCategoryLanguage::model()->findByPk($id2['id']);
			
		if($_POST){
			$state = isset($_POST['state'])?$_POST['state']:'0';
				
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
					//编辑主表
					$columns = array('state'=>$state,'sequence'=>$_POST['sequence']);
					$db->createCommand()->update('vcos_main_category',$columns,'main_id = :id',array(':id'=>$id));
					//编辑系统语言
					$db->createCommand()->update('vcos_main_category_language', array('name'=>$_POST['name']), 'id=:id', array(':id'=>$id2['id']));
					//判断外语是新增OR编辑
					if($_POST['judge']=='add'){
						//新增外语
						$db->createCommand()->insert('vcos_main_category_language',array('main_id'=>$id,'iso'=>$_POST['language'],'name'=>$_POST['name_iso']));
					}  else {
						//编辑外语
						$db->createCommand()->update('vcos_main_category_language', array('name'=>$_POST['name_iso']), 'id=:id', array(':id'=>$_POST['judge']));
					}
					//事务提交
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Main/Main_category_list"));
				}  else {//只编辑系统语言状态下
					$main_category->main_id = $id;
					$main_category->state = $state;
					$main_category->sequence = $_POST['sequence'];
					$main_category->save();
					$main_category_language->id = $id2['id'];
					$main_category_language->name = $_POST['name'];
					$main_category_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Main/Main_category_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		
		$this->render('main_category_edit',array('main_category'=>$main_category,'main_category_language'=>$main_category_language));
	}
	
	public function actionGetiso_category(){
		$sql = "SELECT b.id, b.name FROM vcos_main_category a LEFT JOIN vcos_main_category_language b ON a.main_id = b.main_id WHERE a.main_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
		$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
		if($iso){
			echo json_encode($iso);
		}  else {
			echo 0;
		}
	
	}
	
	public function actionMain_nav_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		
		$where = 1;
		$res_but = 0;
		if(isset($_GET['category']) && $_GET['category'] != ''){
			if($_GET['category'] == 0){
				$where = 1;
				$res_but = 0;
			}else{
				$where = "a.category_id = ".$_GET['category'];
				$res_but = $_GET['category'];
			}
		}
		
		
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosMainNav::model()->count();
			/*
			$count_sql = "SELECT count(*) count FROM `vcos_main_nav` WHERE category_id =".$_GET['id'];
			$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
				*/
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}
			/*else if($count_category['count'] >0){
				die(Helper::show_message(yii::t('vcos', '存在关联不能删除！')));
			}*/
			$did=$_GET['id'];
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count=VcosMainNav::model()->deleteByPk($did);
				$count2 = VcosMainNavLanguage::model()->deleteAll("nav_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Main/main_nav_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_main_nav` a
				LEFT JOIN `vcos_main_nav_language` b ON a.nav_id= b.nav_id
				LEFT JOIN (SELECT d.main_id,d.name  FROM `vcos_main_category` c LEFT JOIN `vcos_main_category_language` d ON c.main_id = d.main_id WHERE c.state = '1' AND d.iso = '".Yii::app()->language."') e
				ON a.category_id = e.main_id
				WHERE ".$where." AND b.iso = '".Yii::app()->language."'";
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.main_id,b.name FROM `vcos_main_category` a LEFT JOIN `vcos_main_category_language` b ON a.main_id = b.main_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."' ";
		$category_sel = $db->createCommand($sql)->queryAll();
		$sql = "SELECT a.*,b.*,e.name as category_name FROM `vcos_main_nav` a 
				LEFT JOIN `vcos_main_nav_language` b ON a.nav_id= b.nav_id 
				LEFT JOIN (SELECT d.main_id,d.name  FROM `vcos_main_category` c LEFT JOIN `vcos_main_category_language` d ON c.main_id = d.main_id WHERE c.state = '1' AND d.iso = '".Yii::app()->language."') e 
				ON a.category_id = e.main_id
				WHERE ".$where." AND b.iso = '".Yii::app()->language."' LIMIT {$criteria->offset}, {$pager->pageSize}";
		$nav = $db->createCommand($sql)->queryAll();
		
		$this->render('main_nav_list',array('res_but'=>$res_but,'category_sel'=>$category_sel,'nav'=>$nav,'pages'=>$pager,'auth'=>$this->auth));
	}
	
	public function actionMain_nav_add(){
		$this->setauth();//检查有无权限
		$main_nav = new VcosMainNav();
		$main_nav_language = new VcosMainNavLanguage();
		if($_POST){
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'main_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_iso = '';
			if(isset($_POST['language']) && $_POST['language'] != ''){
				if($_FILES['photo_iso']['error']!=4){
					$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'main_images/'.Yii::app()->params['month'], 'image', 3);
					$photo_iso=$result['filename'];
				}
			}
			$photo_url = 'main_images/'.Yii::app()->params['month'].'/'.$photo;
			$photo_iso_url = 'main_images/'.Yii::app()->params['month'].'/'.$photo_iso;
			
			$main_nav->state = $_POST['state'];
			$main_nav->sequence = $_POST['sequence'];
			$main_nav->category_id = $_POST['category'];
			
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
		
			try{
				$main_nav->save();
				if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
					$sql = "INSERT INTO `vcos_main_nav_language` (`nav_id`,`name`,`img_url`,`bg_color`,`iso`) VALUES ('{$main_nav->primaryKey}','{$_POST['name']}','{$photo_url}','{$_POST['bgcolor']}', '".Yii::app()->params['language']."'), ('{$main_nav->primaryKey}','{$_POST['name_iso']}', '{$photo_iso_url}','{$_POST['bgcolor_iso']}','{$_POST['language']}')";
					$db->createCommand($sql)->execute();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Main/Main_nav_list"));
				}  else {//只添加系统语言时
					$main_nav_language->nav_id = $main_nav->primaryKey;
					$main_nav_language->iso = Yii::app()->params['language'];
					$main_nav_language->name = $_POST['name'];
					$main_nav_language->img_url = $photo_url;
					$main_nav_language->bg_color = $_POST['bgcolor'];
					$main_nav_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Main/Main_nav_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT a.main_id,b.name FROM `vcos_main_category` a LEFT JOIN `vcos_main_category_language` b ON a.main_id = b.main_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
		$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
		$this->render('main_nav_add',array('category_sel'=>$category_sel,'main_nav'=>$main_nav,'main_nav_language'=>$main_nav_language));
	}
	
	public function actionMain_nav_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$main_nav= VcosMainNav::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_main_nav a LEFT JOIN vcos_main_nav_language b ON a.nav_id = b.nav_id WHERE a.nav_id = {$id} AND b.iso ='".Yii::app()->language."'";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$main_nav_language = VcosMainNavLanguage::model()->findByPk($id2['id']);
			
		if($_POST){
			$photo='';
			$photo_iso='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'main_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			if(isset($_POST['language']) && $_POST['language'] != ''){
				if($_FILES['photo_iso']['error']!=4){
					$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'main_images/'.Yii::app()->params['month'], 'image', 3);
					$photo_iso=$result['filename'];
				}
			}
			
			$photo_url = '';
			if($photo){//判断有无上传图片
				$photo_url = 'main_images/'.Yii::app()->params['month'].'/'.$photo;
			}
			//$state = isset($_POST['state'])?$_POST['state']:'0';
		
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
					//编辑主表
					$columns = array('state'=>$_POST['state'],'sequence'=>$_POST['sequence'],'category_id'=>$_POST['category']);
					$db->createCommand()->update('vcos_main_nav',$columns,'nav_id = :id',array(':id'=>$id));
					//编辑系统语言
					$columns = array('name'=>$_POST['name'],'bg_color'=>$_POST['bgcolor']);
					if($photo){//判断有无上传图片
						$columns['img_url'] = 'main_images/'.Yii::app()->params['month'].'/'.$photo;
					}
					$db->createCommand()->update('vcos_main_nav_language',$columns , 'id=:id', array(':id'=>$id2['id']));
					//判断外语是新增OR编辑
					if($_POST['judge']=='add'){
						//新增外语
						$columns = array('nav_id'=>$id,'iso'=>$_POST['language'],'name'=>$_POST['name_iso'],'bg_color'=>$_POST['bgcolor']);
						if($photo_iso){//判断有无上传图片
							$columns['img_url'] = 'main_images/'.Yii::app()->params['month'].'/'.$photo_iso;
						}
						$db->createCommand()->insert('vcos_main_nav_language',$columns);
					}  else {
						//编辑外语
						$columns =  array('name'=>$_POST['name_iso'],'bg_color'=>$_POST['bgcolor']);
						if($photo_iso){//判断有无上传图片
							$columns['img_url'] = 'main_images/'.Yii::app()->params['month'].'/'.$photo_iso;
						}
						$db->createCommand()->update('vcos_main_nav_language',$columns, 'id=:id', array(':id'=>$_POST['judge']));
					}
					//事务提交
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Main/Main_nav_list"));
				}  else {//只编辑系统语言状态下
					$main_nav->nav_id = $id;
					$main_nav->state = $_POST['state'];
					$main_nav->sequence = $_POST['sequence'];
					$main_nav->category_id = $_POST['category'];
					$main_nav->save();
					$main_nav_language->id = $id2['id'];
					$main_nav_language->name = $_POST['name'];
					$main_nav_language->bg_color = $_POST['bgcolor'];
					//$main_nav_language->img_url = $photo_url;
					if($photo){//判断有无上传图片
						$main_nav_language->img_url = 'main_images/'.Yii::app()->params['month'].'/'.$photo;
					}
					$main_nav_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Main/Main_nav_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		$sql = "SELECT a.main_id,b.name FROM `vcos_main_category` a LEFT JOIN `vcos_main_category_language` b ON a.main_id = b.main_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
		$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
		
		$this->render('main_nav_edit',array('category_sel'=>$category_sel,'main_nav'=>$main_nav,'main_nav_language'=>$main_nav_language));
	}
	
	public function actionGetiso_nav(){
		$sql = "SELECT b.id, b.name,b.bg_color,b.img_url FROM vcos_main_nav a LEFT JOIN vcos_main_nav_language b ON a.nav_id = b.nav_id WHERE a.nav_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
		$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
		if($iso){
			echo json_encode($iso);
		}  else {
			echo 0;
		}
	}

}