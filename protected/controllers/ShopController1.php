<?php
class ShopController extends Controller
{
	
	
	public function actionShop_detail()
	{
		$this->render('shop_detail');
	}
	
	/**店铺列表**/
	public function actionShop_list(){
		$this->setauth();//检查有无权限
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			
			$count = VcosShop::model()->deleteAll("shop_id in($ids)");
			$count1 = VcosShopBrand::model()->deleteAll("shop_id in($ids)");
			$count2 = VcosShopCategory::model()->deleteAll("shop_id in($ids)");
			
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Shop/shop_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			
			$count=VcosShop::model()->deleteByPk($did);
			$count1 = VcosShopBrand::model()->deleteAll("shop_id in($did)");
			$count2 = VcosShopCategory::model()->deleteAll("shop_id in($did)");
			
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Shop/shop_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$count_sql = "SELECT count(*) count FROM `vcos_shop`";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT * FROM `vcos_shop`
		LIMIT {$criteria->offset}, 10";
		$shop = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('shop_list',array('pages'=>$pager,'auth'=>$this->auth,'shop'=>$shop));
	}
	
	/**添加店铺**/
	public function actionShop_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$shop = new VcosShop();
		if($_POST){
			$code = isset($_POST['code'])?$_POST['code']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$people = isset($_POST['people'])?$_POST['people']:'';
			$company = isset($_POST['company'])?$_POST['company']:'';
			$address = isset($_POST['address'])?$_POST['address']:'';
			$price = isset($_POST['price'])?$_POST['price']*100:'';
			$products = isset($_POST['products'])?$_POST['products']:'';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'shop_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'shop_images/'.Yii::app()->params['month'].'/'.$photo;
			$photo1='';
			if($_FILES['photo1']['error']!=4){
				$result=Helper::upload_file('photo1', Yii::app()->params['img_save_url'].'shop_images/'.Yii::app()->params['month'], 'image', 3);
				$photo1=$result['filename'];
			}
			$photo_url1 = 'shop_images/'.Yii::app()->params['month'].'/'.$photo1;
			$photo2='';
			if($_FILES['photo2']['error']!=4){
				$result=Helper::upload_file('photo2', Yii::app()->params['img_save_url'].'shop_images/'.Yii::app()->params['month'], 'image', 3);
				$photo2=$result['filename'];
			}
			$photo_url2 = 'shop_images/'.Yii::app()->params['month'].'/'.$photo2;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$create_times = date("Y/m/d H:i:s",time());
			$cruise_id = Yii::app()->params['cruise_id'];
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$shop->shop_code = $code;
				$shop->shop_title = $name;
				$shop->shop_logo = $photo_url;
				$shop->business_license = $photo_url1;
				$shop->shop_img_url = $photo_url2;
				$shop->shop_desc = $desc;
				$shop->legal_representative = $people;
				$shop->company_name = $company;
				$shop->shop_address = $address;
				$shop->cash_deposit = $price;
				$shop->main_products = $products;
				$shop->created = $create_times;
				$shop->shop_status = $state;
				$shop->cruise_id = $cruise_id;
				$shop->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Shop/shop_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		
		$this->render('shop_add',array('shop'=>$shop));
	}
	
