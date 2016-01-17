<?php

class DutyfreegoodsController extends Controller
{
    public function actionGoods_list()
    {
        $this->setauth();//检查有无权限
        //批量删除
        $db = Yii::app()->m_db;
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosDutyfreeGoods::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosDutyfreeGoods::model()->deleteAll("goods_id in('$ids')");
                $count2 = VcosDutyfreeGoodsLanguage::model()->deleteAll("goods_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_list")); 
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosDutyfreeGoods::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosDutyfreeGoods::model()->deleteByPk($did);
                $count2 = VcosDutyfreeGoodsLanguage::model()->deleteAll("goods_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_list"));  
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_dutyfree_goods a, vcos_dutyfree_goods_language b, vcos_dutyfree_goods_category c, vcos_dutyfree_goods_category_language d WHERE a.goods_id = b.goods_id AND a.goods_category = c.gc_id AND a.goods_category = d.gc_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.goods_id DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_dutyfree_goods a, vcos_dutyfree_goods_language b, vcos_dutyfree_goods_category c, vcos_dutyfree_goods_category_language d WHERE a.goods_id = b.goods_id AND a.goods_category = c.gc_id AND a.goods_category = d.gc_id AND b.iso = '".Yii::app()->language."' AND d.iso = '".Yii::app()->language."' ORDER BY a.goods_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $goods = $db->createCommand($sql)->queryAll();
        $this->render('index',array('pages'=>$pager,'auth'=>$this->auth,'goods'=>$goods));
    }
        
    public function actionGoods_add()
    {
        $this->setauth();//检查有无权限
        $goods = new VcosDutyfreeGoods();
        $goods_language = new VcosDutyfreeGoodsLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'dutyfreegoods_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $goods->goods_price = $_POST['price']*100;
            $goods->goods_category = $_POST['type'];
            $goods->goods_state = $state;
            $goods->goods_img_url = 'dutyfreegoods_images/'.Yii::app()->params['month'].'/'.$photo;
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $goods->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_dutyfree_goods_language` (`goods_id`, `iso`, `goods_name`, `goods_info`) VALUES ('{$goods->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$_POST['info']}'), ('{$goods->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$_POST['info_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_list"));
                }  else {//只添加系统语言时
                    $goods_language->goods_id = $goods->primaryKey;
                    $goods_language->iso = Yii::app()->params['language'];
                    $goods_language->goods_name = $_POST['title'];
                    $goods_language->goods_info = $_POST['info'];
                    $goods_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT * FROM vcos_dutyfree_goods_category a LEFT JOIN vcos_dutyfree_goods_category_language b ON a.gc_id = b.gc_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
        $category = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('goods_add',array('category'=>$category,'goods'=>$goods,'goods_language'=>$goods_language));
    }
    
    public function actionGoods_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $goods= VcosDutyfreeGoods::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_dutyfree_goods a LEFT JOIN vcos_dutyfree_goods_language b ON a.goods_id = b.goods_id WHERE a.goods_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $goods_language = VcosDutyfreeGoodsLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'dutyfreegoods_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('goods_price'=>($_POST['price']*100),'goods_state'=>$state,'goods_category'=>$_POST['type']);
                    if($photo){//判断有无上传图片
                        $columns['goods_img_url'] = 'dutyfreegoods_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_dutyfree_goods',$columns,'goods_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_dutyfree_goods_language', array('goods_name'=>$_POST['title'],'goods_info'=>$_POST['info']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_dutyfree_goods_language',array('goods_id'=>$id,'iso'=>$_POST['language'],'goods_name'=>$_POST['title_iso'],'goods_info'=>$_POST['info_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_dutyfree_goods_language', array('goods_name'=>$_POST['title_iso'],'goods_info'=>$_POST['info_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_list"));
                }  else {//只编辑系统语言
                    $goods->goods_id = $id;
                    $goods->goods_price = $_POST['price']*100;
                    $goods->goods_category = $_POST['type'];
                    $goods->goods_state = $state;
                    if($photo){
                        $goods->goods_img_url = 'dutyfreegoods_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $goods->save();
                    $goods_language->id = $id2['id'];
                    $goods_language->goods_name = $_POST['title'];
                    $goods_language->goods_info = $_POST['info'];
                    $goods_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $sql = "SELECT * FROM vcos_dutyfree_goods_category a LEFT JOIN vcos_dutyfree_goods_category_language b ON a.gc_id = b.gc_id WHERE a.state = '1' AND b.iso = '".Yii::app()->language."'";
        $category = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('goods_edit',array('goods'=>$goods,'goods_language'=>$goods_language,'category'=>$category));
    }
    
    public function actionGetiso_goods()
    {
        $sql = "SELECT b.id, b.goods_name, b.goods_info FROM vcos_dutyfree_goods a LEFT JOIN vcos_dutyfree_goods_language b ON a.goods_id = b.goods_id WHERE a.goods_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
        
    public function actionGoods_category()
    {
        $this->setauth();//检查有无权限
        //单条删除
        $db = Yii::app()->m_db;
        if(isset($_GET['id'])){
            $result = VcosDutyfreeGoodsCategory::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosDutyfreeGoodsCategory::model()->deleteByPk($did);
                $count2 =VcosDutyfreeGoodsCategoryLanguage::model()->deleteAll("gc_id in('$did')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_category"));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_dutyfree_goods_category a LEFT JOIN vcos_dutyfree_goods_category_language b ON a.gc_id = b.gc_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.gc_id ASC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_dutyfree_goods_category a LEFT JOIN vcos_dutyfree_goods_category_language b ON a.gc_id = b.gc_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.gc_id ASC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $category = $db->createCommand($sql)->queryAll();
        $this->render('goods_category',array('pages'=>$pager,'auth'=>$this->auth,'category'=>$category));
    }
        
    public function actionGoods_category_add()
    {
        $this->setauth();//检查有无权限
        $category = new VcosDutyfreeGoodsCategory();
        $category_language = new VcosDutyfreeGoodsCategoryLanguage();
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'dutyfreegoods_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $category->bg_color = $_POST['bgcolor'];
            $category->state = $state;
            $category->gc_img_url = 'dutyfreegoods_images/'.Yii::app()->params['month'].'/'.$photo;
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $category->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_dutyfree_goods_category_language` (`gc_id`, `iso`, `gc_name`) VALUES ('{$category->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}'), ('{$category->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_category"));
                }  else {//只添加系统语言时
                    $category_language->gc_id = $category->primaryKey;
                    $category_language->iso = Yii::app()->params['language'];
                    $category_language->gc_name = $_POST['title'];
                    $category_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_category"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('goods_category_add',array('category'=>$category,'category_language'=>$category_language));
    }
        
    public function actionGoods_category_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $category= VcosDutyfreeGoodsCategory::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_dutyfree_goods_category a LEFT JOIN vcos_dutyfree_goods_category_language b ON a.gc_id = b.gc_id WHERE a.gc_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $category_language = VcosDutyfreeGoodsCategoryLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'dutyfreegoods_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            if($state == '0'){
                $result = VcosDutyfreeGoods::model()->count('goods_category=:id',array(':id'=>$id));
                if($result>0){
                    die(Helper::show_message(yii::t('vcos', '此分类正在使用,不能禁用。')));
                }
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('state'=>$state,'bg_color'=>$_POST['bgcolor']);
                    if($photo){//判断有无上传图片
                        $columns['gc_img_url'] = 'dutyfreegoods_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_dutyfree_goods_category',$columns,'gc_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_dutyfree_goods_category_language', array('gc_name'=>$_POST['title']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_dutyfree_goods_category_language',array('gc_id'=>$id,'iso'=>$_POST['language'],'gc_name'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_dutyfree_goods_category_language', array('gc_name'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_category"));
                }  else {//只编辑系统语言
                    $category->gc_id = $id;
                    $category->bg_color = $_POST['bgcolor'];
                    $category->state = $state;
                    if($photo){
                        $category->gc_img_url = 'dutyfreegoods_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $category->save();
                    $category_language->id = $id2['id'];
                    $category_language->gc_name = $_POST['title'];
                    $category_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Dutyfreegoods/Goods_category"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $this->render('goods_category_edit',array('category'=>$category,'category_language'=>$category_language));
    }
    
    public function actionGetiso_gc()
    {
        $sql = "SELECT b.id, b.gc_name FROM vcos_dutyfree_goods_category a LEFT JOIN vcos_dutyfree_goods_category_language b ON a.gc_id = b.gc_id WHERE a.gc_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionChecknameajax()
    {
        $sql = "SELECT * FROM vcos_dutyfree_goods WHERE goods_name = '{$_POST['title']}'";
        $name = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($name){
            echo "false";
        }else{
            echo "true";
        }
    }
    
    public function actionCheckgoods()
    {
        $result = VcosDutyfreeGoods::model()->count('goods_category=:id',array(':id'=>$_POST['id']));
        echo $result;
    }
    
    public function actionCheckcategory()
    {
        $sql = "SELECT * FROM vcos_dutyfree_goods_category WHERE gc_name = '{$_POST['title']}'";
        $result = Yii::app()->m_db->createCommand($sql)->queryAll();
        if($result){
            echo "false";
        }else{
            echo "true";
        }
    }

    public function actionGoods_order_list()
    {
    	
        $this->setauth();//检查有无权限
        $count_sql = "SELECT count(*) count FROM vcos_goods_order ORDER BY is_read ASC, order_create_time";
        $count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria); 
        $sql = "SELECT * FROM vcos_goods_order ORDER BY is_read ASC, order_create_time DESC LIMIT {$criteria->offset}, 10";  
        $result = Yii::app()->m_db->createCommand($sql)->queryAll();
        foreach ($result as $key=>$row){
            $sql = "SELECT cn_name FROM vcos_member WHERE member_id = {$row['membership_id']}";
            $result[$key]['cn_name'] = Yii::app()->db->createCommand($sql)->queryRow();
        }
        $this->render('goods_order_list',array('pages'=>$pager,'result'=>$result));
    }
    
    public function actionGoods_order_edit()
    {
        $this->setauth();//检查有无权限
        $id = $_GET['id'];
        $detail = VcosGoodsOrder::model()->findByPk($id);
        if($_POST){
            $detail->order_id = $id;
            $detail->order_remark = $_POST['remark'];
            $detail->order_state = $_POST['state'];
            $detail->is_read = '1';
            if($detail->save()>0){
                Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Dutyfreegoods/goods_order_list"));
            }else{
                Helper::show_message(yii::t('vcos', '修改失败。'));
            }
        }
        $sql = "SELECT a.*, c.goods_name, b.goods_img_url 
                FROM vcos_goods_order_detail a, vcos_dutyfree_goods b, vcos_dutyfree_goods_language c
                WHERE a.goods_id=b.goods_id AND a.order_serial_num = {$detail->order_serial_num} AND b.goods_id = c.goods_id AND c.iso = '".Yii::app()->language."'";
        $sub_detail = Yii::app()->m_db->createCommand($sql)->queryAll();
        $user = VcosMember::model()->findByPk($detail->membership_id);
        $this->render('goods_order_edit',array('detail'=>$detail,'sub_detail'=>$sub_detail,'user'=>$user));
    }
    
    public function actionChangestate()
    {
        $state = VcosGoodsOrder::model()->findByPk($_POST['id']);
        $state->order_id = $_POST['id'];
        $state->order_state = $_POST['state'];
        $state->is_read = '1';
        if($state->save()>0){
            echo '1';
        }  else {
            echo '0';
        }
    }
    
    
    /**多级商品分类:多级商品分类页面**/
    public function actionMany_goods_category(){
    	$this->setauth();//检查有无权限
    	$db = Yii::app()->p_db;
    	$sql = "SELECT * FROM vcos_category";
    	$list = $db->createCommand($sql)->queryAll();
    	$data = self::sortOut($list);
    	$this->render('many_goods_category',array('data'=>$data));
    }
    
    /**无限极分类**/
	static public function sortOut($list,$pid=0,$level=0,$html='--'){
	         $tree = array();
	         foreach($list as $v){
	             if($v['parent_cid'] == $pid){
	                  $v['level'] = $level + 1;
	                  $v['html'] = str_repeat($html, $level);
	                  $tree[] = $v;
	                  $tree = array_merge($tree, self::sortOut($list,$v['category_code'],$level+1,$html));
	             }
	         }
	         return $tree;
	   }
    
    /**多级商品分类:多级分类页面数据入库**/
    public function actionMany_goods_category_data(){
    	
    	$db = Yii::app()->p_db;
    	//获取用户id及用户名
    	//$this_user_id = Yii::app()->user->id;
    	//$this_user_name = Yii::app()->user->name;
    	$success = 1;
    	$insert = 0;
    	if($_POST){
    		if($_POST['id'] == 0){
    			//不存在此数据，需添加该条记录
    			$sql = "INSERT INTO vcos_category(category_code,name,parent_cid,sort_order,status) values('{$_POST['code']}','{$_POST['name']}','{$_POST['parent_code']}','{$_POST['sort']}','{$_POST['state']}');";
    			$myself_id = $db->createCommand($sql)->execute();
    			if($myself_id){
    				$success = 1;
    				$insert = 1;
    			}  else {
    				$success = 0;
    			}
    			
    		}else{
    			//已存在的数据，修改数据
    			//先判断用户是否有修改编码code，若有修改则要判断数据表中是否已经存在该条数据
    			$sql = "UPDATE vcos_category SET category_code='{$_POST['code']}',name='{$_POST['name']}',parent_cid='{$_POST['parent_code']}',sort_order='{$_POST['sort']}',status='{$_POST['state']}'  WHERE cid =".$_POST['id'];
    			$myself_id = $db->createCommand($sql)->execute();
    			$success = 1;
    		}
    		
    	}
    	if($success){
    		if($insert == 1){
    			echo $myself_id;
    		}else{
    			echo 1;
    		}
    	}  else {
    		echo 0;
    	}
    	
    }
    
    /**多级商品分类:查询分类**/
    public function actionCategoryMaxId(){
    	$db = Yii::app()->p_db;
    	$layer = $_GET['layer'];
    	$where = '';
    	if($layer == '1'){
    		$where = 'category_code < 100';
    	}else if($layer == '2'){
    		$parent = $_GET['parent'];
    		$where = 'category_code > '.$parent.'00 AND category_code < '.$parent.'99';
    	}else if($layer == '3'){
    		$parent = $_GET['parent'];
    		$where = 'category_code > '.$parent.'000 AND category_code < '.$parent.'999';
    	}
    	$sql = "SELECT category_code FROM vcos_category WHERE ".$where." ORDER BY category_code DESC LIMIT 1";
    	$max_val = $db->createCommand($sql)->queryAll();
    	//var_dump($sql);exit;
    	if($max_val){
            echo $max_val[0]['category_code'];
        }  else {
            echo 0;
        }
    }
    
    /**多级商品分类:查询编码是否可以使用**/
    public function actionCheck_code_exites(){
    	$db = Yii::app()->p_db;
    	$is_code =isset($_GET['is_code'])?$_GET['is_code']:0;
    	$code =isset($_GET['code'])?$_GET['code']:0;
    	if($is_code == 0){
    		//新增数据
    		$sql = "SELECT count(category_code) count FROM `vcos_category` WHERE category_code='{$code}'";
    	}else{
    		$sql = "SELECT count(category_code) count FROM `vcos_category` WHERE cid!='{$is_code}' AND category_code='{$code}'";
    	}
    	$result = $db->createCommand($sql)->queryRow();
    	if($result['count']>0){
    		echo 0;
    	}  else {
    		echo 1;
    	}
    	
    }
    
    /**多级商品分类:查询编码是否存在子类**/
    public function actionCheck_is_child(){
    	$db = Yii::app()->p_db;
    	$code = isset($_GET['code'])?$_GET['code']:0;
    	if($code != 0){
    		$sql = "SELECT count(*) count FROM `vcos_category` WHERE parent_cid='{$code}'";
    		$result = $db->createCommand($sql)->queryRow();
    	}
    	if($result['count']>0 || $code == 0){
    		echo 0;
    	}  else {
    		echo 1;
    	}
    }
    
    /**多级商品分类:删除数据**/
    public function actionDel_many_goods_category(){
    	$db = Yii::app()->p_db;
    	$id = isset($_POST['id'])?$_POST['id']:0;
    	$code = isset($_POST['code'])?$_POST['code']:0;
    
    	//$sql = "DELETE FROM vcos_category WHERE cid='{$id}' OR parent_cid like '{$code}%'";
    	//将要禁用的分类下的商品也禁用
    	$str_code = '';
    	$sql = "SELECT category_code FROM `vcos_category` WHERE cid='{$id}' OR parent_cid like '{$code}%'";
    	$code_sel = Yii::app()->p_db->createCommand($sql)->queryAll();
    	foreach ($code_sel as $row){
    		$str_code .=$row['category_code'].',';
    	}
    	$str_code = trim($str_code,',');
    	$sql = "UPDATE `vcos_product` set status=0 WHERE category_code in($str_code)";
    	
    	$results = $db->createCommand($sql)->execute();
    	$sql = "UPDATE `vcos_category` set status=0 WHERE cid='$id' OR parent_cid like '{$code}%'";
    	$result = $db->createCommand($sql)->execute();
    	/*
    	$str = '';	//获取将要删除分类下属于该分类的商品id
    	$pro_ids = VcosProduct::model()->findAll("category_code like '{$code}%'");
    	foreach($pro_ids as $la1){
    		$str .= $la1['product_id'].',';
    	}
    	$str = trim($str,',');		//商品id
    	$nav_ids = VcosNavigationGroupCategory::model()->findAll("category_type=1");
    	
    	foreach($nav_ids as $row){			//1201001,1201003、1103001,1103004、1303
    		$this_id = $row['navigation_group_cid'];
    		$arr = explode(',', $row['mapping_id']);    //1201001,1201003
    		$search = '/^'.$code.'/';					//1201
    		$code_str = '';
    		$flag = 0;
    		foreach($arr as $val){
	    		if(preg_match($search,$val)) {
	    			//匹配
	    			$flag = 1;
	    		}else{
	    			//不匹配
	    			$code_str .= $val.',';
	    		}
    		}
    		$code_str = trim($code_str,',');
    		if($flag == 1){
    			//存在有替换，需修改记录,若$code_str为空说明该导航组分类需整条记录删除
    			if($code_str == ''){
    				VcosNavigationGroupCategory::model()->deleteAll("navigation_group_cid=$this_id");
    			}else{
    				$nav= VcosNavigationGroupCategory::model()->findByPk($this_id);
    				$nav->mapping_id = $code_str;
    				$nav->save();
    			}
    		}
    	}
    	//var_dump($nav_ids);
    	//删除涉及到分类的表
    	$count1 = VcosShopCategory::model()->deleteAll("category_code like '{$code}%'");
    	$count2 = VcosProduct::model()->deleteAll("category_code like '{$code}%'");
    	if($str != ''){
    	$count3 = VcosProductDetail::model()->deleteAll("product_id in($str)");
    	$count4 = VcosProductImg::model()->deleteAll("product_id in ($str)");
    	$count6 = VcosProductGraphic::model()->deleteAll("product_id in ($str)");
    	$count5 = VcosActivityProduct::model()->deleteAll("product_id in($str) AND product_type=6");
    	}*/
    	//var_dump($sql);
    	//exit;
    	//if($result){
    		echo 1;
    	//}else{
    		//echo 0;
    	//}
    	
    }
    
    
    /**多级商品分类:查询该等级分类是否已经存满**/
    public function actionCheck_goods_number(){
    	$db = Yii::app()->p_db;
    	$layer = isset($_GET['layer'])?$_GET['layer']:0;
    	$code = isset($_GET['code'])?$_GET['code']:0;
    	$layer_where = '';
    	if($layer == 1){
    		$layer_where = "parent_cid = '0'";
    	}else{
    		$layer_where = "parent_cid = '{$code}'";
    	}
    	$sql = "SELECT count(*) count FROM `vcos_category` WHERE {$layer_where}";
    	$result = $db->createCommand($sql)->queryRow();
    	//var_dump($result);exit;
    	if($result){
    		echo $result['count'];
    	}else{
    		echo false;
    	}
    }
    
}