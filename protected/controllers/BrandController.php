<?php
class BrandController extends Controller
{
	/**品牌列表**/
	public function actionBrand_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->p_db;
		if($_POST){
			$ids=implode('\',\'', $_POST['ids']);
			/*
			$str = '';	//获取将要删除product表的id
			$pro_ids = VcosProduct::model()->findAll("brand_id in($ids)");
			foreach($pro_ids as $la1){
				$str .= $la1['product_id'].',';
			}
			$str = trim($str,',');*/
			//$count = VcosBrand::model()->deleteAll("brand_id in($ids)");
			//$count2 = VcosProduct::model()->deleteAll("brand_id in($ids)");
			$db->createCommand("UPDATE `vcos_brand` set brand_status=0 WHERE brand_id in($ids)")->execute();
			$db->createCommand("UPDATE `vcos_product` set status=0 WHERE brand_id in($ids)")->execute();
			//if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Brand/brand_list"));
			//}else{
			//	Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		if(isset($_GET['id'])){
			$did=$_GET['id'];
			/*
			$str = '';	//获取将要删除product表的id
			$pro_ids = VcosProduct::model()->findAll("brand_id in($did)");
			foreach($pro_ids as $la1){
				$str .= $la1['product_id'].',';
			}
			$str = trim($str,',');*/
			//$count=VcosBrand::model()->deleteByPk($did);
			//$count2 = VcosProduct::model()->deleteAll("brand_id in($did)");
			$db->createCommand("UPDATE `vcos_brand` set brand_status=0 WHERE brand_id in($did)")->execute();
			$db->createCommand("UPDATE `vcos_product` set status=0 WHERE brand_id in($did)")->execute();
			//if ($count>0){
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Brand/brand_list"));
			//}else{
			//	Helper::show_message(yii::t('vcos', '删除失败。'));
			//}
		}
		$count_sql = "SELECT count(*) count FROM `vcos_brand` a LEFT JOIN `vcos_country` b ON a.country_id = b.country_id"; 
		$count = Yii::app()->p_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT a.*,b.country_cn_name FROM `vcos_brand` a 
		LEFT JOIN `vcos_country` b ON a.country_id = b.country_id
		LIMIT {$criteria->offset}, 10";
		$brand = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('brand_list',array('pages'=>$pager,'auth'=>$this->auth,'brand'=>$brand));
		
	}
	
	/**品牌添加**/
	public function actionBrand_add(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$brand = new VcosBrand();
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$names = isset($_POST['names'])?$_POST['names']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$country = isset($_POST['country'])?$_POST['country']:0;
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'brand_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'brand_images/'.Yii::app()->params['month'].'/'.$photo;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$brand->brand_cn_name = $name;
				$brand->brand_en_name = $names;
				$brand->country_id = $country;
				$brand->brand_logo = $photo_url;
				$brand->brand_desc = $desc;
				$brand->brand_status = $state;
				$brand->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Brand/brand_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		$sql = "SELECT country_id,country_cn_name FROM `vcos_country` WHERE status =1";
		$country = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('brand_add',array('brand'=>$brand,'country'=>$country));
	}
	
	/**品牌编辑**/
	public function actionBrand_edit(){
		$this->setauth();//检查有无权限
		$p_db = Yii::app()->p_db;
		$id=$_GET['id'];
		$brand= VcosBrand::model()->findByPk($id);
		if($_POST){
			$name = isset($_POST['name'])?$_POST['name']:'';
			$names = isset($_POST['names'])?$_POST['names']:'';
			$country = isset($_POST['country'])?$_POST['country']:0;
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'activity_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'activity_images/'.Yii::app()->params['month'].'/'.$photo;
			$state = isset($_POST['state'])?$_POST['state']:'0';
			
			//事务处理
			$transaction=$p_db->beginTransaction();
			try{
				$brand->brand_cn_name = $name;
				$brand->brand_en_name = $names;
				$brand->country_id = $country;
				$brand->brand_desc = $desc;
				$brand->brand_status = $state;
				if($photo){
					$brand->brand_logo = $photo_url;
				}
				$brand->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Brand/brand_list"));
		
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'));
			}
		}
		$sql = "SELECT country_id,country_cn_name FROM `vcos_country` WHERE status =1";
		$country = Yii::app()->p_db->createCommand($sql)->queryAll();
		$this->render('brand_edit',array('brand'=>$brand,'country'=>$country));
	}
}