	/**编辑店铺**/
	public function actionShop_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$shop= VcosShop::model()->findByPk($id);
		if($_POST){
			$code = isset($_POST['code'])?$_POST['code']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$people = isset($_POST['people'])?$_POST['people']:'';
			$company = isset($_POST['company'])?$_POST['company']:'';
			$address = isset($_POST['address'])?$_POST['address']:'';
			$price = isset($_POST['price'])?$_POST['price']*100:'';
			$products = isset($_POST['products'])?$_POST['products']:'';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'shop_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo1='';
			if($_FILES['photo1']['error']!=4){
				$result=Helper::upload_file('photo1', Yii::app()->params['img_save_url'].'shop_images/'.Yii::app()->params['month'], 'image', 3);
				$photo1=$result['filename'];
			}
			$photo2='';
			if($_FILES['photo2']['error']!=4){
				$result=Helper::upload_file('photo2', Yii::app()->params['img_save_url'].'shop_images/'.Yii::app()->params['month'], 'image', 3);
				$photo1=$result['filename'];
			}
			$photo_url2 = 'shop_images/'.Yii::app()->params['month'].'/'.$photo2;
			$photo_url1 = 'shop_images/'.Yii::app()->params['month'].'/'.$photo1;
			$photo_url = 'shop_images/'.Yii::app()->params['month'].'/'.$photo;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$create_times = date("Y/m/d H:i:s",time());
			$cruise_id = Yii::app()->params['cruise_id'];
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$shop->shop_code = $code;
				$shop->shop_title = $name;
				if($photo){
				$shop->shop_logo = $photo_url;
				}
				if($photo1){
					$shop->business_license = $photo_url1;
				}
				if($photo2){
					$shop->shop_img_url = $photo_url2;
				}
				$shop->shop_desc = $desc;
				$shop->legal_representative = $people;
				$shop->company_name = $company;
				$shop->shop_address = $address;
				$shop->cash_deposit = $price;
				$shop->main_products = $products;
				$shop->created = $create_times;
				$shop->shop_status = $state;
				$shop->cruise_id = $cruise_id;
				$shop->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Shop/shop_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$this->render('shop_edit',array('shop'=>$shop));
	}
	
	
	/**店铺品牌列表**/
	Public function actionShop_brand_list(){
		$this->setauth();//检查有无权限
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosShopBrand::model()->deleteAll("shop_brand_id in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Shop/shop_brand_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosShopBrand::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Shop/shop_brand_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['shop']) && $_GET['shop'] != ''){
			$sql = "SELECT shop_id,shop_title FROM `vcos_shop` WHERE shop_id=".$_GET['shop'];
		}else{
			$sql = "SELECT shop_id,shop_title FROM `vcos_shop` LIMIT 1";
		}
		$shop_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		$shop_but = $shop_first['shop_id'];
		
		$count_sql = "SELECT count(*) count FROM `vcos_shop_brand` a
		LEFT JOIN `vcos_shop` b ON a.shop_id = b.shop_id
		LEFT JOIN `vcos_brand` c ON a.brand_id = c.brand_id
		WHERE c.brand_status = 1 AND b.shop_status=1 AND a.shop_id=".$shop_but." ORDER BY a.shop_id DESC";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.shop_brand_id,a.sort_order,b.shop_title,c.brand_cn_name FROM `vcos_shop_brand` a
		LEFT JOIN `vcos_shop` b ON a.shop_id = b.shop_id
		LEFT JOIN `vcos_brand` c ON a.brand_id = c.brand_id
		WHERE c.brand_status = 1 AND b.shop_status=1 AND a.shop_id=".$shop_but." ORDER BY a.shop_id DESC
		LIMIT {$criteria->offset}, 10";
		$shop_brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop`";
		$shop_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('shop_brand_list',array('shop_but'=>$shop_but,'shop_sel'=>$shop_sel,'pages'=>$pager,'auth'=>$this->auth,'shop_brand'=>$shop_brand));
	}
	
	/**店铺品牌添加**/
	Public function actionShop_brand_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$shop_brand = new VcosShopBrand();
		if($_POST){
			$shop = isset($_POST['shop'])?$_POST['shop']:0;
			$brand = isset($_POST['brand'])?$_POST['brand']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'';
			
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$shop_brand->shop_id = $shop;
				$shop_brand->brand_id = $brand;
				$shop_brand->sort_order = $sort;
				$shop_brand->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Shop/shop_brand_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop` WHERE shop_status=1";
		$shop = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT brand_id,brand_cn_name FROM `vcos_brand` WHERE brand_status=1";
		$brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('shop_brand_add',array('shop'=>$shop,'brand'=>$brand,'shop_brand'=>$shop_brand));
	}
	
	
	/**店铺品牌编辑**/
	public function actionShop_brand_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$shop_brand= VcosShopBrand::model()->findByPk($id);
		if($_POST){
			$shop = isset($_POST['shop'])?$_POST['shop']:0;
			$brand = isset($_POST['brand'])?$_POST['brand']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:'';
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$shop_brand->shop_id = $shop;
				$shop_brand->brand_id = $brand;
				$shop_brand->sort_order = $sort;
				$shop_brand->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Shop/Shop_brand_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop` WHERE shop_status=1";
		$shop = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT brand_id,brand_cn_name FROM `vcos_brand` WHERE brand_status=1";
		$brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('shop_brand_edit',array('shop'=>$shop,'brand'=>$brand,'shop_brand'=>$shop_brand));
	}
	
	
	/**店铺分类列表**/
	public function actionShop_category_list(){
		$this->setauth();//检查有无权限
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosShopCategory::model()->deleteAll("shop_cid in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Shop/shop_category_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosShopCategory::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Shop/shop_category_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['shop']) && $_GET['shop'] != ''){
			$sql = "SELECT shop_id,shop_title FROM `vcos_shop` WHERE shop_id=".$_GET['shop'];
		}else{
			$sql = "SELECT shop_id,shop_title FROM `vcos_shop` LIMIT 1";
		}
		$shop_first = Yii::app()->p_db->createCommand($sql)->queryRow();
		$shop_but = $shop_first['shop_id'];
		
		$count_sql = "SELECT count(*) count FROM `vcos_shop_category` a
		LEFT JOIN `vcos_shop` b ON a.shop_id = b.shop_id
		LEFT JOIN `vcos_category` c ON a.category_code = c.category_code
		WHERE a.shop_id=".$shop_but."
		ORDER BY a.shop_id DESC";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.shop_title,c.name FROM `vcos_shop_category` a
		LEFT JOIN `vcos_shop` b ON a.shop_id = b.shop_id
		LEFT JOIN `vcos_category` c ON a.category_code = c.category_code
		WHERE a.shop_id=".$shop_but."
		ORDER BY a.shop_id DESC LIMIT {$criteria->offset}, 10";
		$shop_category = Yii::app()->p_db->createCommand($sql)->queryAll();
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop`";
		$shop_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('shop_category_list',array('shop_but'=>$shop_but,'shop_sel'=>$shop_sel,'pages'=>$pager,'auth'=>$this->auth,'shop_category'=>$shop_category));
	}
	
