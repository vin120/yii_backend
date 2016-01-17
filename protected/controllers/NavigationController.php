<?php
class NavigationController extends Controller
{
	/**导航列表**/
	public function actionNavigation_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->p_db;
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$str_group = '';   //获取将要删除navigation_group表的id
			$nav_group = VcosNavigationGroup::model()->findAll("navigation_id in($ids)");
			foreach($nav_group as $la2){
				$str_group .= $la2['navigation_group_id'].',';
			}
			$str_group = trim($str_group,',');
			//var_dump($str_group);
			//exit;
			//$count = VcosNavigation::model()->deleteAll("navigation_id in($ids)");
			$count = $db->createCommand("UPDATE `vcos_navigation` set status=0 WHERE navigation_id in($ids)")->execute();
			//$count1 = VcosNavigationGroup::model()->deleteAll("navigation_id in($ids)");
			$sql = "UPDATE `vcos_navigation_group` set status=0 WHERE navigation_id in($ids)";
			$db->createCommand($sql)->execute();
			if($str_group != ''){
			//$count2 = VcosNavigationGroupCategory::model()->deleteAll("navigation_group_id in($str_group)");
			$db->createCommand("UPDATE `vcos_navigation_group_category` set status=0 WHERE navigation_group_id in($str_group)")->execute();
			//$count3 = VcosNavigationGroupBrand::model()->deleteAll("navigation_group_id in($str_group)");
			$db->createCommand("UPDATE `vcos_navigation_group_brand` set status=0 WHERE navigation_group_id in($str_group)")->execute();
			}
			//if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_list"));
			//}else{
				//Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$str_group = '';   //获取将要删除navigation_group表的id
			$nav_group = VcosNavigationGroup::model()->findAll("navigation_id in($did)");
			foreach($nav_group as $la2){
				$str_group .= $la2['navigation_group_id'].',';
			}
			$str_group = trim($str_group,',');
			
			//$count=VcosNavigation::model()->deleteByPk($did);
			//$count1 = VcosNavigationGroup::model()->deleteAll("navigation_id in($did)");
			$count =  $db->createCommand("UPDATE `vcos_navigation` set status=0 WHERE navigation_id in($did)")->execute();
			$db->createCommand("UPDATE `vcos_navigation_group` set status=0 WHERE navigation_id in($did)")->execute();
			if($str_group != ''){
			//$count2 = VcosNavigationGroupCategory::model()->deleteAll("navigation_group_id in($str_group)");
			//$count3 = VcosNavigationGroupBrand::model()->deleteAll("navigation_group_id in($str_group)");
				$db->createCommand("UPDATE `vcos_navigation_group_category` set status=0 WHERE navigation_group_id in($str_group)")->execute();
				$db->createCommand("UPDATE `vcos_navigation_group_brand` set status=0 WHERE navigation_group_id in($str_group)")->execute();
			}
			//if ($count){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_list"));
			//}else{
			//	Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		
		
