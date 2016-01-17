<?php

class StrategyController extends Controller
{
	public function actionCountry_add()
	{
		$this->setauth();//检查有无权限
        $country = new VcosStrategyCountry();
        $country_language = new VcosStrategyCountryLanguage();
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $country->state = $state;

            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            
            try{
            	$country->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_strategy_country_language` (`country_id`,`country_name`, `iso`) VALUES ('{$country->primaryKey}','{$_POST['name']}', '".Yii::app()->params['language']."'), ('{$country->primaryKey}','{$_POST['name_iso']}', '{$_POST['language']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/Country_list"));
                }  else {//只添加系统语言时
                    $country_language->country_id = $country->primaryKey;
                    $country_language->iso = Yii::app()->params['language'];
                    $country_language->country_name = $_POST['name'];
                   
                    $country_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/Country_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('country_add',array('country'=>$country,'country_language'=>$country_language));
    
	}
	
	public function actionCountry_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		//批量删除
		if($_POST){
			$a = count($_POST['ids']);
			$ids=implode('\',\'', $_POST['ids']);
			$result = VcosStrategyCountry::model()->count();
			$count_sql = "SELECT count(*) count FROM `vcos_strategy_city` WHERE country_id in('$ids')";
			$count_num = Yii::app()->m_db->createCommand($count_sql)->queryRow();
			if($a == $result){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}else if($count_num['count'] >0){
				die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
			}
		
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count = VcosStrategyCountry::model()->deleteAll("country_id in('$ids')");
				$count2 = VcosStrategyCountryLanguage::model()->deleteAll("country_id in('$ids')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/country_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosStrategyCountry::model()->count();
			$sql = "SELECT count(*) count FROM `vcos_strategy_city` WHERE country_id = ".$_GET['id'];
			$count_num = $db->createCommand($sql)->queryRow();
			
			
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}else if($count_num['count'] > 0){
				die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
			}
			
			$did=$_GET['id'];
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count=VcosStrategyCountry::model()->deleteByPk($did);
				$count2 = VcosStrategyCountryLanguage::model()->deleteAll("country_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/country_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_strategy_country` a LEFT JOIN `vcos_strategy_country_language` b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."'";
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		$sql = "SELECT * FROM `vcos_strategy_country` a LEFT JOIN `vcos_strategy_country_language` b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."' LIMIT {$criteria->offset}, {$pager->pageSize}";
		$country = $db->createCommand($sql)->queryAll();
		
		$this->render('country_list',array('country'=>$country,'pages'=>$pager,'auth'=>$this->auth));
	}
	
	public function actionCountry_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$country= VcosStrategyCountry::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE a.country_id = {$id} AND b.iso ='".Yii::app()->language."'";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$country_language = VcosStrategyCountryLanguage::model()->findByPk($id2['id']);
		 
		if($_POST){
			 $state = isset($_POST['state'])?$_POST['state']:'0';
			
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
					//编辑主表
					$columns = array('state'=>$state);
					$db->createCommand()->update('vcos_strategy_country',$columns,'country_id = :id',array(':id'=>$id));
					//编辑系统语言
					$db->createCommand()->update('vcos_strategy_country_language', array('country_name'=>$_POST['name']), 'id=:id', array(':id'=>$id2['id']));
					//判断外语是新增OR编辑
					if($_POST['judge']=='add'){
						//新增外语
						$db->createCommand()->insert('vcos_strategy_country_language',array('country_id'=>$id,'iso'=>$_POST['language'],'country_name'=>$_POST['name_iso']));
					}  else {
						//编辑外语
						$db->createCommand()->update('vcos_strategy_country_language', array('country_name'=>$_POST['name_iso']), 'id=:id', array(':id'=>$_POST['judge']));
					}
					//事务提交
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/Country_list"));
				}  else {//只编辑系统语言状态下
					$country->country_id = $id;
					$country->state = $state;
					$country->save();
					$country_language->id = $id2['id'];
					$country_language->country_name = $_POST['name'];
					$country_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/Country_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		
		$this->render('country_edit',array('country'=>$country,'country_language'=>$country_language));
	}
	
	public function actionGetiso_country(){
		$sql = "SELECT b.id, b.country_name FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE a.country_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
		$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
		if($iso){
			echo json_encode($iso);
		}  else {
			echo 0;
		}

	}
	
	public function actionCity_add()
	{
		$this->setauth();//检查有无权限
		$city = new VcosStrategyCity();
		$city_language = new VcosStrategyCityLanguage();
		if($_POST){
			
		
			$state = isset($_POST['state'])?$_POST['state']:'0';
			
			$city->state = $state;
			$city->country_id = $_POST['country'];
		
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$city->save();
				if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
					$sql = "INSERT INTO `vcos_strategy_city_language` (`city_id`, `city_name`,`iso`) VALUES ('{$city->primaryKey}','{$_POST['name']}', '".Yii::app()->params['language']."'), ('{$city->primaryKey}','{$_POST['name_iso']}', '{$_POST['language']}')";
					$db->createCommand($sql)->execute();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/city_list"));
				}  else {//只添加系统语言时
					$city_language->city_id = $city->primaryKey;
					$city_language->city_name = $_POST['name'];
					$city_language->iso = Yii::app()->params['language'];
					$city_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/city_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
	
		$res_sql = "SELECT a.country_id,b.country_name FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."' AND a.state = '1'";
		$country_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		
		$this->render('city_add',array('country_sel'=>$country_sel,'city'=>$city,'city_language'=>$city_language));
	}
	
	public function actionCity_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		
		$where = 1;
		$res_but = 0;
		if(isset($_GET['country']) && $_GET['country'] != ''){
			if($_GET['country'] == 0){
				$where = 1;
			}else{
				$where = "a.country_id = ".$_GET['country'];
				$res_but = $_GET['country'];
			}
		}
		//批量删除
		if($_POST){
			$a = count($_POST['ids']);
			$ids=implode('\',\'', $_POST['ids']);
			$result = VcosStrategyCity::model()->count();
			//查看是否查询攻略是属于该城市
			$count_sql = "SELECT count(*) count FROM `vcos_strategy` WHERE city_id in('$ids')";
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
				$count = VcosStrategyCity::model()->deleteAll("city_id in('$ids')");
				$count2 = VcosStrategyCityLanguage::model()->deleteAll("city_id in('$ids')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/city_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosStrategyCity::model()->count();
			$count_sql = "SELECT count(*) count FROM `vcos_strategy` WHERE city_id =".$_GET['id'];
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
				$count=VcosStrategyCity::model()->deleteByPk($did);
				$count2 = VcosStrategyCityLanguage::model()->deleteAll("city_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/city_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_strategy_city` a
		LEFT JOIN `vcos_strategy_city_language` b ON a.city_id = b.city_id
		RIGHT JOIN (SELECT c.country_id,d.country_name FROM `vcos_strategy_country` c LEFT JOIN `vcos_strategy_country_language` d ON c.country_id = d.country_id WHERE d.iso = '".Yii::app()->language."' AND c.state = '1') e ON a.country_id = e.country_id
		WHERE ".$where." AND b.iso = '".Yii::app()->language."' ORDER BY a.country_id";
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		//$sql = "SELECT * FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE b.iso = '".Yii::app()->params['language']."' ORDER BY a.food_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
		$sql = "SELECT * FROM `vcos_strategy_city` a 
		LEFT JOIN `vcos_strategy_city_language` b ON a.city_id = b.city_id
		RIGHT JOIN (SELECT c.country_id,d.country_name FROM `vcos_strategy_country` c LEFT JOIN `vcos_strategy_country_language` d ON c.country_id = d.country_id WHERE d.iso = '".Yii::app()->language."' AND c.state = '1') e ON a.country_id = e.country_id
		WHERE ".$where." AND b.iso = '".Yii::app()->language."' ORDER BY a.country_id LIMIT {$criteria->offset}, {$pager->pageSize}";
		$city = $db->createCommand($sql)->queryAll();
		$country_sql = "SELECT a.country_id,b.country_name FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."' AND a.state = '1'";
		$country_sel = Yii::app()->m_db->createCommand($country_sql)->queryAll();
		$this->render('city_list',array('res_but'=>$res_but,'country_sel'=>$country_sel,'pages'=>$pager,'auth'=>$this->auth,'city'=>$city));
	}
	
	public function actionCity_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$city= VcosStrategyCity::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_strategy_city a LEFT JOIN vcos_strategy_city_language b ON a.city_id = b.city_id WHERE a.city_id = {$id} AND b.iso ='".Yii::app()->language."'";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$city_language = VcosStrategyCityLanguage::model()->findByPk($id2['id']);
			
		if($_POST){
			
			$state = isset($_POST['state'])?$_POST['state']:'0';
				
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
					//编辑主表
					$columns = array('state'=>$state,'country_id'=>$_POST['country']);
					$db->createCommand()->update('vcos_strategy_city',$columns,'city_id = :id',array(':id'=>$id));
					//编辑系统语言
					$db->createCommand()->update('vcos_strategy_city_language', array('city_name'=>$_POST['name']), 'id=:id', array(':id'=>$id2['id']));
					//判断外语是新增OR编辑
					if($_POST['judge']=='add'){
						//新增外语
						$db->createCommand()->insert('vcos_strategy_city_language',array('city_id'=>$id,'iso'=>$_POST['language'],'city_name'=>$_POST['name_iso']));
					}  else {
						//编辑外语
						$db->createCommand()->update('vcos_strategy_city_language', array('city_name'=>$_POST['name_iso']), 'id=:id', array(':id'=>$_POST['judge']));
					}
					//事务提交
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/City_list"));
				}  else {//只编辑系统语言状态下
					$city->city_id = $id;
					$city->country_id = $_POST['country'];
					$city->state = $state;
					$city->save();
					$city_language->id = $id2['id'];
					$city_language->city_name = $_POST['name'];
					$city_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/City_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		$res_sql = "SELECT a.country_id,b.country_name FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."' AND a.state = '1'";
		$country_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		
		$this->render('city_edit',array('country_sel'=>$country_sel,'city'=>$city,'city_language'=>$city_language));
	}
	
	public function actionGetiso_city(){
		$sql = "SELECT b.id, b.city_name FROM vcos_strategy_city a LEFT JOIN vcos_strategy_city_language b ON a.city_id = b.city_id WHERE a.city_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
		$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
		if($iso){
			echo json_encode($iso);
		}  else {
			echo 0;
		}
	}
	
	/**攻略分类列表**/
	public function actionStrategy_category_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		
		$where = 1;
		$res_but = 0;/*
		if(isset($_GET['country']) && $_GET['country'] != ''){
			if($_GET['country'] == 0){
				$where = 1;
			}else{
				$where = "a.country_id = ".$_GET['country'];
				$res_but = $_GET['country'];
			}
		}*/
		
		//批量删除
		if($_POST){
			$a = count($_POST['ids']);
			$ids=implode('\',\'', $_POST['ids']);
			$result = VcosStrategyCategory::model()->count();
			
			$count_sql = "SELECT count(*) count FROM `vcos_strategy` WHERE strategy_category_id in('$ids')";
			$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
			if($a == $result){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}
			else if($count_category['count'] >0){
			 die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
			 }
		
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count = VcosStrategyCategory::model()->deleteAll("strategy_category_id in('$ids')");
				$count2 = VcosStrategyCategoryLanguage::model()->deleteAll("strategy_category_id in('$ids')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/Strategy_category_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosStrategyCategory::model()->count();
			$count_sql = "SELECT count(*) count FROM `vcos_strategy` WHERE strategy_category_id =".$_GET['id'];
			$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}else if($count_category['count'] >0){
			 die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
			 }
			$did=$_GET['id'];
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count=VcosStrategyCategory::model()->deleteByPk($did);
				$count2 = VcosStrategyCategoryLanguage::model()->deleteAll("strategy_category_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/Strategy_category_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		$count_sql = "SELECT count(*) count FROM `vcos_strategy_category` a LEFT JOIN `vcos_strategy_category_language` b
		ON a.strategy_category_id = b.strategy_category_id
		LEFT JOIN (SELECT * FROM `vcos_strategy_category_language` c WHERE c.iso='".Yii::app()->language."') c ON a.parent_id = c.strategy_category_id
		WHERE b.iso = '".Yii::app()->language."'";
		$count = $db->createCommand($count_sql)->queryRow();
		//分页
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
	
		//$sql = "SELECT * FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE b.iso = '".Yii::app()->params['language']."' ORDER BY a.food_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
		$sql = "SELECT a.*,b.category_name,c.category_name parent_name FROM `vcos_strategy_category` a LEFT JOIN `vcos_strategy_category_language` b
		ON a.strategy_category_id = b.strategy_category_id
		LEFT JOIN (SELECT * FROM `vcos_strategy_category_language` c WHERE c.iso='".Yii::app()->language."') c ON a.parent_id = c.strategy_category_id
		WHERE b.iso = '".Yii::app()->language."' LIMIT {$criteria->offset}, {$pager->pageSize}";
		$strategy_category = $db->createCommand($sql)->queryAll();
		/*
		$category_sql = "SELECT a.country_id,b.country_name FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."' AND a.state = '1'";
		$category_sel = Yii::app()->m_db->createCommand($country_sql)->queryAll();
		*/
		$category_sel = '';
		$this->render('strategy_category_list',array('category_sel'=>$category_sel,'res_but'=>$res_but,'pages'=>$pager,'auth'=>$this->auth,'strategy_category'=>$strategy_category));
	}
	
	/**攻略分类编辑**/
	public function actionStrategy_category_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$strategy_category= VcosStrategyCategory::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_strategy_category a LEFT JOIN vcos_strategy_category_language b ON a.strategy_category_id = b.strategy_category_id WHERE a.strategy_category_id = {$id} AND b.iso ='".Yii::app()->language."'";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$strategy_category_language = VcosStrategyCategoryLanguage::model()->findByPk($id2['id']);
			
		if($_POST){
				
			$state = isset($_POST['state'])?$_POST['state']:'0';
		
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
					//编辑主表
					$columns = array('state'=>$state);
					$db->createCommand()->update('vcos_strategy_category',$columns,'strategy_category_id = :id',array(':id'=>$id));
					//编辑系统语言
					$db->createCommand()->update('vcos_strategy_category_language', array('category_name'=>$_POST['name']), 'id=:id', array(':id'=>$id2['id']));
					//判断外语是新增OR编辑
					if($_POST['judge']=='add'){
						//新增外语
						$db->createCommand()->insert('vcos_strategy_category_language',array('strategy_category_id'=>$id,'iso'=>$_POST['language'],'category_name'=>$_POST['name_iso']));
					}  else {
						//编辑外语
						$db->createCommand()->update('vcos_strategy_category_language', array('category_name'=>$_POST['name_iso']), 'id=:id', array(':id'=>$_POST['judge']));
					}
					//事务提交
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/Strategy_category_list"));
				}  else {//只编辑系统语言状态下
					$strategy_category->strategy_category_id = $id;
					$strategy_category->state = $state;
					$strategy_category->save();
					$strategy_category_language->id = $id2['id'];
					$strategy_category_language->category_name = $_POST['name'];
					$strategy_category_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/Strategy_category_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		$sql = "SELECT a.strategy_category_id,b.category_name FROM `vcos_strategy_category` a LEFT JOIN `vcos_strategy_category_language` b
				ON a.strategy_category_id  = b.strategy_category_id
				WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
		$strategy_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
		
		$this->render('strategy_category_edit',array('strategy_sel'=>$strategy_sel,'strategy_category'=>$strategy_category,'strategy_category_language'=>$strategy_category_language));
	}
	
	public function actionGetiso_category(){
		$sql = "SELECT b.id, b.category_name FROM vcos_strategy_category a LEFT JOIN vcos_strategy_category_language b ON a.strategy_category_id = b.strategy_category_id WHERE a.strategy_category_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
		$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
		if($iso){
			echo json_encode($iso);
		}  else {
			echo 0;
		}
	}
	
	
	/**攻略分类添加**/
	public function actionStrategy_category_add(){
		$this->setauth();//检查有无权限
		$strategy_category = new VcosStrategyCategory();
		$strategy_category_language = new VcosStrategyCategoryLanguage();
		if($_POST){
			
			
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$strategy_category->state = $state;
			
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$strategy_category->save();
				if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
					$sql = "INSERT INTO `vcos_strategy_category_language` (`strategy_category_id`,`category_name`, `iso`) VALUES ('{$strategy_category->primaryKey}','{$_POST['name']}', '".Yii::app()->params['language']."'), ('{$strategy_category->primaryKey}','{$_POST['name_iso']}', '{$_POST['language']}')";
					$db->createCommand($sql)->execute();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/Strategy_category_list"));
				}  else {//只添加系统语言时
					$strategy_category_language->strategy_category_id = $strategy_category->primaryKey;
					$strategy_category_language->iso = Yii::app()->params['language'];
					$strategy_category_language->category_name = $_POST['name'];
					$strategy_category_language->save();
					$transaction->commit();
					Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/Strategy_category_list"));
				}
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
		}
		
		
		$this->render('strategy_category_add',array('strategy_category'=>$strategy_category,'strategy_category_language'=>$strategy_category_language));
	}
	
	/**攻略列表**/
	public function actionStrategy_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		
		
    	$res_but = 0;
    	$category_but = 0;
    	$city = 1;
    	$category = 1;
    	$res = 'all';
    	$la_where = 1;
    	
    	if(isset($_GET['city']) && $_GET['city'] != ''){
    		if($_GET['city'] == 0){
    			$city = 1;
    			$res_but = 0;
    		}else{
    			$city = "a.city_id = ". $_GET['city'];
    			$res_but = $_GET['city'];
    		}
    	}
    	if(isset($_GET['category']) && $_GET['category'] != ''){
    		if($_GET['category'] == 0){
    			$category = 1;
    			$category_but = 0;
    		}else{
    			$category = "a.strategy_category_id = ".$_GET['category'];
    			$category_but = $_GET['category'];
    		}
    	}
    	if(isset($_GET['res']) && $_GET['res'] != ''){
    		if($_GET['res'] == 'all'){
    			$la_where = 1;
    			$res = 'all';
    		}elseif($_GET['res'] == 'zh_cn'){
    			$la_where = "b.iso = 'zh_cn'";
    			$res = 'zh_cn';
    		}elseif($_GET['res'] == 'en'){
    			$la_where = "b.iso = 'en'";
    			$res = 'en';
    		}
    	}
    
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosStrategy::model()->count();
			
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}
			$did=$_GET['id'];
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count=VcosStrategy::model()->deleteByPk($did);
				$count2 = VcosStrategyLanguage::model()->deleteAll("strategy_id in('$did')");
				$count3 = VcosStrategyImg::model()->deleteAll("strategy_id in('$did')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/Strategy_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_strategy` a
		RIGHT JOIN `vcos_strategy_language` b ON a.strategy_id=b.strategy_id
		LEFT JOIN (SELECT c.city_id,d.city_name FROM `vcos_strategy_city` c
		LEFT JOIN `vcos_strategy_city_language` d  ON c.city_id=d.city_id WHERE d.iso='".Yii::app()->language."') e ON a.city_id = e.city_id
		LEFT JOIN (SELECT f.strategy_category_id,g.category_name FROM `vcos_strategy_category` f
		RIGHT JOIN `vcos_strategy_category_language` g ON f.strategy_category_id = g.strategy_category_id WHERE iso = '".Yii::app()->language."') h 
		ON h.strategy_category_id = a.strategy_category_id WHERE ".$city." AND ".$category." AND ".$la_where;
		$count = $db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		//$sql = "SELECT * FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE b.iso = '".Yii::app()->params['language']."' ORDER BY a.food_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
		$city_sql = "SELECT a.city_id,b.city_name FROM `vcos_strategy_city` a LEFT JOIN `vcos_strategy_city_language` b ON a.city_id = b.city_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
		$category_sql = "SELECT a.strategy_category_id,b.category_name FROM `vcos_strategy_category` a LEFT JOIN `vcos_strategy_category_language` b ON a.strategy_category_id = b.strategy_category_id WHERE a.state='1' AND b.iso = '".Yii::app()->language."'";
		$city_sel = $db->createCommand($city_sql)->queryAll();
		$category_sel = $db->createCommand($category_sql)->queryAll();
		/*
		$sql = "SELECT * FROM `vcos_strategy` a
			LEFT JOIN `vcos_strategy_language` b ON a.strategy_id = b.strategy_id
			RIGHT JOIN (SELECT c.city_id,d.city_name FROM `vcos_strategy_city` c LEFT JOIN `vcos_strategy_city_language` d ON c.city_id = d.city_id WHERE c.state = '1' AND d.iso = '".Yii::app()->language."' ) e ON a.city_id = e.city_id
			RIGHT JOIN (SELECT f.strategy_category_id,g.category_name FROM `vcos_strategy_category` f  LEFT JOIN `vcos_strategy_category_language` g ON f.strategy_category_id = g.strategy_category_id WHERE f.state = '1' AND g.iso = '".Yii::app()->language."') h ON a.strategy_category_id = h.strategy_category_id
			WHERE a.strategy_state = '1' AND ".$city." AND ".$category." AND ".$la_where." LIMIT {$criteria->offset}, {$pager->pageSize}";
		*/
		$sql = "SELECT a.*,b.iso,b.strategy_type,e.city_name,h.category_name,b.strategy_name,b.strategy_describe,b.avg_price,b.address FROM `vcos_strategy` a
		RIGHT JOIN `vcos_strategy_language` b ON a.strategy_id=b.strategy_id
		LEFT JOIN (SELECT c.city_id,d.city_name FROM `vcos_strategy_city` c
		LEFT JOIN `vcos_strategy_city_language` d  ON c.city_id=d.city_id WHERE d.iso='".Yii::app()->language."') e ON a.city_id = e.city_id
		LEFT JOIN (SELECT f.strategy_category_id,g.category_name FROM `vcos_strategy_category` f
		RIGHT JOIN `vcos_strategy_category_language` g ON f.strategy_category_id = g.strategy_category_id WHERE iso = '".Yii::app()->language."') h 
		ON h.strategy_category_id = a.strategy_category_id WHERE ".$city." AND ".$category." AND ".$la_where." LIMIT {$criteria->offset}, {$pager->pageSize}";
		
		$strategy = $db->createCommand($sql)->queryAll();
		/*
		 $category_sql = "SELECT a.country_id,b.country_name FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE b.iso = '".Yii::app()->language."' AND a.state = '1'";
		 $category_sel = Yii::app()->m_db->createCommand($country_sql)->queryAll();
		*/
		
		$this->render('strategy_list',array('city_sel'=>$city_sel,'category_sel'=>$category_sel,'res_but'=>$res_but,'res'=>$res,'category_but'=>$category_but,'pages'=>$pager,'auth'=>$this->auth,'strategy'=>$strategy));
	}
	
	/**攻略添加**/
	public function actionStrategy_add(){
		$this->setauth();//检查有无权限
		$strategy = new VcosStrategy();
		$strategy_language = new VcosStrategyLanguage();
		if($_POST){
			//判断语言
			if(isset($_POST['language']) && $_POST['language'] != ''){
				$country = isset($_POST['country_iso'])?$_POST['country_iso']:0;
				$city = isset($_POST['city_iso'])?$_POST['city_iso']:0;
				$category = isset($_POST['category_iso'])?$_POST['category_iso']:0;
			}else{
				$country = isset($_POST['country'])?$_POST['country']:0;
				$city = isset($_POST['city'])?$_POST['city']:0;
				$category = isset($_POST['category'])?$_POST['category']:0;
			}
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$price = isset($_POST['price'])?$_POST['price']*100:0;
			$address = isset($_POST['address'])?$_POST['address']:'';
			$phone = isset($_POST['phone'])?$_POST['phone']:'';
			$type = isset($_POST['type'])?$_POST['type']:'';
			$feature = isset($_POST['feature'])?$_POST['feature']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$photo_type = isset($_POST['photo_type'])?$_POST['photo_type']:0;
			//$contents = isset($_POST['contents'])?$_POST['contents']:'';
			//匹配替换编辑器中图片路径
			$msg = $_POST['contents'];
			$img_ueditor = Yii::app()->params['img_ueditor_php'];
			$describe = preg_replace($img_ueditor,'',$msg);
			$iso = isset($_POST['language'])?$_POST['language']:'zh_cn';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo;
			if($photo_type == 3){
				//是多图类型
				$photo2='';
				if($_FILES['photo2']['error']!=4){
					$result=Helper::upload_file('photo2', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
					$photo2=$result['filename'];
				}
				$photo2_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo2;
				$photo3='';
				if($_FILES['photo3']['error']!=4){
					$result=Helper::upload_file('photo3', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
					$photo3=$result['filename'];
				}
				$photo3_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo3;
			}
			
			$strategy->strategy_state = $state;
			$strategy->strategy_category_id = $category;
			$strategy->city_id = $city;
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$strategy->save();
				$strategy_language->strategy_id = $strategy->primaryKey;
				$strategy_language->iso = $iso;
				$strategy_language->strategy_name = $name;
				$strategy_language->strategy_describe = $desc;
				$strategy_language->show_style = $photo_type;
				$strategy_language->img_url = $photo_url;
				if($photo_type == 3){
					$strategy_language->img_url2 = $photo2_url;
					$strategy_language->img_url3 = $photo3_url;
				}
				$strategy_language->avg_price = $price;
				$strategy_language->address = $address;
				$strategy_language->strategy_type = $type;
				$strategy_language->telphone = $phone;
				$strategy_language->strategy_feature = $feature;
				$strategy_language->strategy_details = $describe;
				$strategy_language->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/strategy_list"));
			
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
			
		}
		
		$res_sql = "SELECT a.country_id,b.country_name,b.iso FROM vcos_strategy_country a RIGHT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE a.state = '1'";
		$country_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		$sql = "SELECT * FROM vcos_strategy_city a RIGHT JOIN vcos_strategy_city_language b ON a.city_id = b.city_id WHERE a.state = '1'  AND a.country_id = {$country_sel[0]['country_id']}";
		$city_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
		$cate_sel = "SELECT a.strategy_category_id,b.category_name,b.iso FROM vcos_strategy_category a LEFT JOIN vcos_strategy_category_language b ON a.strategy_category_id = b.strategy_category_id WHERE  a.state = '1'";
		$category_sel = Yii::app()->m_db->createCommand($cate_sel)->queryAll();
		$this->render('strategy_add',array('category_sel'=>$category_sel,'country_sel'=>$country_sel,'city_sel' => $city_sel,'strategy'=>$strategy,'strategy_language'=>$strategy_language));
	}
	
	public function actionCountryGetCity(){
		$sql = "SELECT a.city_id,b.city_name,b.iso FROM vcos_strategy_city a RIGHT JOIN vcos_strategy_city_language b ON a.city_id = b.city_id WHERE  a.state = '1' AND b.iso='{$_GET['iso']}' AND  a.country_id = {$_GET['country']}" ;
		$city_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
		echo json_encode($city_sel);
	}
	
	/**攻略编辑**/
	public function actionStrategy_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$strategy= VcosStrategy::model()->findByPk($id);
		$sql = "SELECT b.id FROM vcos_strategy a LEFT JOIN vcos_strategy_language b ON a.strategy_id = b.strategy_id WHERE a.strategy_id = {$id} ";
		$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
		$strategy_language = VcosStrategyLanguage::model()->findByPk($id2['id']);
		if($_POST){
			//var_dump($_POST);exit;
			//判断语言
			if(isset($_POST['language']) && $_POST['language'] != ''){
				$country = isset($_POST['country_iso'])?$_POST['country_iso']:0;
				$city = isset($_POST['city_iso'])?$_POST['city_iso']:0;
				$category = isset($_POST['category_iso'])?$_POST['category_iso']:0;
			}else{
				$country = isset($_POST['country'])?$_POST['country']:0;
				$city = isset($_POST['city'])?$_POST['city']:0;
				$category = isset($_POST['category'])?$_POST['category']:0;
			}
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$price = isset($_POST['price'])?$_POST['price']*100:0;
			$address = isset($_POST['address'])?$_POST['address']:'';
			$phone = isset($_POST['phone'])?$_POST['phone']:'';
			$type = isset($_POST['type'])?$_POST['type']:'';
			$feature = isset($_POST['feature'])?$_POST['feature']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$photo_type = isset($_POST['photo_type'])?$_POST['photo_type']:0;
			//$contents = isset($_POST['contents'])?$_POST['contents']:'';
			//匹配替换编辑器中图片路径
			$msg = $_POST['contents'];
			$img_ueditor = Yii::app()->params['img_ueditor_php'];
			$describe = preg_replace($img_ueditor,'',$msg);
			$iso = isset($_POST['language'])?$_POST['language']:'zh_cn';
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$photo_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo;
			if($photo_type == 3){
				//是多图类型
				$photo2='';
				if($_FILES['photo2']['error']!=4){
					$result=Helper::upload_file('photo2', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
					$photo2=$result['filename'];
				}
				$photo2_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo2;
				$photo3='';
				if($_FILES['photo3']['error']!=4){
					$result=Helper::upload_file('photo3', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
					$photo3=$result['filename'];
				}
				$photo3_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo3;
			}
			
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$strategy->strategy_id = $id;
				$strategy->strategy_category_id = $category;
				$strategy->city_id = $city;
				$strategy->strategy_state = $state;
				$strategy->save();
				$strategy_language->id = $id2['id'];
				$strategy_language->strategy_name = $name;
				$strategy_language->strategy_describe = $desc;
				$strategy_language->show_style = $photo_type;
				if($photo){//判断有无上传图片
					$strategy_language->img_url = $photo_url;
				}
				if($photo_type == 3){
					if($photo2){//判断有无上传图片
						$strategy_language->img_url2 = $photo2_url;
					}
					if($photo3){//判断有无上传图片
						$strategy_language->img_url3 = $photo3_url;
					}
				}
				$strategy_language->avg_price = $price;
				$strategy_language->address = $address;
				$strategy_language->strategy_type = $type;
				$strategy_language->telphone = $phone;
				$strategy_language->strategy_feature = $feature;
				$strategy_language->strategy_details = $describe;
				$strategy_language->iso = $iso;
				$strategy_language->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/Strategy_list"));
				
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		$country_id_sql = "SELECT a.country_id FROM `vcos_strategy_city` a WHERE city_id = (SELECT city_id FROM `vcos_strategy` WHERE strategy_id = ".$id.")";
		$country_id = Yii::app()->m_db->createCommand($country_id_sql)->queryRow();
		$res_sql = "SELECT a.country_id,b.country_name,b.iso FROM vcos_strategy_country a LEFT JOIN vcos_strategy_country_language b ON a.country_id = b.country_id WHERE  a.state = '1'";
		$country_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		$sql = "SELECT * FROM vcos_strategy_city a LEFT JOIN vcos_strategy_city_language b ON a.city_id = b.city_id WHERE a.state = '1' AND  a.country_id = {$country_id['country_id']}";
		$city_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
		$cate_sel = "SELECT a.strategy_category_id,b.category_name,b.iso FROM vcos_strategy_category a LEFT JOIN vcos_strategy_category_language b ON a.strategy_category_id = b.strategy_category_id WHERE  a.state = '1'";
		$category_sel = Yii::app()->m_db->createCommand($cate_sel)->queryAll();
		$this->render('strategy_edit',array('country_id'=>$country_id['country_id'],'category_sel'=>$category_sel,'city_sel'=>$city_sel,'country_sel'=>$country_sel,'strategy'=>$strategy,'strategy_language'=>$strategy_language));
	}
	
	public function actionGetiso_strategy(){
		$sql = "SELECT b.* FROM vcos_strategy a LEFT JOIN vcos_strategy_language b ON a.strategy_id = b.strategy_id WHERE a.strategy_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
		$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
		if($iso){
			echo json_encode($iso);
		}  else {
			echo 0;
		}
	}
	
	/**攻略图片列表**/
	public function actionStrategy_img_list(){
		$this->setauth();//检查有无权限
		$db = Yii::app()->m_db;
		$str = 0;
		$res = 'all';
		$where = 1;
		$str_where = 1;
		if(isset($_GET['res']) && $_GET['res'] != ''){
			if($_GET['res'] == 'all'){
				$where = 1;
				$res = 'all';
			}else if($_GET['res'] == 'zh_cn'){
				$where = "a.iso = 'zh_cn'";
				$res = 'zh_cn';
			}else if($_GET['res'] == 'en'){
				$where = "a.iso = 'en' ";
				$res = 'en';
			}
		}
		if(isset($_GET['strategy']) && $_GET['strategy'] != ''){
			if($_GET['strategy'] == 0){
				$str_where = 1;
				$str = 0;
			}else{
				$str_where = "a.strategy_id = ".$_GET['strategy'];
				$str = $_GET['strategy'];
			}
		}
		//批量删除
		if($_POST){
			$a = count($_POST['ids']);
			$result = VcosStrategyImg::model()->count();
			if($a == $result){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}
			$ids=implode('\',\'', $_POST['ids']);
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$count = VcosStrategyImg::model()->deleteAll("id in('$ids')");
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/Strategy_img_list"));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//单条删除
		if(isset($_GET['id'])){
			$result = VcosStrategyImg::model()->count();
			if($result<=1){
				die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
			}
			$did=$_GET['id'];
			//事务处理
			$transaction2=$db->beginTransaction();
			try{
				$count=VcosStrategyImg::model()->deleteByPk($did);
				$transaction2->commit();
				Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Strategy/Strategy_img_list"));
			}catch(Exception $e){
				$transaction2->rollBack();
				Helper::show_message(yii::t('vcos', '删除失败。'));
			}
		}
		//分页
		$count_sql = "SELECT count(*) count FROM `vcos_strategy_img` a
		LEFT JOIN `vcos_strategy_language` b ON a.strategy_id = b.strategy_id
		WHERE b.iso='".Yii::app()->language."' AND ".$where." AND ".$str_where;
		$count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
		$criteria = new CDbCriteria();
		$count = $count['count'];
		$pager = new CPagination($count);
		$pager->pageSize=10;
		$pager->applyLimit($criteria);
		/*
		$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
		$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		*/
		$sql = "SELECT a.strategy_id,b.strategy_name FROM `vcos_strategy` a LEFT JOIN `vcos_strategy_language` b ON a.strategy_id = b.strategy_id WHERE b.iso = '".Yii::app()->language."' AND a.strategy_state = '1'";
		$strategy_sel = Yii::app()->m_db->createCommand($sql)->queryAll();;
		
		$sql = "SELECT a.*,b.strategy_name FROM `vcos_strategy_img` a
		LEFT JOIN `vcos_strategy_language` b ON a.strategy_id = b.strategy_id 
		WHERE b.iso='".Yii::app()->language."' AND ".$where." AND ".$str_where." LIMIT {$criteria->offset}, {$pager->pageSize}";
		$strategy = Yii::app()->m_db->createCommand($sql)->queryAll();
		
		$this->render('strategy_img_list',array('str'=>$str,'pages'=>$pager,'res'=>$res,'strategy_sel'=>$strategy_sel,'auth'=>$this->auth,'strategy'=>$strategy));
	}
	
	public function actionStrategy_img_add(){
		$this->setauth();//检查有无权限
		$strategy_img = new VcosStrategyImg();
		if($_POST){
			$val = '';
			$iso = '';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$file_img = trim($_POST['file_img'],',');
			$file_img = explode(",",$file_img);
			if(isset($_POST['language']) && $_POST['language'] != ''){
				$iso = $_POST['language'];
			}else{
				$iso = Yii::app()->language;
			}
			foreach ($file_img as $row){
				/*
				$path_arr = explode("/",$row);
				$path_arr = array_slice($path_arr, -3, 3);
				$row = $path_arr[0].'/'.$path_arr[1].'/' . $path_arr[2];*/
				$row = explode('=', $row);
				$row = $row[1];
				//var_dump($row);exit;
				$val .= "('{$_POST['strategy']}','{$row}','{$iso}','{$state}','{$desc}'),";
			}
			$val = trim($val,',');
			 
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$sql = "INSERT INTO `vcos_strategy_img` (`strategy_id`, `img_url`, `iso`, `state`,`img_desc`) VALUES " .$val;
				$db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Strategy/Strategy_img_list"));
				 
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '添加失败。'), '#');
			}
			 
		}
		 
		$res_sql = "SELECT a.strategy_id,b.strategy_name FROM vcos_strategy a LEFT JOIN vcos_strategy_language b ON a.strategy_id = b.strategy_id WHERE b.iso = '".Yii::app()->language."' AND a.strategy_state = '1'";
		$strategy_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		 
		$this->render('strategy_img_add',array('strategy_sel'=>$strategy_sel,'strategy_img'=>$strategy_img));
	}
	
	/**编辑攻略图片**/
	public function actionStrategy_img_edit(){
		$this->setauth();//检查有无权限
		$id=$_GET['id'];
		$strategy_img = VcosStrategyImg::model()->findByPk($id);
		 
		if($_POST){
			
			$photo='';
			if($_FILES['photo']['error']!=4){
				$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'strategy_images/'.Yii::app()->params['month'], 'image', 3);
				$photo=$result['filename'];
			}
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$iso = isset($_POST['language'])?$_POST['language']:'zh_cn';
			/*
			 if($state == '0'){
			 $result = VcosRestaurantImg::model()->count('id=:id',array(':id'=>$id));
			 if($result>0){
			 die(Helper::show_message(yii::t('vcos', '此分类正在使用,不能禁用')));
			 }
			 }*/
			
			//事务处理
			$db = Yii::app()->m_db;
			$transaction=$db->beginTransaction();
			try{
				$strategy_img->id = $id;
				$strategy_img->strategy_id = $_POST['strategy'];
				$strategy_img->state = $state;
				$strategy_img->iso = $iso;
				$strategy_img->img_desc = $desc;
				if($photo){
					$strategy_img->img_url = 'strategy_images/'.Yii::app()->params['month'].'/'.$photo;
				}
				$strategy_img->save();
				$transaction->commit();
				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Strategy/Strategy_img_list"));
				 
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(yii::t('vcos', '修改失败。'), '#');
			}
		}
		 
		$res_sql = "SELECT a.strategy_id,b.strategy_name FROM vcos_strategy a LEFT JOIN vcos_strategy_language b ON a.strategy_id = b.strategy_id WHERE b.iso = '".Yii::app()->language."' AND a.strategy_state = '1'";
		$strategy_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
		
		$this->render('strategy_img_edit',array('strategy_sel'=>$strategy_sel,'strategy_img'=>$strategy_img));
	}
	
}