	/**添加店铺分类**/
	public function actionShop_category_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$shop_category = new VcosShopCategory();
		if($_POST){
			$shop = isset($_POST['shop'])?$_POST['shop']:'0';
			$category = isset($_POST['category_3'])?$_POST['category_3']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:0;
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$shop_category->shop_id = $shop;
				$shop_category->category_code = $category;
				$shop_category->sort_order = $sort;
				$shop_category->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Shop/shop_category_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT shop_id,shop_title from `vcos_shop` WHERE shop_status=1";
		$shop = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$this->render('shop_category_add',array('shop'=>$shop,'shop_category'=>$shop_category,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**编辑店铺分类**/
	public function actionShop_category_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$shop_category= VcosShopCategory::model()->findByPk($id);
		if($_POST){
			$shop = isset($_POST['shop'])?$_POST['shop']:'0';
			$category = isset($_POST['category_3'])?$_POST['category_3']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:0;
			
				
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$shop_category->shop_id = $shop;
				$shop_category->category_code = $category;
				$shop_category->sort_order = $sort;
				$shop_category->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Shop/shop_category_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$category_code = $shop_category['category_code'];
		$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code =".$category_code;
		$layer_cat_2 = $p_db->createCommand($sql)->queryRow();
		$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code =".$layer_cat_2['parent_cid'];
		$layer_cat_1 = $p_db->createCommand($sql)->queryRow();
		$sql = "SELECT shop_id,shop_title from `vcos_shop` WHERE shop_status=1";
		$shop = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_cat_1['parent_cid'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_cat_2['parent_cid'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$this->render('shop_category_edit',array('shop'=>$shop,'layer_cat'=>$layer_cat_1['parent_cid'],'layer_cat2'=>$layer_cat_2['parent_cid'],'shop_category'=>$shop_category,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**商品：获取二级分类**/
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
	
	
	
}