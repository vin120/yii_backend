<?php
class ProductController extends Controller
{
	/**商品列表**/
	public function actionProduct_list(){
		$this->setauth();//检查有无权限
		
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosProduct::model()->deleteAll("product_id in($ids)");
			$count1 = VcosProductDetail::model()->deleteAll("product_id in($ids)");
			$count2 = VcosProductImg::model()->deleteAll("product_id in($ids)");
			//$count3 = VcosActivityProduct::model()->deleteAll("product_id in($ids) AND product_type=6");
			$count4 = VcosProductGraphic::model()->deleteAll("product_id in($ids)");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosProduct::model()->deleteByPk($did);
			$count1 = VcosProductDetail::model()->deleteAll("product_id in($did)");
			$count2 = VcosProductImg::model()->deleteAll("product_id in($did)");
			//$count3 = VcosActivityProduct::model()->deleteAll("product_id in($did) AND product_type=6");
			$count4 = VcosProductGraphic::model()->deleteAll("product_id in($did)");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$cat1_but='';
		$cat2_but='';
		$cat3_but='';
		if(isset($_GET['cat3_all_sel']) && $_GET['cat3_all_sel']!=''){
			$code_id = $_GET['cat3_all_sel'];
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code_id;
			$code1_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code1_sel['parent_cid'];
			$code2_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			
			$cat1_but = $code2_sel['parent_cid'];
			$cat2_but = $code1_sel['parent_cid'];
			$cat3_but = $code_id;
			
			$where = "a.category_code='".$code_id."'";
		}else{
			/*$sql = "select category_code from vcos_category where length(category_code) = 7 ORDER BY category_code limit 1";
			$code_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			$code_id = $code_sel['category_code'];
			$code_id = 1;*/
			$where = 1;
		}
		
		//WHERE a.category_code='".$code_id."'
		$count_sql = "SELECT count(*) count FROM `vcos_product` a
		LEFT JOIN `vcos_shop` b ON a.shop_id = b.shop_id
		LEFT JOIN `vcos_brand` c ON a.brand_id = c.brand_id
		LEFT JOIN `vcos_category` d ON a.category_code = d.category_code
		WHERE ".$where."
		ORDER BY a.shop_id DESC";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		//WHERE a.category_code='".$code_id."'
		$sql = "SELECT a.status,a.product_id,a.product_name,a.origin,a.product_code,a.product_desc,a.product_img,b.shop_title,c.brand_cn_name,d.name FROM `vcos_product` a
		LEFT JOIN `vcos_shop` b ON a.shop_id = b.shop_id
		LEFT JOIN `vcos_brand` c ON a.brand_id = c.brand_id
		LEFT JOIN `vcos_category` d ON a.category_code = d.category_code
		WHERE ".$where."
		ORDER BY a.shop_id DESC LIMIT {$criteria->offset}, 10";
		$product = Yii::app()->p_db->createCommand($sql)->queryAll();

		/**分类筛选**/
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=0";
		$cat1_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		if(!isset($_GET['cat3_all_sel'])){
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_sel[0]['category_code'];
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_sel[0]['category_code'];
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}else{
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_but;
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_but;
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}
		$this->render('product_list',array('cat1_but'=>$cat1_but,'cat2_but'=>$cat2_but,'cat3_but'=>$cat3_but,'cat1_sel'=>$cat1_sel,'cat2_sel'=>$cat2_sel,'cat3_sel'=>$cat3_sel,'pages'=>$pager,'auth'=>$this->auth,'product'=>$product));
	}
	
