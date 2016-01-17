<?php
class ActivityController extends Controller
{
	/**活动列表**/
	public function actionActivity_list()
	{
		$this->setauth();//检查有无权限
		if($_POST)
		{
			$ids=implode('\',\'', $_POST['ids']);
		
			$count = VcosActivity::model()->deleteAll("activity_id in($ids)");
			$count1 = VcosActivityCategory::model()->deleteAll("activity_id in($ids)");
			$count2 = VcosActivityProduct::model()->deleteAll("activity_id in($ids)");
			
			if ($count>0)
			{
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Activity/activity_list"));
			}
			else
			{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id']))
		{
			$did=$_GET['id'];
			
			$count=VcosActivity::model()->deleteByPk($did);
			$count1 = VcosActivityCategory::model()->deleteAll("activity_id in($did)");
			$count2 = VcosActivityProduct::model()->deleteAll("activity_id in($did)");
			
			if ($count>0)
			{
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Activity/activity_list"));
			}
			else
			{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$count_sql = "SELECT count(*) count FROM `vcos_activity`";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT * FROM `vcos_activity` 
		LIMIT {$criteria->offset}, 10";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('activity_list',array('pages'=>$pager,'auth'=>$this->auth,'activity'=>$activity));
	}
	
	/**活动添加**/
	public function actionActivity_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$activity = new VcosActivity();
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$time = explode(" - ", $_POST['time']);
			$s_time = $time[0] . ' ' . $_POST['stime'];
			$e_time = $time[1] . ' ' . $_POST['etime'];
			$stime = date('Y/m/d H:i:s',strtotime($s_time));
			$etime = date('Y/m/d H:i:s',strtotime($e_time));
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'activity_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'activity_images/'.Yii::app()->params['month'].'/'.$photo;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$show = isset($_POST['show'])?$_POST['show']:'0';
			$show_head = isset($_POST['show_head'])?$_POST['show_head']:'0';
			$create_times = date("Y/m/d H:i:s",time());
			$cruise_id = Yii::app()->params['cruise_id'];
			$this_user_id = Yii::app()->user->id;
			$this_user_name = Yii::app()->user->name;
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$activity->activity_name = $name;
				$activity->activity_desc = $desc;
				$activity->activity_img = $photo_url;
				$activity->start_time = $stime;
				$activity->end_time = $etime;
				$activity->status = $state;
				$activity->created = $create_times;
				$activity->creator = $this_user_name;
				$activity->creator_id = $this_user_id;
				$activity->is_show_category = $show;
				$activity->is_show_head = $show_head;
				$activity->cruise_id = $cruise_id;
				$activity->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Activity/activity_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		
		$this->render('activity_add',array('activity'=>$activity));
	}
	
	/**活动编辑**/
	public function actionActivity_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$activity= VcosActivity::model()->findByPk($id);
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$time = explode(" - ", $_POST['time']);
			$s_time = $time[0] . ' ' . $_POST['stime'];
			$e_time = $time[1] . ' ' . $_POST['etime'];
			$stime = date('Y/m/d H:i:s',strtotime($s_time));
			$etime = date('Y/m/d H:i:s',strtotime($e_time));
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'activity_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'activity_images/'.Yii::app()->params['month'].'/'.$photo;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$show = isset($_POST['show'])?$_POST['show']:'0';
			$show_head = isset($_POST['show_head'])?$_POST['show_head']:'0';
			$create_times = date("Y/m/d H:i:s",time());
			$cruise_id = Yii::app()->params['cruise_id'];
			$this_user_id = Yii::app()->user->id;
			$this_user_name = Yii::app()->user->name;
				
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$activity->activity_name = $name;
				$activity->activity_desc = $desc;
				$activity->start_time = $stime;
				$activity->end_time = $etime;
				$activity->status = $state;
				$activity->created = $create_times;
				$activity->creator = $this_user_name;
				$activity->creator_id = $this_user_id;
				$activity->is_show_category = $show;
				$activity->is_show_head = $show_head;
				$activity->cruise_id = $cruise_id;
				if($photo){
					$activity->activity_img = $photo_url;
				}
				$activity->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Activity/activity_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$this->render('activity_edit',array('activity'=>$activity));
	}
	
	/**活动分类列表**/
	public function actionActivity_category_list(){
		$this->setauth();//检查有无权限
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosActivityCategory::model()->deleteAll("activity_cid in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Activity/activity_category_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosActivityCategory::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Activity/activity_category_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['activity'])){
			$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE  activity_id=".$_GET['activity'];
			$activity_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		}else{
			$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1 LIMIT 1";
			$activity_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		}
		$activity_but = $activity_first['activity_id'];
		
		$activity_id = isset($_GET['activity'])?$_GET['activity']:$activity_first['activity_id'];
		
		$activity_but =$activity_id;
		
		
		$count_sql = "SELECT count(*) count FROM `vcos_activity_category` a
		LEFT JOIN `vcos_activity` b ON a.activity_id = b.activity_id 
		WHERE b.status=1 AND a.activity_id=".$activity_id;
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.activity_name FROM `vcos_activity_category` a
		LEFT JOIN `vcos_activity` b ON a.activity_id = b.activity_id 
		WHERE  b.status=1 AND a.activity_id=".$activity_id." 
		LIMIT {$criteria->offset}, 10";
		$activity_category = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity`";
		$activity_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('activity_category_list',array('activity_but'=>$activity_but,'activity_sel'=>$activity_sel,'pages'=>$pager,'auth'=>$this->auth,'activity_category'=>$activity_category));
	}
	
	/**添加活动分类**/
	public function actionActivity_category_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$activity_category = new VcosActivityCategory();
		if($_POST){
			$activity = isset($_POST['activity'])?$_POST['activity']:0;
			$name = isset($_POST['name'])?$_POST['name']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$activity_category->activity_id = $activity;
				$activity_category->activity_category_name = $name;
				$activity_category->sort_order = $sort;
				$activity_category->status = $state;
				$activity_category->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Activity/activity_category_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('activity_category_add',array('activity'=>$activity,'activity_category'=>$activity_category));
	}
	
	/**编辑活动分类**/
	public function actionActivity_category_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$activity_category= VcosActivityCategory::model()->findByPk($id);
		if($_POST){
			$activity = isset($_POST['activity'])?$_POST['activity']:0;
			$name = isset($_POST['name'])?$_POST['name']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$activity_category->activity_id = $activity;
				$activity_category->activity_category_name = $name;
				$activity_category->sort_order = $sort;
				$activity_category->status = $state;
				$activity_category->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Activity/activity_category_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('activity_category_edit',array('activity_category'=>$activity_category,'activity'=>$activity));
	}
	
	/**活动商品列表**/
	public function actionActivity_product_list(){
		$this->setauth();//检查有无权限
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosActivityProduct::model()->deleteAll("id in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Activity/activity_product_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosActivityProduct::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Activity/activity_product_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['activity'])){
			$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE  activity_id=".$_GET['activity'];
			$activity_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		}else{
			$sql = "SELECT activity_id,activity_name FROM `vcos_activity` LIMIT 1";
			$activity_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		}
		$activity_but = $activity_first['activity_id'];
		$type_but = 0;
		
		$activity_id = isset($_GET['activity'])?$_GET['activity']:$activity_first['activity_id'];
		$type_id = isset($_GET['type'])?$_GET['type']:0;
		
		$sql = "call fun_activity_product_t1($activity_id,$type_id)";
		$activity_product = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		$activity_but =$activity_id;
		$type_but = $type_id;
		
		$criteria = new CDbCriteria();
		$count = count($activity_product);
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity`";
		$activity_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		$this->render('activity_product_list',array('activity_but'=>$activity_but,'type_but'=>$type_but,'activity_sel'=>$activity_sel,'activity_first_name'=>$activity_first,'pages'=>$pager,'auth'=>$this->auth,'activity_product'=>$activity_product));
	}
	
	/**活动商品添加**/
	public function actionActivity_product_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$activity_product = new VcosActivityProduct();
		if($_POST){
			$activicty = isset($_POST['activity'])?$_POST['activity']:0;
			$product = isset($_POST['product'])?$_POST['product']:0;
			$shop = isset($_POST['shop'])?$_POST['shop']:0;
			$activity_child = isset($_POST['activity_child'])?$_POST['activity_child']:0;
			$activity_category = isset($_POST['activity_category'])?$_POST['activity_category']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'';
			$product_type = isset($_POST['product_type'])?$_POST['product_type']:0;
			if($product_type == 3){
				$product_shop = $shop;
				$activity_category = '';
			}elseif($product_type ==6){
				$product_shop = $product;
				$activity_category = $activity_category;
			}elseif($product_type == 4){
				$product_shop = $activity_child;
				$activity_category = '';
			}
			$time = explode(" - ", $_POST['time']);
			$s_time = $time[0] . ' ' . $_POST['stime'];
			$e_time = $time[1] . ' ' . $_POST['etime'];
			$stime = date('Y/m/d H:i:s',strtotime($s_time));
			$etime = date('Y/m/d H:i:s',strtotime($e_time));
			
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$activity_product->activity_id = $activicty;
				$activity_product->product_id = $product_shop;
				$activity_product->activity_cid = $activity_category;
				$activity_product->sort_order = $sort;
				$activity_product->start_show_time = $stime;
				$activity_product->end_show_time = $etime;
				$activity_product->product_type = $product_type;
				$activity_product->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Activity/activity_product_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE status=1 AND category_code=".$layer_3[0]['category_code'];
		$product = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT activity_cid,activity_category_name FROM `vcos_activity_category` WHERE status=1 AND activity_id = ".$activity[0]['activity_id'];
		$activity_category = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop` ";
		$shop = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE activity_id !=".$activity[0]['activity_id'];
		$activity_child = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('activity_product_add',array('activity_child'=>$activity_child,'shop'=>$shop,'activity'=>$activity,'product'=>$product,'activity_category'=>$activity_category,'activity_product'=>$activity_product,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**活动商品编辑**/
	public function actionActivity_product_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$layer_cat = '';
		$layer_cat2 = '';
		$layer_1 = '';
		$layer_2 = '';
		$layer_3 = '';
		$product_sel = '';
		$category_code = '';
		$activity_product= VcosActivityProduct::model()->findByPk($id);
		if($_POST){
			$activicty = isset($_POST['activity'])?$_POST['activity']:0;
			$product = isset($_POST['product'])?$_POST['product']:0;
			$shop = isset($_POST['shop'])?$_POST['shop']:0;
			$activity_child = isset($_POST['activity_child'])?$_POST['activity_child']:0;
			$activity_category = isset($_POST['activity_category'])?$_POST['activity_category']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'';
			$product_type = isset($_POST['product_type'])?$_POST['product_type']:0;
			$time = explode(" - ", $_POST['time']);
			$s_time = $time[0] . ' ' . $_POST['stime'];
			$e_time = $time[1] . ' ' . $_POST['etime'];
			$stime = date('Y/m/d H:i:s',strtotime($s_time));
			$etime = date('Y/m/d H:i:s',strtotime($e_time));
			if($product_type == 3){
				$product_shop = $shop;
				$activity_category = '';
			}elseif($product_type ==6){
				$product_shop = $product;
				$activity_category = $activity_category;
			}elseif($product_type == 4){
				$product_shop = $activity_child;
				$activity_category = '';
			}
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$activity_product->activity_id = $activicty;
				$activity_product->product_id = $product_shop;
				$activity_product->activity_cid = $activity_category;
				$activity_product->sort_order = $sort;
				$activity_product->start_show_time = $stime;
				$activity_product->end_show_time = $etime;
				$activity_product->product_type = $product_type;
				$activity_product->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Activity/activity_product_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		//$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE status=1";
		//$product = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT activity_cid,activity_category_name FROM `vcos_activity_category` WHERE status=1 AND activity_id = ".$activity_product['activity_id'];
		$activity_category = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop` ";
		$shop = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE activity_id !=".$activity[0]['activity_id'];
		$activity_child = Yii::app()->p_db->createCommand($sql)->queryAll();
		if($activity_product['product_type'] == 6){
			$sql = "SELECT category_code FROM `vcos_product` WHERE product_id=".$activity_product['product_id'];
			$category_code = Yii::app()->p_db->createCommand($sql)->queryRow();
			$category_code = $category_code['category_code'];
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code =".$category_code;
			$layer_cat_2 = $p_db->createCommand($sql)->queryRow();
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code =".$layer_cat_2['parent_cid'];
			$layer_cat_1 = $p_db->createCommand($sql)->queryRow();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
			$layer_1 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_cat_1['parent_cid'];
			$layer_2 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_cat_2['parent_cid'];
			$layer_3 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE category_code=".$category_code;
			$product = $p_db->createCommand($sql)->queryAll();
			$layer_cat = $layer_cat_1['parent_cid'];
			$layer_cat2 = $layer_cat_2['parent_cid'];
		}else{
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
			$layer_1 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
			$layer_2 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
			$layer_3 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT product_id,product_name,category_code FROM `vcos_product` WHERE status=1 AND category_code=".$layer_3[0]['category_code'];
			$product = Yii::app()->p_db->createCommand($sql)->queryAll();
		}
		$this->render('activity_product_edit',array('activity_child'=>$activity_child,'shop'=>$shop,'activity'=>$activity,'product'=>$product,'activity_category'=>$activity_category,'activity_product'=>$activity_product,'layer_cat'=>$layer_cat,'layer_cat2'=>$layer_cat2,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3,'category_code'=>$category_code));
	}
	
	/**活动商品：获取二级分类**/
	public function actionGetCategoryChild(){
		$p_db = Yii::app()->p_db;
		$parent_code = isset($_GET['parent_code'])?$_GET['parent_code']:0;
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$parent_code;
		$resutl = $p_db->createCommand($sql)->queryAll();
		if($resutl){
			echo json_encode($resutl);
		}  else {
			echo 0;
		}
	}
	
	/**活动商品，三级分类下的商品**/
	public function actionGetCategoryProduct(){
		$p_db = Yii::app()->p_db;
		$parent_code = isset($_GET['parent_code'])?$_GET['parent_code']:0;
		$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE category_code=".$parent_code;
		$resutl = $p_db->createCommand($sql)->queryAll();
		if($resutl){
			echo json_encode($resutl);
		}  else {
			echo 0;
		}
	}
	
	/**活动商品，除本活动下的其他活动**/
	public function actionGetActivityChild(){
		$p_db = Yii::app()->p_db;
		$parent_id = isset($_GET['parent_id'])?$_GET['parent_id']:0;
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE activity_id!=".$parent_id;
		$resutl = $p_db->createCommand($sql)->queryAll();
		if($resutl){
			echo json_encode($resutl);
		}  else {
			echo 0;
		}
	}
	
	/**活动商品，根据活动查询该活动下的分类**/
	public function actionGetActivityCategory(){
		$p_db = Yii::app()->p_db;
		$parent_id = isset($_GET['parent_id'])?$_GET['parent_id']:0;
		$sql = "SELECT activity_cid,activity_category_name FROM `vcos_activity_category` WHERE activity_id=".$parent_id;
		$resutl = $p_db->createCommand($sql)->queryAll();
		if($resutl){
			echo json_encode($resutl);
		}  else {
			echo 0;
		}
	}
}