		$count_sql = "SELECT count(*) count FROM `vcos_navigation` a LEFT JOIN `vcos_activity` b ON a.activity_id=b.activity_id";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.activity_name FROM `vcos_navigation` a LEFT JOIN `vcos_activity` b ON a.activity_id=b.activity_id
		LIMIT {$criteria->offset}, 10";
		$navigation = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT navigation_id,navigation_name FROM `vcos_navigation` WHERE status=1";
		$navigation_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_list',array('pages'=>$pager,'auth'=>$this->auth,'navigation'=>$navigation));
	}
	
	/**导航添加**/
	public function actionNavigation_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$navigation = new VcosNavigation();
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$activity = isset($_POST['activity'])?$_POST['activity']:0;
			$nav_type = isset($_POST['nav_type'])?$_POST['nav_type']:'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$cruise_id = Yii::app()->params['cruise_id'];
			$show = isset($_POST['show'])?$_POST['show']:0;
			$set_cat = isset($_POST['set_cat'])?$_POST['set_cat']:0;
			$main = isset($_POST['main'])?$_POST['main']:0;
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation->activity_id = $activity;
				$navigation->navigation_name = $name;
				$navigation->sort_order = $sort;
				$navigation->status = $state;
				$navigation->navigation_style_type = $nav_type;
				$navigation->cruise_id = $cruise_id;
				$navigation->is_show = $show;
				$navigation->is_category = $set_cat;
				$navigation->is_main = $main;
				$navigation->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Navigation/navigation_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_add',array('navigation'=>$navigation,'activity'=>$activity));
	}
	
	/**导航编辑**/
	public function actionNavigation_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$navigation= VcosNavigation::model()->findByPk($id);
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$activity = isset($_POST['activity'])?$_POST['activity']:0;
			$nav_type = isset($_POST['nav_type'])?$_POST['nav_type']:'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$cruise_id = Yii::app()->params['cruise_id'];
			$show = isset($_POST['show'])?$_POST['show']:0;
			$set_cat = isset($_POST['set_cat'])?$_POST['set_cat']:0;
			$main = isset($_POST['main'])?$_POST['main']:0;
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation->activity_id = $activity;
				$navigation->navigation_name = $name;
				$navigation->sort_order = $sort;
				$navigation->status = $state;
				$navigation->navigation_style_type = $nav_type;
				$navigation->cruise_id = $cruise_id;
				$navigation->is_show = $show;
				$navigation->is_category = $set_cat;
				$navigation->is_main = $main;
				$navigation->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Navigation/navigation_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_edit',array('navigation'=>$navigation,'activity'=>$activity));
	}
	
	
	
	/**导航组列表**/
	public function actionNavigation_group_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->p_db;
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			//$count = VcosNavigationGroup::model()->deleteAll("navigation_group_id in('$ids')");
			//$count1 = VcosNavigationGroupCategory::model()->deleteAll("navigation_group_id in('$ids')");
			//$count2 = VcosNavigationGroupBrand::model()->deleteAll("navigation_group_id in('$ids')");
			$count = $db->createCommand("UPDATE `vcos_navigation_group` set status=0 WHERE navigation_group_id in('$ids')")->execute();
			$db->createCommand("UPDATE `vcos_navigation_group_category` set status=0 WHERE navigation_group_id in('$ids')")->execute();
			$db->createCommand("UPDATE `vcos_navigation_group_brand` set status=0 WHERE navigation_group_id in('$ids')")->execute();
			//if ($count){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_group_list"));
			//}else{
				//Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			//$count=VcosNavigationGroup::model()->deleteByPk($did);
			//$count1 = VcosNavigationGroupCategory::model()->deleteAll("navigation_group_id in('$did')");
			//$count1 = VcosNavigationGroupBrand::model()->deleteAll("navigation_group_id in('$did')");
			$count = $db->createCommand("UPDATE `vcos_navigation_group` set status=0 WHERE navigation_group_id in('$did')")->execute();
			$db->createCommand("UPDATE `vcos_navigation_group_category` set status=0 WHERE navigation_group_id in('$did')")->execute();
			$db->createCommand("UPDATE `vcos_navigation_group_brand` set status=0 WHERE navigation_group_id in('$did')")->execute();
			//if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_group_list"));
			//}else{
			//	Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		
		if(isset($_GET['navigation'])){
			$sql = "SELECT navigation_id,navigation_name FROM `vcos_navigation` WHERE navigation_id =".$_GET['navigation'];
		}else{
			$sql = "SELECT navigation_id,navigation_name FROM `vcos_navigation` LIMIT 1";
		}
		$navigation_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		$navigation_but = $navigation_first['navigation_id'];
		
		$count_sql = "SELECT count(*) count FROM `vcos_navigation_group` a LEFT JOIN `vcos_navigation` b ON a.navigation_id=b.navigation_id LEFT JOIN `vcos_activity` c ON a.activity_id = c.activity_id WHERE a.navigation_id=".$navigation_but;
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.navigation_name,c.activity_name FROM `vcos_navigation_group` a
		LEFT JOIN `vcos_navigation` b ON a.navigation_id = b.navigation_id
		LEFT JOIN `vcos_activity` c ON a.activity_id = c.activity_id
		WHERE a.navigation_id=".$navigation_but."
		ORDER BY a.navigation_id DESC
		LIMIT {$criteria->offset}, 10";
		$navigation_group = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT navigation_id,navigation_name FROM `vcos_navigation`";
		$navigation_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_list',array('navigation_sel'=>$navigation_sel,'navigation_but'=>$navigation_but,'pages'=>$pager,'auth'=>$this->auth,'navigation_group'=>$navigation_group));
	}
	
	/**导航组添加**/
	public function actionNavigation_group_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$navigation_group = new VcosNavigationGroup();
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$navigation = isset($_POST['navigation'])?$_POST['navigation']:0;
			$activity = isset($_POST['activity'])?$_POST['activity']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$group_type = isset($_POST['group_type'])?$_POST['group_type']:'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'navigation_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'navigation_images/'.Yii::app()->params['month'].'/'.$photo;
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation_group->navigation_group_name = $name;
				$navigation_group->navigation_id = $navigation;
				$navigation_group->activity_id = $activity;
				$navigation_group->img_url = $photo_url;
				$navigation_group->sort_order = $sort;
				$navigation_group->status = $state;
				$navigation_group->show_type = $group_type;
				$navigation_group->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Navigation/navigation_group_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT navigation_id,navigation_name FROM `vcos_navigation` WHERE is_category=1 AND status=1 ";
		$navigation = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_add',array('activity'=>$activity,'navigation'=>$navigation,'navigation_group'=>$navigation_group));
	}
	
	/**编辑导航组**/
	public function actionNavigation_group_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$navigation_group= VcosNavigationGroup::model()->findByPk($id);
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$navigation = isset($_POST['navigation'])?$_POST['navigation']:0;
			$activity = isset($_POST['activity'])?$_POST['activity']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$group_type = isset($_POST['group_type'])?$_POST['group_type']:'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'navigation_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'navigation_images/'.Yii::app()->params['month'].'/'.$photo;
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation_group->navigation_group_name = $name;
				$navigation_group->navigation_id = $navigation;
				$navigation_group->activity_id = $activity;
				$navigation_group->img_url = $photo_url;
				$navigation_group->sort_order = $sort;
				$navigation_group->status = $state;
				$navigation_group->show_type = $group_type;
				$navigation_group->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Navigation/navigation_group_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT activity_id,activity_name FROM `vcos_activity` WHERE status=1";
		$activity = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT navigation_id,navigation_name FROM `vcos_navigation` WHERE is_category=1 AND status=1";
		$navigation = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_edit',array('activity'=>$activity,'navigation'=>$navigation,'navigation_group'=>$navigation_group));
	}
	
	/**查看是否已经存在第一个显示的导航字段**/
	public function actionCheckIsMain(){
		$sql = "SELECT count(*) count FROM `vcos_navigation` WHERE is_main=1";
		$count = Yii::app()->p_db->createCommand($sql)->queryRow();
		if($count['count'] == 0){
			echo 0;
		}else{
			echo 1;
		}
	}
	/**取消已经是第一个的导航显示***/
	public function actionOffIsMain(){
		$sql = "Update `vcos_navigation` set is_mian=0 WHERE is_main=1";
		Yii::app()->p_db->createCommand($sql)->execute();
	}
	
	
	/**导航组分类列表**/
	public function actionNavigation_group_category_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->p_db;
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			//$count = VcosNavigationGroupCategory::model()->deleteAll("navigation_group_cid in('$ids')");
			$count = $db->createCommand("UPDATE `vcos_navigation_group_category` set status=0 WHERE navigation_group_cid in('$ids')")->execute();
			//if ($count){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_group_category_list"));
			//}else{
				//Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			//$count=VcosNavigationGroupCategory::model()->deleteByPk($did);
			$count = $db->createCommand("UPDATE `vcos_navigation_group_category` set status=0 WHERE navigation_group_cid in('$did')")->execute();
			//if ($count){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_group_category_list"));
			//}else{
			//	Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		
		if(isset($_GET['navigation_group'])){
			$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group` WHERE navigation_group_id=".$_GET['navigation_group'];
		}else{
			$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group` LIMIT 1";
		}
		$navigation_group_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		$navigation_group_but = $navigation_group_first['navigation_group_id'];
		
		$count_sql = "SELECT count(*) count FROM `vcos_navigation_group_category` a LEFT JOIN `vcos_navigation_group` b ON a.navigation_group_id=b.navigation_group_id WHERE a.navigation_group_id=".$navigation_group_but;
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.navigation_group_name FROM `vcos_navigation_group_category` a
		LEFT JOIN `vcos_navigation_group` b ON a.navigation_group_id=b.navigation_group_id
		WHERE a.navigation_group_id =".$navigation_group_but."
		LIMIT {$criteria->offset}, 10";
		$navigation_group_category = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group`";
		$navigation_group_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_category_list',array('navigation_group_but'=>$navigation_group_but,'navigation_group_sel'=>$navigation_group_sel,'pages'=>$pager,'auth'=>$this->auth,'navigation_group_category'=>$navigation_group_category));
	}
	
	/**导航组分类添加**/
	public function actionNavigation_group_category_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$navigation_group_category = new VcosNavigationGroupCategory();
		if($_POST){
			$navigation_group = isset($_POST['navigation_group'])?$_POST['navigation_group']:0;
			$name = isset($_POST['name'])?$_POST['name']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$highlight = isset($_POST['highlight'])?$_POST['highlight']:0;
			$type = isset($_POST['type'])?$_POST['type']:'0';
			if($type == 1){
				$mapping = isset($_POST['mapping'])?$_POST['mapping']:'';
				$mapping = trim($mapping,',');
			}else{
				$mapping = isset($_POST['one_sel'])?$_POST['one_sel']:'';
			}
			//$mapping = isset($_POST['mapping'])?$_POST['mapping']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation_group_category->navigation_group_id = $navigation_group;
				$navigation_group_category->navigation_category_name = $name;
				$navigation_group_category->sort_order = $sort;
				$navigation_group_category->is_highlight = $highlight;
				$navigation_group_category->category_type = $type;
				$navigation_group_category->mapping_id = $mapping;
				$navigation_group_category->status = $state;
				$navigation_group_category->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Navigation/navigation_group_category_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT * FROM `vcos_navigation_group` WHERE status=1";
		$navigation_group = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=0";
		$cat_1 = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_category_add',array('cat_1'=>$cat_1,'navigation_group'=>$navigation_group,'navigation_group_category'=>$navigation_group_category));
	}	
	
	/**导航组分类编辑**/
	public function actionNavigation_group_category_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$navigation_group_category= VcosNavigationGroupCategory::model()->findByPk($id);
		if($_POST){
			$navigation_group = isset($_POST['navigation_group'])?$_POST['navigation_group']:0;
			$name = isset($_POST['name'])?$_POST['name']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$highlight = isset($_POST['highlight'])?$_POST['highlight']:0;
			$type = isset($_POST['type'])?$_POST['type']:'0';
			if($type == 1){
				$mapping = isset($_POST['mapping'])?$_POST['mapping']:'';
				$mapping = trim($mapping,',');
			}else{
				$mapping = isset($_POST['one_sel'])?$_POST['one_sel']:'';
			}
			//$mapping = isset($_POST['mapping'])?$_POST['mapping']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation_group_category->navigation_group_id = $navigation_group;
				$navigation_group_category->navigation_category_name = $name;
				$navigation_group_category->sort_order = $sort;
				$navigation_group_category->is_highlight = $highlight;
				$navigation_group_category->category_type = $type;
				$navigation_group_category->mapping_id = $mapping;
				$navigation_group_category->status = $state;
				$navigation_group_category->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Navigation/navigation_group_category_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT * FROM `vcos_navigation_group` WHERE status=1";
		$navigation_group = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=0";
		$cat_1 = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this_type_val = $navigation_group_category['category_type'];
		$type_cat = '';
		$cat2_val = '';
		$cat1_val = '';
		$cat2_name = '';
		$checked_sel = '';
		if($this_type_val==2){
			$sql = "SELECT brand_id as val1,brand_cn_name as val2 FROM `vcos_brand` WHERE brand_status=1";
		}elseif($this_type_val==3){
			$sql = "SELECT shop_id as val1,shop_title as val2 FROM `vcos_shop`";
		}
		$type_cat = Yii::app()->p_db->createCommand($sql)->queryAll();
		if($this_type_val == 1){
			$this_code = $navigation_group_category['mapping_id'];
			$this_code = trim($this_code,',');
			$sql = "SELECT category_code,name from `vcos_category` WHERE category_code in ({$this_code})";
			$checked_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$this_code = explode(",",$this_code);
			$this_code = $this_code[0];
			$this_code_length = strlen($this_code);
			
			if($this_code_length == 7){
				//三级
				$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$this_code;
				$cat2_res = Yii::app()->p_db->createCommand($sql)->queryRow();
				$sql = "SELECT parent_cid,name FROM `vcos_category` WHERE category_code=".$cat2_res['parent_cid'];
				$cat1_res = Yii::app()->p_db->createCommand($sql)->queryRow();
				$cat1_val = $cat1_res['parent_cid'];
				$cat2_name = $cat1_res['name'];
				$cat2_val = $cat2_res['parent_cid'];
			}else{
				//二级
				$sql = "SELECT parent_cid,name FROM `vcos_category` WHERE category_code=".$this_code;
				$cat1_res = Yii::app()->p_db->createCommand($sql)->queryRow();
				$cat2_name = $cat1_res['name'];
				$cat1_val = $cat1_res['parent_cid'];
				$cat2_val = $this_code;
				
			}
		$sql = "SELECT * from `vcos_category` WHERE parent_cid=0";
		$cat1_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT * from `vcos_category` WHERE parent_cid=".$cat1_val;
		$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT * from `vcos_category` WHERE parent_cid=".$cat2_val;
		$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}
		$this->render('navigation_group_category_edit',array('checked_sel'=>$checked_sel,'cat2_name'=>$cat2_name,'type_cat'=>$type_cat,'cat1_val'=>$cat1_val,'cat2_val'=>$cat2_val,'cat1_sel'=>$cat1_sel,'cat2_sel'=>$cat2_sel,'cat3_sel'=>$cat3_sel,'navigation_group'=>$navigation_group,'navigation_group_category'=>$navigation_group_category));
	}
	
	
	/**导航组分类：通过选择分类类型，对应列出分类类型名称
	 * @type==2:品牌
	 * @type==3:店铺
	 * **/
	public function actionCategoryTypeGetChild(){
		$type = isset($_GET['type'])?$_GET['type']:0;
		$result = '';
		if($type==2){
			$sql = "SELECT brand_id as val1,brand_cn_name as val2 FROM `vcos_brand` WHERE brand_status=1";
		}else if($type == 3){
			$sql = "SELECT shop_id as val1,shop_title as val2 FROM `vcos_shop`";
		}
		$result = Yii::app()->p_db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	/**根据分类父级code获取分类**/
	public function actionGetCategoryChild(){
		$code = isset($_GET['code'])?$_GET['code']:0;
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$code;
		$result = Yii::app()->p_db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	/**导航组品牌列表**/
	public function actionNavigation_group_brand_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->p_db;
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			//$count = VcosNavigationGroupBrand::model()->deleteAll("navigation_group_bid in('$ids')");
			$count = $db->createCommand("UPDATE `vcos_navigation_group_brand` set status=0 WHERE navigation_group_bid in('$ids')")->execute();
			//if ($count){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_group_brand_list"));
			//}else{
			//	Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			//$count=VcosNavigationGroupBrand::model()->deleteByPk($did);
			$count = $db->createCommand("UPDATE `vcos_navigation_group_brand` set status=0 WHERE navigation_group_bid in('$did')")->execute();
			//if ($count){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Navigation/navigation_group_brand_list"));
				
			//}else{
				//Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		if(isset($_GET['navigation_group'])){
			$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group` WHERE navigation_group_id=".$_GET['navigation_group'];
		}else{
			$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group` LIMIT 1";
		}
		$navigation_group_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		$navigation_group_but = $navigation_group_first['navigation_group_id'];
		
		$count_sql = "SELECT count(*) count FROM `vcos_navigation_group_brand` a LEFT JOIN `vcos_navigation_group` b ON a.navigation_group_id=b.navigation_group_id LEFT JOIN `vcos_brand` c ON a.brand_id=c.brand_id WHERE a.navigation_group_id=".$navigation_group_but;
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.navigation_group_name,c.brand_cn_name FROM `vcos_navigation_group_brand` a
		LEFT JOIN `vcos_navigation_group` b ON a.navigation_group_id=b.navigation_group_id
		LEFT JOIN `vcos_brand` c ON a.brand_id=c.brand_id
		WHERE a.navigation_group_id=".$navigation_group_but."
		LIMIT {$criteria->offset}, 10";
		$navigation_group_brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group`";
		$navigation_group_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_brand_list',array('navigation_group_sel'=>$navigation_group_sel,'navigation_group_but'=>$navigation_group_but,'pages'=>$pager,'auth'=>$this->auth,'navigation_group_brand'=>$navigation_group_brand));
	}
	
	/**导航组品牌添加**/
	public function actionNavigation_group_brand_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$navigation_group_brand = new VcosNavigationGroupBrand();
		if($_POST){
			$navigation = isset($_POST['navigation'])?$_POST['navigation']:0;
			$brand = isset($_POST['brand'])?$_POST['brand']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation_group_brand->navigation_group_id = $navigation;
				$navigation_group_brand->brand_id = $brand;
				$navigation_group_brand->sort_order = $sort;
				$navigation_group_brand->status = $state;
				$navigation_group_brand->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Navigation/navigation_group_brand_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group` WHERE status=1";
		$navigation_group = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT brand_id,brand_cn_name FROM `vcos_brand` WHERE brand_status=1";
		$brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_brand_add',array('brand'=>$brand,'navigation_group'=>$navigation_group,'navigation_group_brand'=>$navigation_group_brand));
	}
	
	/**导航组品牌编辑**/
	public function actionNavigation_group_brand_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$navigation_group_brand= VcosNavigationGroupBrand::model()->findByPk($id);
		if($_POST){
			$navigation = isset($_POST['navigation'])?$_POST['navigation']:0;
			$brand = isset($_POST['brand'])?$_POST['brand']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$navigation_group_brand->navigation_group_id = $navigation;
				$navigation_group_brand->brand_id = $brand;
				$navigation_group_brand->sort_order = $sort;
				$navigation_group_brand->status = $state;
				$navigation_group_brand->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Navigation/navigation_group_brand_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT navigation_group_id,navigation_group_name FROM `vcos_navigation_group` WHERE status=1";
		$navigation_group = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT brand_id,brand_cn_name FROM `vcos_brand` WHERE brand_status=1";
		$brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('navigation_group_brand_edit',array('brand'=>$brand,'navigation_group'=>$navigation_group,'navigation_group_brand'=>$navigation_group_brand));
	}
}