	/**商品添加**/
	public function actionProduct_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$product = new VcosProduct();
		if($_POST){
			var_dump($_POST);exit;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$code = isset($_POST['code'])?$_POST['code']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$origin = isset($_POST['origin'])?$_POST['origin']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$num = isset($_POST['num'])?$_POST['num']:0;
			$price = isset($_POST['price'])?$_POST['price']*100:0;
			$mprice = isset($_POST['mprice'])?$_POST['mprice']*100:0;
			//$category = isset($_POST['category_3'])?$_POST['category_3']:0;
			$category = isset($_POST['category'])?$_POST['category']:0;
			$shop = isset($_POST['shop'])?$_POST['shop']:0;
			$brand = isset($_POST['brand'])?$_POST['brand']:0;
			$time = explode(" - ", $_POST['time']);
			$s_time = $time[0] . ' ' . $_POST['stime'];
			$e_time = $time[1] . ' ' . $_POST['etime'];
			$stime = date('Y/m/d H:i:s',strtotime($s_time));
			$etime = date('Y/m/d H:i:s',strtotime($e_time));
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'product_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'product_images/'.Yii::app()->params['month'].'/'.$photo;
			$create_times = date("Y/m/d H:i:s",time());
			$cruise_id = Yii::app()->params['cruise_id'];
			$this_user_id = Yii::app()->user->id;
			$this_user_name = Yii::app()->user->name;
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product->product_code = $code;
				$product->product_name = $name;
				$product->origin = $origin;
				$product->product_desc = $desc;
				$product->product_img = $photo_url;
				$product->inventory_num = $num;
				$product->sale_price = $price;
				$product->standard_price = $mprice;
				$product->category_code = $category;
				$product->cruise_id = $cruise_id;
				$product->shop_id = $shop;
				$product->brand_id = $brand;
				$product->sale_start_time = $stime;
				$product->sale_end_time = $etime;
				$product->created = $create_times;
				$product->creator = $this_user_name;
				$product->creator_id = $this_user_id;
				$product->status = $state;
				$product->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Product/product_list"));
				
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$category = isset($_GET['category'])?empty($_GET['category'])?0:1:0;
		$shop = isset($_GET['shop'])?empty($_GET['shop'])?0:1:0;
		
		if($category == 1 && $shop == 1){
			$sql = "SELECT brand_id,brand_cn_name from `vcos_brand`";
			$brand = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT shop_id,shop_title FROM `vcos_shop`";
			$shop_sel = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
			$layer_1 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
			$layer_2 = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
			$layer_3 = $p_db->createCommand($sql)->queryAll();
			$this->render('product_add',array('shop'=>$_GET['shop'],'category'=>$_GET['category'],'shop_sel'=>$shop_sel,'product'=>$product,'brand'=>$brand,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
		}else{
			$sql = "SELECT shop_id,shop_title FROM `vcos_shop` WHERE shop_status=1";
			$shop_sel = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT a.category_code,a.parent_catogory_code,b.name FROM `vcos_shop_operation_category` a LEFT JOIN `vcos_category` b ON a.category_code=b.category_code WHERE b.status=1 AND a.status=1 AND tree_type=1 AND a.shop_id=".$shop_sel[0]['shop_id']." ORDER BY a.category_code";
			$cat1_sel = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT a.category_code,a.parent_catogory_code,b.name FROM `vcos_shop_operation_category` a LEFT JOIN `vcos_category` b ON a.category_code=b.category_code WHERE b.status=1 AND a.status=1 AND tree_type=2 AND a.shop_id=".$shop_sel[0]['shop_id']." ORDER BY a.category_code";
			$cat2_sel = $p_db->createCommand($sql)->queryAll();
			$sql = "SELECT a.category_code,a.parent_catogory_code,b.name FROM `vcos_shop_operation_category` a LEFT JOIN `vcos_category` b ON a.category_code=b.category_code WHERE b.status=1 AND a.status=1 AND tree_type=3 AND a.shop_id=".$shop_sel[0]['shop_id']." ORDER BY a.category_code";
			$cat3_sel = $p_db->createCommand($sql)->queryAll();
			$cat1_but = $cat1_sel[0]['category_code'];
			$cat2_but = $cat2_sel[0]['category_code'];
			$cat3_but = $cat3_sel[0]['category_code'];
			$this->render('product_add_category',array('shop_sel'=>$shop_sel,'cat1_but'=>$cat1_but,'cat2_but'=>$cat2_but,'cat3_but'=>$cat3_but,'cat1_sel'=>$cat1_sel,'cat2_sel'=>$cat2_sel,'cat3_sel'=>$cat3_sel));
		}
	}
	
	/**商品添加：改变店铺资质改变**/
	public function actionGetOperationCategory(){
		$p_db = Yii::app()->p_db;
		
		$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
		$sql = "SELECT a.category_code,a.parent_catogory_code,b.name FROM `vcos_shop_operation_category` a LEFT JOIN `vcos_category` b ON a.category_code=b.category_code WHERE b.status=1 AND a.status=1 AND tree_type=1 AND a.shop_id=".$shop_id." ORDER BY a.category_code";
		$cat1_sel = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT a.category_code,a.parent_catogory_code,b.name FROM `vcos_shop_operation_category` a LEFT JOIN `vcos_category` b ON a.category_code=b.category_code WHERE b.status=1 AND a.status=1 AND tree_type=2 AND a.shop_id=".$shop_id." ORDER BY a.category_code";
		$cat2_sel = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT a.category_code,a.parent_catogory_code,b.name FROM `vcos_shop_operation_category` a LEFT JOIN `vcos_category` b ON a.category_code=b.category_code WHERE b.status=1 AND a.status=1 AND tree_type=3 AND a.shop_id=".$shop_id." ORDER BY a.category_code";
		$cat3_sel = $p_db->createCommand($sql)->queryAll();
		$cat1_but = empty($cat1_sel[0]['category_code'])?'':$cat1_sel[0]['category_code'];
		$cat2_but = empty($cat2_sel[0]['category_code'])?'':$cat2_sel[0]['category_code'];
		$cat3_but = empty($cat3_sel[0]['category_code'])?'':$cat3_sel[0]['category_code'];
		$arr = array();
		$arr[0] = $cat1_sel;
		$arr[1] = $cat2_sel;
		$arr[2] = $cat3_sel;
		$arr[3] = $cat1_but;
		$arr[4] = $cat2_but;
		$arr[5] = $cat3_but;
		if($cat1_sel){
			echo json_encode($arr);
		}else{
			echo 0;
		}
		
	}
	
	/**商品编辑**/
	public function actionProduct_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$product= VcosProduct::model()->findByPk($id);
		if($_POST){
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$code = isset($_POST['code'])?$_POST['code']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$origin = isset($_POST['origin'])?$_POST['origin']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$num = isset($_POST['num'])?$_POST['num']:0;
			$price = isset($_POST['price'])?$_POST['price']*100:0;
			$mprice = isset($_POST['mprice'])?$_POST['mprice']*100:0;
			$category = isset($_POST['category_3'])?$_POST['category_3']:0;
			$shop = isset($_POST['shop'])?$_POST['shop']:0;
			$brand = isset($_POST['brand'])?$_POST['brand']:0;
			$time = explode(" - ", $_POST['time']);
			$s_time = $time[0] . ' ' . $_POST['stime'];
			$e_time = $time[1] . ' ' . $_POST['etime'];
			$stime = date('Y/m/d H:i:s',strtotime($s_time));
			$etime = date('Y/m/d H:i:s',strtotime($e_time));
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'product_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'product_images/'.Yii::app()->params['month'].'/'.$photo;
			//$create_times = date("Y/m/d H:i:s",time());
			$cruise_id = Yii::app()->params['cruise_id'];
			$this_user_id = Yii::app()->user->id;
			$this_user_name = Yii::app()->user->name;
			
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product->product_code = $code;
				$product->product_name = $name;
				$product->origin = $origin;
				$product->product_desc = $desc;
				//$product->product_img = $photo_url;
				$product->inventory_num = $num;
				$product->sale_price = $price;
				$product->standard_price = $mprice;
				$product->category_code = $category;
				$product->cruise_id = $cruise_id;
				$product->shop_id = $shop;
				$product->brand_id = $brand;
				$product->sale_start_time = $stime;
				$product->sale_end_time = $etime;
				//$product->created = $create_times;
				$product->creator = $this_user_name;
				$product->creator_id = $this_user_id;
				if($photo){
					$product->product_img = $photo_url;
				}
				$product->status = $state;
				$product->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Product/product_list"));
				
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$category_code = $product['category_code'];
		$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code =".$category_code;
		$layer_cat_2 = $p_db->createCommand($sql)->queryRow();
		$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code =".$layer_cat_2['parent_cid'];
		$layer_cat_1 = $p_db->createCommand($sql)->queryRow();
		$sql = "SELECT brand_id,brand_cn_name from `vcos_brand`";
		$brand = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_cat_1['parent_cid'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_cat_2['parent_cid'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT shop_id,shop_title FROM `vcos_shop`";
		$shop = $p_db->createCommand($sql)->queryAll();
		$this->render('product_edit',array('shop'=>$shop,'product'=>$product,'layer_cat'=>$layer_cat_1['parent_cid'],'layer_cat2'=>$layer_cat_2['parent_cid'],'brand'=>$brand,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**商品：获取二级分类**/
	/*public function actionGetCategoryChild(){
		$p_db = Yii::app()->p_db;
		$parent_code = isset($_GET['parent_code'])?$_GET['parent_code']:0;
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$parent_code;
		$resutl = $p_db->createCommand($sql)->queryAll();
		if($resutl){
			echo json_encode($resutl);
		}  else {
			echo 0;
		}
	}*/
	
	/**商品详情列表**/
	public function actionProduct_detail_list(){
		$this->setauth();//检查有无权限
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosProductDetail::model()->deleteAll("product_detail_id in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_detail_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosProductDetail::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_detail_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$cat1_but='';
		$cat2_but='';
		$cat3_but='';
		if(isset($_GET['cat3_all_sel']) && $_GET['cat3_all_sel']!=''){
			$code_id = $_GET['cat3_all_sel'];
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code_id;
			$code1_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code1_sel['parent_cid'];
			$code2_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
				
			$cat1_but = $code2_sel['parent_cid'];
			$cat2_but = $code1_sel['parent_cid'];
			$cat3_but = $code_id;
				
			$where = "b.category_code='".$code_id."'";
		}else{
			/*$sql = "select category_code from vcos_category where length(category_code) = 7 ORDER BY category_code limit 1";
			 $code_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			 $code_id = $code_sel['category_code'];
			 $code_id = 1;*/
			$where = 1;
		}
		$count_sql = "SELECT count(*) count FROM `vcos_product_detail` a
		LEFT JOIN `vcos_product` b ON a.product_id = b.product_id
		WHERE ".$where."
		ORDER BY a.product_id DESC";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.product_id,b.product_name FROM `vcos_product_detail` a
		LEFT JOIN `vcos_product` b ON a.product_id = b.product_id
		WHERE ".$where."
		ORDER BY a.product_id DESC LIMIT {$criteria->offset}, 10";
		$product_detail = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		/**分类筛选**/
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=0";
		$cat1_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
	
		if(!isset($_GET['cat3_all_sel'])){
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_sel[0]['category_code'];
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_sel[0]['category_code'];
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}else{
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_but;
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_but;
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}
		
		$this->render('product_detail_list',array('cat1_but'=>$cat1_but,'cat2_but'=>$cat2_but,'cat3_but'=>$cat3_but,'cat1_sel'=>$cat1_sel,'cat2_sel'=>$cat2_sel,'cat3_sel'=>$cat3_sel,'pages'=>$pager,'auth'=>$this->auth,'product_detail'=>$product_detail));
	} 
	
	/**添加商品详情***/
	public function actionProduct_detail_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$product_detail = new VcosProductDetail();
		if($_POST){
			$product = isset($_POST['product'])?$_POST['product']:0;
			//匹配替换编辑器中图片路径
			$img_ueditor = Yii::app()->params['img_ueditor_php'];
			$text = $_POST['describe_text'];
			$describe_text = preg_replace($img_ueditor,'',$text);
			$photo = $_POST['describe_photo'];
			$describe_photo = preg_replace($img_ueditor,'',$photo);

			//处理事务
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$product_detail->product_id = $product;
				$product_detail->text_detail = $describe_text;
				$product_detail->graphic_detail = $describe_photo;
				$product_detail->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Product/product_detail_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE status=1 AND category_code=".$layer_3[0]['category_code'];
		$product = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		$this->render('product_detail_add',array('product'=>$product,'product_detail'=>$product_detail,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**编辑商品详情**/
	public function actionProduct_detail_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$product_detail= VcosProductDetail::model()->findByPk($id);
		if($_POST){
			$product = isset($_POST['product'])?$_POST['product']:0;
			//匹配替换编辑器中图片路径
			$img_ueditor = Yii::app()->params['img_ueditor_php'];
			$text = $_POST['describe_text'];
			$describe_text = preg_replace($img_ueditor,'',$text);
			$photo = $_POST['describe_photo'];
			$describe_photo = preg_replace($img_ueditor,'',$photo);
				
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product_detail->product_id = $product;
				$product_detail->text_detail = $describe_text;
				$product_detail->graphic_detail = $describe_photo;
				$product_detail->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Product/product_detail_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT category_code FROM `vcos_product` WHERE product_id=".$product_detail['product_id'];
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
		$this->render('product_detail_edit',array('product_detail'=>$product_detail,'product'=>$product,'layer_cat'=>$layer_cat,'layer_cat2'=>$layer_cat2,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3,'category_code'=>$category_code));
	}
	
	
	/**商品图片列表**/
	public function actionProduct_img_list(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		//批量删除
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosProductImg::model()->deleteAll("product_img_id in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_img_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosProductImg::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_img_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$cat1_but='';
		$cat2_but='';
		$cat3_but='';
		if(isset($_GET['cat3_all_sel']) && $_GET['cat3_all_sel']!=''){
			$code_id = $_GET['cat3_all_sel'];
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code_id;
			$code1_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code1_sel['parent_cid'];
			$code2_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
		
			$cat1_but = $code2_sel['parent_cid'];
			$cat2_but = $code1_sel['parent_cid'];
			$cat3_but = $code_id;
		
			$where = "b.category_code='".$code_id."'";
		}else{
			/*$sql = "select category_code from vcos_category where length(category_code) = 7 ORDER BY category_code limit 1";
			 $code_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			 $code_id = $code_sel['category_code'];
			 $code_id = 1;*/
			$where = 1;
		}
		$count_sql = "SELECT count(*) count FROM `vcos_product_img` a
		LEFT JOIN `vcos_product` b ON a.product_id=b.product_id
		WHERE ".$where."
		ORDER BY a.product_id DESC";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.product_name FROM `vcos_product_img` a
		LEFT JOIN `vcos_product` b ON a.product_id=b.product_id
		WHERE ".$where."
		ORDER BY a.product_id DESC LIMIT {$criteria->offset}, 10";
		$product_img = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		/**分类筛选**/
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=0";
		$cat1_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		if(!isset($_GET['cat3_all_sel'])){
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_sel[0]['category_code'];
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_sel[0]['category_code'];
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}else{
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_but;
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_but;
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}
		//渲染页面
		$this->render('product_img_list',array('cat1_but'=>$cat1_but,'cat2_but'=>$cat2_but,'cat3_but'=>$cat3_but,'cat1_sel'=>$cat1_sel,'cat2_sel'=>$cat2_sel,'cat3_sel'=>$cat3_sel,'pages'=>$pager,'auth'=>$this->auth,'product_img'=>$product_img));
	}
	
	/**商品图片添加**/
	public function actionProduct_img_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$product_img = new VcosProductImg();
		if($_POST){
			$product = isset($_POST['product'])?$_POST['product']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:0;
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'product_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'product_images/'.Yii::app()->params['month'].'/'.$photo;
			
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product_img->product_id = $product;
				$product_img->img_url = $photo_url;
				$product_img->sort_order = $sort;
				$product_img->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Product/product_img_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE status=1 AND category_code=".$layer_3[0]['category_code'];
		$product = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('product_img_add',array('product'=>$product,'product_img'=>$product_img,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**商品图片编辑**/
	public function actionProduct_img_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$product_img= VcosProductImg::model()->findByPk($id);
		if($_POST){
			$product = isset($_POST['product'])?$_POST['product']:0;
			$sort = isset($_POST['sort'])?$_POST['sort']:0;
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'product_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'product_images/'.Yii::app()->params['month'].'/'.$photo;
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product_img->product_id = $product;
				if($photo){
					$product_img->img_url = $photo_url;
				}
				$product_img->sort_order = $sort;
				$product_img->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Product/product_img_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT category_code FROM `vcos_product` WHERE product_id=".$product_img['product_id'];
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
		$this->render('product_img_edit',array('product_img'=>$product_img,'product'=>$product,'layer_cat'=>$layer_cat,'layer_cat2'=>$layer_cat2,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3,'category_code'=>$category_code));
	}
	
	
	/**商品图文列表**/
	public function actionProduct_graphic_list(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		//批量删除
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			$count = VcosProductGraphic::model()->deleteAll("id in('$ids')");
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_graphic_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			$count=VcosProductGraphic::model()->deleteByPk($did);
			if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Product/product_graphic_list"));
			}else{
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$cat1_but='';
		$cat2_but='';
		$cat3_but='';
		if(isset($_GET['cat3_all_sel']) && $_GET['cat3_all_sel']!=''){
			$code_id = $_GET['cat3_all_sel'];
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code_id;
			$code1_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			$sql = "SELECT parent_cid FROM `vcos_category` WHERE category_code=".$code1_sel['parent_cid'];
			$code2_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
		
			$cat1_but = $code2_sel['parent_cid'];
			$cat2_but = $code1_sel['parent_cid'];
			$cat3_but = $code_id;
		
			$where = "b.category_code='".$code_id."'";
		}else{
			/*$sql = "select category_code from vcos_category where length(category_code) = 7 ORDER BY category_code limit 1";
			 $code_sel = Yii::app()->p_db->createCommand($sql)->queryRow();
			 $code_id = $code_sel['category_code'];
			 $code_id = 1;*/
			$where = 1;
		}
		$count_sql = "SELECT count(*) count FROM `vcos_product_graphic` a
		LEFT JOIN `vcos_product` b ON a.product_id=b.product_id
		WHERE ".$where."
		ORDER BY a.product_id DESC";
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.product_name FROM `vcos_product_graphic` a
		LEFT JOIN `vcos_product` b ON a.product_id=b.product_id
		WHERE ".$where."
		ORDER BY a.product_id DESC LIMIT {$criteria->offset}, 10";
		$product_graphic = Yii::app()->p_db->createCommand($sql)->queryAll();
		
		/**分类筛选**/
		$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=0";
		$cat1_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		if(!isset($_GET['cat3_all_sel'])){
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_sel[0]['category_code'];
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_sel[0]['category_code'];
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}else{
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat1_but;
			$cat2_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
			$sql = "SELECT category_code,name FROM `vcos_category` WHERE parent_cid=".$cat2_but;
			$cat3_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
		}
		//渲染页面
		$this->render('product_graphic_list',array('cat1_but'=>$cat1_but,'cat2_but'=>$cat2_but,'cat3_but'=>$cat3_but,'cat1_sel'=>$cat1_sel,'cat2_sel'=>$cat2_sel,'cat3_sel'=>$cat3_sel,'pages'=>$pager,'auth'=>$this->auth,'product_graphic'=>$product_graphic));	
	}
	
	/**商品图文添加**/
	public function actionProduct_graphic_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$product_graphic = new VcosProductGraphic();
		if($_POST){
			$product = isset($_POST['product'])?$_POST['product']:0;
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:0;
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'product_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'product_images/'.Yii::app()->params['month'].'/'.$photo;
				
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product_graphic->product_id = $product;
				$product_graphic->img_url = $photo_url;
				if($desc != ''){
				$product_graphic->graphic_desc = $desc;
				}
				$product_graphic->sort_order = $sort;
				$product_graphic->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Product/product_graphic_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=0";
		$layer_1 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_1[0]['category_code'];
		$layer_2 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT category_code,name,parent_cid FROM `vcos_category` WHERE parent_cid=".$layer_2[0]['category_code'];
		$layer_3 = $p_db->createCommand($sql)->queryAll();
		$sql = "SELECT product_id,product_name FROM `vcos_product` WHERE status=1 AND category_code=".$layer_3[0]['category_code'];
		$product = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('product_graphic_add',array('product'=>$product,'product_graphic'=>$product_graphic,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3));
	}
	
	/**商品图文编辑**/
	public function actionProduct_graphic_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$product_graphic= VcosProductGraphic::model()->findByPk($id);
		if($_POST){
			$product = isset($_POST['product'])?$_POST['product']:0;
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$sort = isset($_POST['sort'])?$_POST['sort']:0;
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'product_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'product_images/'.Yii::app()->params['month'].'/'.$photo;
		
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$product_graphic->product_id = $product;
				if($desc != ''){
				$product_graphic->graphic_desc = $desc;
				}
				if($photo){
					$product_graphic->img_url = $photo_url;
				}
				$product_graphic->sort_order = $sort;
				$product_graphic->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Product/product_graphic_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT category_code FROM `vcos_product` WHERE product_id=".$product_graphic['product_id'];
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
		$this->render('product_graphic_edit',array('product_graphic'=>$product_graphic,'product'=>$product,'layer_cat'=>$layer_cat,'layer_cat2'=>$layer_cat2,'layer_1'=>$layer_1,'layer_2'=>$layer_2,'layer_3'=>$layer_3,'category_code'=>$category_code));
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
}