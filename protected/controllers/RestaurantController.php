<?php

class RestaurantController extends Controller
{
    public function actionRestaurant_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //多条删除
        if($_POST){
            $a = count($_POST['ids']);
            $ids=implode('\',\'', $_POST['ids']);
            $result = VcosRestaurant::model()->count();
            $count_sql = "select count(*) count from `vcos_food_category` WHERE restaurant_id in ('$ids')"; 
            $count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }else if($count_category['count'] > 0){
            	die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
            }
            
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosRestaurant::model()->deleteAll("restaurant_id in('$ids')");
                $count2 = VcosRestaurantLanguage::model()->deleteAll("restaurant_id in('$ids')");
                $count3 = VcosRestaurantImg::model()->deleteAll("restaurant_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/Restaurant_list"));   
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosRestaurant::model()->count();
            $count_sql = "select count(*) count from `vcos_food_category` WHERE restaurant_id =" .$_GET['id'];
            $count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }else if($count_category['count'] > 0){
            	die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count = VcosRestaurant::model()->deleteByPk($did);
                $count2 = VcosRestaurantLanguage::model()->deleteAll("restaurant_id in('$did')");
                $count3 = VcosRestaurantImg::model()->deleteAll("restaurant_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/Restaurant_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        
        $count_sql = "SELECT count(*) count FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.restaurant_id";
        $count = $db->createCommand($count_sql)->queryRow();
        
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        
        $sql = "SELECT * FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.restaurant_id LIMIT {$criteria->offset}, {$pager->pageSize}";
        $restaurant = $db->createCommand($sql)->queryAll();  
        $this->render('index',array('pages'=>$pager,'auth'=>$this->auth,'restaurant'=>$restaurant));
    }

    public function actionRestaurant_add()
    {
        $this->setauth();//检查有无权限
        $restaurant = new VcosRestaurant();
        $restaurant_language = new VcosRestaurantLanguage();
        if($_POST){
            $photo1='';
            $photo2='';
            if($_FILES['photo1']['error']!=4){
                $result=Helper::upload_file('photo1', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
                $photo1=$result['filename'];
            }
            if($_FILES['photo2']['error']!=4){
                $result=Helper::upload_file('photo2', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
                $photo2=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $delivery = isset($_POST['delivery'])?$_POST['delivery']:'0';
            $book = isset($_POST['book'])?$_POST['book']:'0';
            $restaurant->restaurant_tel = $_POST['tel'];
            $restaurant->restaurant_state = $state;
            $restaurant->can_delivery = $delivery;
            $restaurant->can_book = $book;
            $restaurant->restaurant_sequence = $_POST['sequence'];
            $restaurant->bg_color = $_POST['bgcolor'];
            $restaurant->restaurant_type = $_POST['type'];
            $restaurant->restaurant_img_url = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo1;
            $restaurant->restaurant_img_url2 = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo2;
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != ''){
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $restaurant->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_restaurant_language` (`restaurant_id`, `iso`, `restaurant_name`, `restaurant_address`, `restaurant_feature`, `restaurant_describe`, `restaurant_opening_time`) VALUES ('{$restaurant->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$_POST['address']}', '{$_POST['feature']}', '{$describe}', '{$_POST['time']}'), ('{$restaurant->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$_POST['address_iso']}', '{$_POST['feature_iso']}', '{$describe_iso}', '{$_POST['time_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/Restaurant_list"));
                }  else {//只添加系统语言时
                    $restaurant_language->restaurant_id = $restaurant->primaryKey;
                    $restaurant_language->iso = Yii::app()->params['language'];
                    $restaurant_language->restaurant_name = $_POST['title'];
                    $restaurant_language->restaurant_address = $_POST['address'];
                    $restaurant_language->restaurant_feature = $_POST['feature'];
                    $restaurant_language->restaurant_describe = $describe;
                    $restaurant_language->restaurant_opening_time = $_POST['time'];
                    $restaurant_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/Restaurant_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('restaurant_add',array('restaurant'=>$restaurant,'restaurant_language'=>$restaurant_language));
    }

     public function actionRestaurant_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $restaurant= VcosRestaurant::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE a.restaurant_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $restaurant_language = VcosRestaurantLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo1='';
            $photo2='';
            if($_FILES['photo1']['error']!=4){
                $result=Helper::upload_file('photo1', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
                $photo1=$result['filename'];
            }
            if($_FILES['photo2']['error']!=4){
                $result=Helper::upload_file('photo2', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
                $photo2=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $delivery = isset($_POST['delivery'])?$_POST['delivery']:'0';
            $book = isset($_POST['book'])?$_POST['book']:'0';
            //匹配替换编辑器中图片路径
            $msg = $_POST['describe'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['describe_iso'] != ''){
            	$msg_iso = $_POST['describe_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('restaurant_type'=>$_POST['type'],'restaurant_tel'=>$_POST['tel'],'restaurant_state'=>$state,'restaurant_sequence'=>$_POST['sequence'],'bg_color'=>$_POST['bgcolor'],'can_delivery'=>$delivery,'can_book'=>$book);
                    if($photo1){//判断有无上传图片
                        $columns['restaurant_img_url'] = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo1;
                    }
                    if($photo2){//判断有无上传图片
                        $columns['restaurant_img_url2'] = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo2;
                    }
                    $db->createCommand()->update('vcos_restaurant',$columns,'restaurant_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_restaurant_language', array('restaurant_name'=>$_POST['title'],'restaurant_address'=>$_POST['address'],'restaurant_feature'=>$_POST['feature'],'restaurant_describe'=>$describe,'restaurant_opening_time'=>$_POST['time']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_restaurant_language',array('restaurant_id'=>$id,'iso'=>$_POST['language'],'restaurant_name'=>$_POST['title_iso'],'restaurant_address'=>$_POST['address_iso'],'restaurant_feature'=>$_POST['feature_iso'],'restaurant_describe'=>$describe_iso,'restaurant_opening_time'=>$_POST['time_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_restaurant_language', array('restaurant_name'=>$_POST['title_iso'],'restaurant_address'=>$_POST['address_iso'],'restaurant_feature'=>$_POST['feature_iso'],'restaurant_describe'=>$describe_iso,'restaurant_opening_time'=>$_POST['time_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Restaurant_list"));
                }  else {//只编辑系统语言状态下
                    $restaurant->restaurant_id = $id;$restaurant->restaurant_tel = $_POST['tel'];
                    $restaurant->restaurant_state = $state;
                    $restaurant->can_delivery = $delivery;
                    $restaurant->can_book = $book;
                    $restaurant->restaurant_sequence = $_POST['sequence'];
                    $restaurant->bg_color = $_POST['bgcolor'];
                    $restaurant->restaurant_type = $_POST['type'];
                    if($photo1){
                            $restaurant->restaurant_img_url = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo1;
                    }
                    if($photo2){
                            $restaurant->restaurant_img_url2 = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo2;
                    }
                    $restaurant->save();
                    $restaurant_language->id = $id2['id'];
                    $restaurant_language->restaurant_name = $_POST['title'];
                    $restaurant_language->restaurant_address = $_POST['address'];
                    $restaurant_language->restaurant_feature = $_POST['feature'];
                    $restaurant_language->restaurant_describe = $describe;
                    $restaurant_language->restaurant_opening_time = $_POST['time'];
                    $restaurant_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Restaurant_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $this->render('restaurant_edit',array('restaurant'=>$restaurant,'restaurant_language'=>$restaurant_language));
    }
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.restaurant_name, b.restaurant_address, b.restaurant_feature, b.restaurant_describe, b.restaurant_opening_time FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE a.restaurant_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionFood_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        $where = 1;
        $res_but = 0;
        if(isset($_GET['restaurant']) && $_GET['restaurant'] != ''){
        	if($_GET['restaurant'] == 0){
        		$where = 1;
        	}else{
        		$where = "a.restaurant_id = ".$_GET['restaurant'];
        		$res_but = $_GET['restaurant'];
        	}
        }
        //单条删除
        if(isset($_GET['id'])){
        	
            $result = VcosFood::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosFood::model()->deleteByPk($did);
                $count2 = VcosFoodLanguage::model()->deleteAll("food_id in('$did')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/food_list"));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT *,count(*) count FROM vcos_food a
		LEFT JOIN vcos_food_language b ON a.food_id = b.food_id
		RIGHT JOIN (SELECT c.restaurant_id,d.restaurant_name FROM vcos_restaurant c
		LEFT join vcos_restaurant_language d ON c.restaurant_id = d.restaurant_id WHERE d.iso = '".Yii::app()->language."' AND c.restaurant_state = '1') e ON e.restaurant_id = a.restaurant_id
		LEFT JOIN (SELECT f.food_category_id,g.food_category_name FROM vcos_food_category f
		LEFT JOIN vcos_food_category_language g ON f.food_category_id = g.food_category_id WHERE g.iso = '".Yii::app()->language."' AND f.food_category_state = '1') h ON h.food_category_id = a.food_category_id
		WHERE b.iso = '".Yii::app()->language."' AND ".$where;
        $count = $db->createCommand($count_sql)->queryRow();
        
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        //$sql = "SELECT * FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE b.iso = '".Yii::app()->params['language']."' ORDER BY a.food_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $sql = "SELECT * FROM vcos_food a
		LEFT JOIN vcos_food_language b ON a.food_id = b.food_id  
		RIGHT JOIN (SELECT c.restaurant_id,d.restaurant_name FROM vcos_restaurant c 
		LEFT join vcos_restaurant_language d ON c.restaurant_id = d.restaurant_id WHERE d.iso = '".Yii::app()->language."' AND c.restaurant_state = '1') e ON e.restaurant_id = a.restaurant_id
		LEFT JOIN (SELECT f.food_category_id,g.food_category_name FROM vcos_food_category f 
		LEFT JOIN vcos_food_category_language g ON f.food_category_id = g.food_category_id WHERE g.iso = '".Yii::app()->language."' AND f.food_category_state = '1') h ON h.food_category_id = a.food_category_id
		WHERE b.iso = '".Yii::app()->language."' AND ".$where." LIMIT {$criteria->offset}, {$pager->pageSize}";
        $food = $db->createCommand($sql)->queryAll();
        $res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
        $restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
        $this->render('food_list',array('res_but'=>$res_but,'restaurant_sel'=>$restaurant_sel,'pages'=>$pager,'auth'=>$this->auth,'food'=>$food));
    }
    
    public function actionFood_add()
    {
        $this->setauth();//检查有无权限
        $food = new VcosFood();
        $food_language = new VcosFoodLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $food->food_price = $_POST['price']*100;
            $food->max_buy = $_POST['max_buy'];
            $food->food_category_id = $_POST['food_category'];
            $food->food_state = $state;
            $food->restaurant_id = $_POST['restaurant'];
            $food->food_img_url = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo;
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $food->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_food_language` (`food_id`, `iso`, `main_title`, `food_title`) VALUES ('{$food->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['main_title']}', '{$_POST['food_title']}'), ('{$food->primaryKey}', '{$_POST['language']}', '{$_POST['main_title_iso']}', '{$_POST['food_title_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/food_list"));
                }  else {//只添加系统语言时
                    $food_language->food_id = $food->primaryKey;
                    $food_language->iso = Yii::app()->params['language'];
                    $food_language->main_title = $_POST['main_title'];
                    $food_language->food_title = $_POST['food_title'];
                    $food_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/food_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	if($restaurant_sel){
    		$val = $restaurant_sel[0]['restaurant_id'];
    	}else{	
    		$val = '';
    	}
    	$sql = "SELECT * FROM `vcos_food_category` a LEFT JOIN `vcos_food_category_language` b ON a.food_category_id = b.food_category_id WHERE a.food_category_state = '1' AND b.iso = '".Yii::app()->language."' AND a.restaurant_id ='{$val}'";
    	$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
   
        $this->render('food_add',array('restaurant_sel'=>$restaurant_sel,'category_sel' => $category_sel,'food'=>$food,'food_language'=>$food_language));
    }
    
     public function actionFood_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $food= VcosFood::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE a.food_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $food_language = VcosFoodLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            /*
            if($state == '0'){
                $sql = "SELECT food_setting FROM vcos_restaurant";
                $result = Yii::app()->m_db->createCommand($sql)->queryAll();
                $results =array();
                foreach($result as $key=>$row){
                    $results[$key] = json_decode($row['food_setting'],true);
                }
                foreach($results as $rows){
                    if($rows){
                        if(in_array($id, $rows)){
                            die(Helper::show_message(yii::t('vcos', '此套餐正在使用,不能禁用')));
                        }
                    }
                }
            }*/
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('food_price'=>($_POST['price']*100),'food_state'=>$state,'max_buy'=>$_POST['max_buy'],'food_category_id'=>$_POST['food_category'],'restaurant_id'=>$_POST['restaurant']);
                    if($photo){//判断有无上传图片
                        $columns['food_img_url'] = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_food',$columns,'food_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_food_language', array('main_title'=>$_POST['main_title'],'food_title'=>$_POST['food_title']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_food_language',array('food_id'=>$id,'iso'=>$_POST['language'],'main_title'=>$_POST['main_title_iso'],'food_title'=>$_POST['food_title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_food_language', array('main_title'=>$_POST['main_title_iso'],'food_title'=>$_POST['food_title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Food_list"));
                }  else {//只编辑系统语言状态下
                    $food->food_id = $id;
                    $food->food_price = $_POST['price']*100;
                    $food->max_buy = $_POST['max_buy'];
                    $food->food_category_id = $_POST['food_category'];
                    $food->food_state = $state;
                    $food->restaurant_id = $_POST['restaurant'];
                    if($photo){
                        $food->food_img_url = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $food->save();
                    $food_language->id = $id2['id'];
                    $food_language->main_title = $_POST['main_title'];
                    $food_language->food_title = $_POST['food_title'];
                    $food_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Food_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
        $restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
        $sql = "SELECT a.food_category_id,b.food_category_name FROM vcos_food_category a LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id WHERE a.food_category_state = '1' AND b.iso = '".Yii::app()->language."' AND a.restaurant_id = {$food['restaurant_id']}" ;
        $category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('food_edit',array('restaurant_sel'=>$restaurant_sel,'category_sel'=>$category_sel,'food'=>$food,'food_language'=>$food_language));
    }
    
    /**根据餐厅获取分类**/
    public function actionRestaurantGetCategory(){
    	$sql = "SELECT a.food_category_id,b.food_category_name FROM vcos_food_category a LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id WHERE  a.food_category_state = '1' AND b.iso = '".Yii::app()->language."' AND a.restaurant_id = {$_GET['restaurant']}" ;
    	$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	echo json_encode($category_sel);
    } 
    
    
    
    public function actionGetiso_food()
    {
        $sql = "SELECT b.id, b.main_title, b.food_title FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE a.food_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionFood_setting()
    {
        $this->setauth();//检查有无权限
        $setting = NULL;
        if(isset($_GET['id'])){
            if($_GET['id']!=''){
                $sql = "SELECT food_setting FROM vcos_restaurant WHERE restaurant_id = {$_GET['id']}";
                $setting = Yii::app()->m_db->createCommand($sql)->queryRow();
                $setting = json_decode($setting['food_setting'],true);
            }
        }
        if($_POST){
            $ids=  json_encode($_POST['ids']);
            $restaurant = VcosRestaurant::model()->findByPk($_GET['id']);
            $restaurant->restaurant_id = $_GET['id'];
            $restaurant->food_setting = $ids;
            if($restaurant->save()>0){
                Helper::show_message(yii::t('vcos', '分配成功'), Yii::app()->createUrl("Restaurant/Food_setting")."?id=".$_GET['id']); 
            }
        }
        $sql = "SELECT * FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE a.restaurant_state = '1' AND a.can_delivery = '1' AND b.iso = '".Yii::app()->language."'";
        $restaurant = Yii::app()->m_db->createCommand($sql)->queryAll();
        $sql2 = "SELECT * FROM vcos_food a LEFT JOIN vcos_food_language b ON a.food_id = b.food_id WHERE a.food_state = '1' AND b.iso = '".Yii::app()->language."'";
        $food = Yii::app()->m_db->createCommand($sql2)->queryAll();
        $this->render('food_setting',array('setting'=>$setting,'food'=>$food,'restaurant'=>$restaurant));
    }
    
    public function actionCheckrestaurant()
    {
        $sql = "SELECT food_setting FROM vcos_restaurant";
        $result = Yii::app()->m_db->createCommand($sql)->queryAll();
        $results =array();
        foreach($result as $key=>$row){
            $results[$key] = json_decode($row['food_setting'],true);
        }
        foreach($results as $row){
            if(in_array($_POST['id'], $row)){
                echo TRUE;
                break;
            }
        }
    }
    
    /**食物分类列表**/
    Public function actionCategory_list(){
    	$this->setauth();//检查有无权限
    	$db = Yii::app()->m_db;
    	$where = 1;
    	$res_but = 0;
    	if(isset($_GET['restaurant']) && $_GET['restaurant'] != ''){
    		if($_GET['restaurant'] == 0){
    			$where = 1;
    		}else{
    			$where = "a.restaurant_id = ".$_GET['restaurant'];
    			$res_but = $_GET['restaurant'];
    		}
    	}
    	//批量删除
    	if($_POST){
    		$a = count($_POST['ids']);
    		$ids=implode('\',\'', $_POST['ids']);
    		$result = VcosFoodCategory::model()->count();
    		$count_sql = "SELECT count(*) count FROM `vcos_food` WHERE food_category_id in('$ids')";
    		$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    		if($a == $result){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}else if($count_category['count'] >0){
    			die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
    		}
    		
    		//事务处理
    		$transaction=$db->beginTransaction();
    		try{
    			$count = VcosFoodCategory::model()->deleteAll("food_category_id in('$ids')");
    			$count2 = VcosFoodCategoryLanguage::model()->deleteAll("food_category_id in('$ids')");
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/Category_list"));
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	//单条删除
    	if(isset($_GET['id'])){
    		$result = VcosFoodCategory::model()->count();
    		$count_sql = "SELECT count(*) count FROM `vcos_food` WHERE food_category_id =" .$_GET['id'];
    		$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    		if($result<=1){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}else if($count_category['count'] > 0){
    			die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
    		}
    		$did=$_GET['id'];
    		//事务处理
    		$transaction2=$db->beginTransaction();
    		try{
    			$count=VcosFoodCategory::model()->deleteByPk($did);
    			$count2 = VcosFoodCategoryLanguage::model()->deleteAll("food_category_id in('$did')");
    			$transaction2->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/Category_list"));
    		}catch(Exception $e){
    			$transaction2->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	$count_sql = "SELECT count(*) count FROM vcos_food_category a
    			LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id
    			LEFT JOIN vcos_restaurant e ON a.restaurant_id = e.restaurant_id
    			LEFT JOIN (select * from vcos_restaurant_language d where iso = '".Yii::app()->language."') d ON a.restaurant_id = d.restaurant_id
    					WHERE b.iso = '".Yii::app()->language."' AND ".$where." AND e.restaurant_state = '1'  ORDER BY a.restaurant_id";
    	$count = $db->createCommand($count_sql)->queryRow();
    	//分页
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$sql = "SELECT a.*,b.*,d.restaurant_name FROM vcos_food_category a 
    			LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id 
    			LEFT JOIN vcos_restaurant e ON a.restaurant_id = e.restaurant_id
    			LEFT JOIN (select * from vcos_restaurant_language d where iso = '".Yii::app()->language."') d ON a.restaurant_id = d.restaurant_id  
    					WHERE b.iso = '".Yii::app()->language."' AND ".$where." AND e.restaurant_state = '1'  ORDER BY a.restaurant_id LIMIT {$criteria->offset}, {$pager->pageSize}";
    	$restaurant = $db->createCommand($sql)->queryAll();
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	$this->render('category_list',array('res_but'=>$res_but,'restaurant_sel'=>$restaurant_sel,'pages'=>$pager,'auth'=>$this->auth,'restaurant'=>$restaurant));
    	
    }
    
    /**食物分类添加**/
    Public function actionCategory_add(){
    	$this->setauth();//检查有无权限
    	$food_category = new VcosFoodCategory();
    	$food_category_language = new VcosFoodCategoryLanguage();
    	if($_POST){
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		$parent_id = isset($_POST['parent_category'])?$_POST['parent_category']:'0';
    		$food_category->list_order = $_POST['sequence'];
    		$food_category->food_category_state = $state;
    		$food_category->restaurant_id = $_POST['restaurant'];
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			$food_category->save();
    			if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
    				$sql = "INSERT INTO `vcos_food_category_language` (`food_category_id`, `iso`, `food_category_name`) VALUES ('{$food_category->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['category']}'), ('{$food_category->primaryKey}', '{$_POST['language']}', '{$_POST['category_iso']}')";
    				$db->createCommand($sql)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/category_list"));
    			}  else {//只添加系统语言时
    				/*
    				$food_category_language->food_category_id = $food_category->primaryKey;
    				$food_category_language->iso = Yii::app()->params['language'];
    				$food_category_language->food_category_name = $_POST['category'];
					$food_category_language->save();
    				*/
					$sql = "INSERT INTO `vcos_food_category_language` (`food_category_id`, `iso`, `food_category_name`) VALUES ('{$food_category->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['category']}')";
					$db->createCommand($sql)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/category_list"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
    		}
    	}
    	//$sql = "SELECT * FROM vcos_food_category a LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id WHERE a.food_category_state = '1' AND b.iso = '".Yii::app()->language."' and a.parent_id = 0";
    	//$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	$this->render('category_add',array('restaurant_sel'=>$restaurant_sel,'food_category'=>$food_category,'food_category_language'=>$food_category_language));
    }
    
    /**编辑食物分类**/
    public function actionCategory_edit(){
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$food_category= VcosFoodCategory::model()->findByPk($id);
    	$sql = "SELECT b.id FROM vcos_food_category a LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id WHERE a.food_category_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
    	$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
    	$food_category_language = VcosFoodCategoryLanguage::model()->findByPk($id2['id']);
    	
    	if($_POST){
    		
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		/*
    		if($state == '0'){
    			$result = VcosFoodCategory::model()->count('food_category_id=:id',array(':id'=>$id));
    			if($result>0){
    				die(Helper::show_message(yii::t('vcos', '此分类正在使用,不能禁用')));
    			}
    		}*/
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
    				//编辑主表
    				$columns = array('food_category_state'=>$state,'list_order'=>$_POST['sequence'],'restaurant_id'=>$_POST['restaurant']);
    				$db->createCommand()->update('vcos_food_category',$columns,'food_category_id = :id',array(':id'=>$id));
    				//编辑系统语言
    				$db->createCommand()->update('vcos_food_category_language', array('food_category_name'=>$_POST['category']), 'id=:id', array(':id'=>$id2['id']));
    				//判断外语是新增OR编辑
    				if($_POST['judge']=='add'){
    					//新增外语
    					$db->createCommand()->insert('vcos_food_category_language',array('food_category_id'=>$id,'iso'=>$_POST['language'],'food_category_name'=>$_POST['category_iso']));
    				}  else {
    					//编辑外语
    					$db->createCommand()->update('vcos_food_category_language', array('food_category_name'=>$_POST['category_iso']), 'id=:id', array(':id'=>$_POST['judge']));
    				}
    				//事务提交
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Category_list"));
    			}  else {//只编辑系统语言状态下
    				$food_category->food_category_id = $id;
    				$food_category->food_category_state = $state;
    				$food_category->list_order = $_POST['sequence'];
    				$food_category->restaurant_id = $_POST['restaurant'];
    				$food_category->save();
    				$food_category_language->id = $id2['id'];
    				$food_category_language->food_category_name = $_POST['category'];
    				$food_category_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Category_list"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '修改失败。'), '#');
    		}
    	}
    	//$sql = "SELECT * FROM vcos_food_category a LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id WHERE a.food_category_state = '1' AND b.iso = '".Yii::app()->language."' and a.parent_id = 0";
    	//$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	$this->render('category_edit',array('restaurant_sel'=>$restaurant_sel,'food_category'=>$food_category,'food_category_language'=>$food_category_language));
    } 
    
    public function actionGetiso_category()
    {
    	$sql = "SELECT b.id, b.food_category_name FROM vcos_food_category a LEFT JOIN vcos_food_category_language b ON a.food_category_id = b.food_category_id WHERE a.food_category_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
    	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($iso){
    		echo json_encode($iso);
    	}  else {
    		echo 0;
    	}
    }
    
    /**添加餐厅图片***/
    public function actionRestaurant_img_add(){
    	$this->setauth();//检查有无权限
    	$restaurant_img = new VcosRestaurantImg();
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
    			$val .= "('{$_POST['restaurant']}','{$row}','{$iso}','{$state}'),";
    		}
    		$val = trim($val,',');
    	
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			$sql = "INSERT INTO `vcos_restaurant_img` (`restaurant_id`, `img_url`, `iso`, `state`) VALUES " .$val;
    			$db->createCommand($sql)->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Restaurant/Restaurant_img_list"));
    			
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
    		}
    	
    	}
    	
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	
    	$this->render('restaurant_img_add',array('restaurant_sel'=>$restaurant_sel,'restaurant_img'=>$restaurant_img));
    }
    

    /**餐厅图片列表***/
    public function actionRestaurant_img_list(){
    	$this->setauth();//检查有无权限
    	
    	$db = Yii::app()->m_db;
    	$where = 1;
    	$res_but = 0;
    	$res = 'all';
    	$la_where = 1;
    	if(isset($_GET['restaurant']) && $_GET['restaurant'] != ''){
    		if($_GET['restaurant'] == 0){
    			$where = 1;
    			$res_but = 0;
    		}else{
    			$where = "a.restaurant_id = ".$_GET['restaurant'];
    			$res_but = $_GET['restaurant'];
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
    	if(isset($_GET['res']) && $_GET['res'] != '' && isset($_GET['restaurant']) && $_GET['restaurant'] != ''){
    		$res_where = $where .' AND ' .$la_where;
    	}elseif (isset($_GET['res']) && $_GET['res'] != '' && !isset($_GET['restaurant'])){
    		$res_where = $la_where;
    	}elseif (isset($_GET['restaurant']) && $_GET['restaurant'] != '' && !isset($_GET['res'])){
    		$res_where = $where;
    	}else{
    		$res_where = 1;
    	}*/
    	
    	
    	//批量删除
    	if($_POST){
    		$a = count($_POST['ids']);
    		$result = VcosRestaurantImg::model()->count();
    		if($a == $result){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		$ids=implode('\',\'', $_POST['ids']);
    		//事务处理
    		$transaction=$db->beginTransaction();
    		try{
    			$count = VcosRestaurantImg::model()->deleteAll("id in('$ids')");
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/Restaurant_img_list"));
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	//单条删除
    	if(isset($_GET['id'])){
    		$result = VcosRestaurantImg::model()->count();
    		if($result<=1){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		$did=$_GET['id'];
    		//事务处理
    		$transaction2=$db->beginTransaction();
    		try{
    			$count=VcosRestaurantImg::model()->deleteByPk($did);
    			$transaction2->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Restaurant/Restaurant_img_list"));
    		}catch(Exception $e){
    			$transaction2->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	$count_sql = "SELECT count(*) count from `vcos_restaurant_img` a
				LEFT JOIN `vcos_restaurant` b ON a.restaurant_id = b.restaurant_id
				LEFT JOIN (SELECT * from `vcos_restaurant_language` c WHERE c.iso = '".Yii::app()->language."') c ON a.restaurant_id = c.restaurant_id
				WHERE b.restaurant_state = '1' AND ".$where." AND ".$la_where."  ORDER BY a.restaurant_id ";
    	$count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
    	//分页
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	$sql = "SELECT a.*,c.restaurant_name,c.iso from `vcos_restaurant_img` a 
				LEFT JOIN `vcos_restaurant` b ON a.restaurant_id = b.restaurant_id
				LEFT JOIN (SELECT * from `vcos_restaurant_language` c WHERE c.iso = '".Yii::app()->language."') c ON a.restaurant_id = c.restaurant_id
				WHERE b.restaurant_state = '1' AND ".$where." AND ".$la_where."  ORDER BY a.restaurant_id LIMIT {$criteria->offset}, {$pager->pageSize}";
    	
    	$restaurant = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('restaurant_img_list',array('res'=>$res,'pages'=>$pager,'restaurant_sel'=>$restaurant_sel,'res_but'=>$res_but,'auth'=>$this->auth,'restaurant'=>$restaurant));
    }
    
    
    /**编辑餐厅图片**/
    public function actionRestaurant_img_edit(){
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$restaurant_img = VcosRestaurantImg::model()->findByPk($id);
    	
    	if($_POST){
    		$photo='';
    		if($_FILES['photo']['error']!=4){
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'restaurant_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
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
    			$restaurant_img->id = $id;
    			$restaurant_img->restaurant_id = $_POST['restaurant'];
    			$restaurant_img->state = $state;
    			$restaurant_img->iso = $iso;
    			if($photo){
    				$restaurant_img->img_url = 'restaurant_images/'.Yii::app()->params['month'].'/'.$photo;
    			}
    			$restaurant_img->save();
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Restaurant/Restaurant_img_list"));
    			
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '修改失败。'), '#');
    		}
    	}
    	
    	$res_sql = "SELECT a.restaurant_id,b.restaurant_name FROM vcos_restaurant a LEFT JOIN vcos_restaurant_language b ON a.restaurant_id = b.restaurant_id WHERE b.iso = '".Yii::app()->language."' AND a.restaurant_state = '1'";
    	$restaurant_sel = Yii::app()->m_db->createCommand($res_sql)->queryAll();
    	$this->render('restaurant_img_edit',array('restaurant_sel'=>$restaurant_sel,'restaurant_img'=>$restaurant_img));
    }
    
    
}