<?php

class SafeController extends Controller
{
    public function actionSafeinfo()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        $sql = "SELECT safe_title, safe_content FROM vcos_safe_language WHERE safe_id = '1' AND iso = '".Yii::app()->params['language']."'";
        $detail_language = $db->createCommand($sql)->queryRow();
        if($_POST){
        	//匹配替换编辑器中图片路径
        	$msg = $_POST['describe'];
        	$img_ueditor = Yii::app()->params['img_ueditor_php'];
        	$describe = preg_replace($img_ueditor,'',$msg);
        	if($_POST['describe_iso'] != ''){
        		$msg_iso = $_POST['describe_iso'];
        		$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
        	}
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                if($_POST['describe_iso']!=''){//编辑系统语言和外语状态下
                    //编辑系统语言
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'1'));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_safe_language',array('safe_id'=>'1','iso'=>$_POST['language'],'safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/Safeinfo"));
                }  else {//只编辑系统语言状态下
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'1'));
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/Safeinfo"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        //查询页签名称
        $method_name = $this->getAction()->getId();
        //echo $method_name;die;
        $sql = "SELECT role_name FROM vcos_permission_menux WHERE method_name = '{$method_name}'";
        $role_name = $db->createCommand($sql)->queryRow();
        $this->render('index',array('detail'=>$detail_language,'method_name'=>$method_name,'role_name'=>$role_name,'sid'=>'1'));
    }
    
    public function actionSurvival()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        $sql = "SELECT safe_title, safe_content FROM vcos_safe_language WHERE safe_id = '2' AND iso = '".Yii::app()->params['language']."'";
        $detail_language = $db->createCommand($sql)->queryRow();
        if($_POST){
        	//匹配替换编辑器中图片路径
        	$msg = $_POST['describe'];
        	$img_ueditor = Yii::app()->params['img_ueditor_php'];
        	$describe = preg_replace($img_ueditor,'',$msg);
        	if($_POST['describe_iso'] != ''){
        		$msg_iso = $_POST['describe_iso'];
        		$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
        	}
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑系统语言
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'2'));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_safe_language',array('safe_id'=>'2','iso'=>$_POST['language'],'safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/survival"));
                }  else {//只编辑系统语言状态下
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'2'));
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/survival"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        //查询页签名称
        $method_name = $this->getAction()->getId();
        $sql = "SELECT role_name FROM vcos_permission_menux WHERE method_name = '{$method_name}'";
        $role_name = $db->createCommand($sql)->queryRow();
        $this->render('index',array('detail'=>$detail_language,'method_name'=>$method_name,'role_name'=>$role_name,'sid'=>'2'));
    }
    
    public function actionIntroduce()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        $sql = "SELECT safe_title, safe_content FROM vcos_safe_language WHERE safe_id = '3' AND iso = '".Yii::app()->params['language']."'";
        $detail_language = $db->createCommand($sql)->queryRow();
        if($_POST){
        	//匹配替换编辑器中图片路径
        	$msg = $_POST['describe'];
        	$img_ueditor = Yii::app()->params['img_ueditor_php'];
        	$describe = preg_replace($img_ueditor,'',$msg);
        	if($_POST['describe_iso'] != ''){
        		$msg_iso = $_POST['describe_iso'];
        		$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
        	}
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑系统语言
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'3'));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_safe_language',array('safe_id'=>'3','iso'=>$_POST['language'],'safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/introduce"));
                }  else {//只编辑系统语言状态下
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'3'));
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/introduce"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        //查询页签名称
        $method_name = $this->getAction()->getId();
        $sql = "SELECT role_name FROM vcos_permission_menux WHERE method_name = '{$method_name}'";
        $role_name = $db->createCommand($sql)->queryRow();
        $this->render('index',array('detail'=>$detail_language,'method_name'=>$method_name,'role_name'=>$role_name,'sid'=>'3'));
    }
    
    public function actionGuide()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        $sql = "SELECT safe_title, safe_content FROM vcos_safe_language WHERE safe_id = '4' AND iso = '".Yii::app()->params['language']."'";
        $detail_language = $db->createCommand($sql)->queryRow();
        if($_POST){
        	//匹配替换编辑器中图片路径
        	$msg = $_POST['describe'];
        	$img_ueditor = Yii::app()->params['img_ueditor_php'];
        	$describe = preg_replace($img_ueditor,'',$msg);
        	if($_POST['describe_iso'] != ''){
        		$msg_iso = $_POST['describe_iso'];
        		$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
        	}
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑系统语言
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'4'));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_safe_language',array('safe_id'=>'4','iso'=>$_POST['language'],'safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe_iso,'safe_title'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/guide"));
                }  else {//只编辑系统语言状态下
                    $db->createCommand()->update('vcos_safe_language', array('safe_content'=>$describe,'safe_title'=>$_POST['title']), 'id=:id', array(':id'=>'4'));
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("safe/guide"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        //查询页签名称
        $method_name = $this->getAction()->getId();
        $sql = "SELECT role_name FROM vcos_permission_menux WHERE method_name = '{$method_name}'";
        $role_name = $db->createCommand($sql)->queryRow();
        $this->render('index',array('detail'=>$detail_language,'method_name'=>$method_name,'role_name'=>$role_name,'sid'=>'4'));
    }
    
    public function actionGetiso()
    {
        $db = Yii::app()->m_db;
        //$sql = "SELECT b.id, b.safe_title, b.safe_content FROM vcos_safe a LEFT JOIN vcos_safe_language b ON a.safe_id = b.safe_id WHERE a.safe_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $sql = "SELECT id, safe_title, safe_content FROM vcos_safe_language WHERE safe_id = '{$_POST['id']}' AND iso = '{$_POST['iso']}'";
        $iso =  $db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        } 
    }
    
    /**游客须知列表**/
    public function actionNotice_to_visitors(){
    	$this->setauth();//检查有无权限
    	$db = Yii::app()->m_db;
    	
    	//批量删除
    	if($_POST){
    		$a = count($_POST['ids']);
    		$result = VcosNoticeToVisitors::model()->count();
    		if($a == $result){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		$ids=implode('\',\'', $_POST['ids']);
    		//事务处理
    		$transaction=$db->beginTransaction();
    		try{
    			$count=VcosNoticeToVisitors::model()->deleteAll("id in('$ids')");
    			$count2 = VcosNoticeToVisitorsLanguage::model()->deleteAll("n_id in('$ids')");
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Safe/notice_to_visitors"));
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	//单条删除
    	if(isset($_GET['id'])){
    		$result = VcosNoticeToVisitors::model()->count();
    		if($result<=1){
    			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
    		}
    		$did=$_GET['id'];
    		//事务处理
    		$transaction2=$db->beginTransaction();
    		try{
    			$count=VcosNoticeToVisitors::model()->deleteByPk($did);
    			$count2 = VcosNoticeToVisitorsLanguage::model()->deleteAll("n_id in('$did')");
    			$transaction2->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Safe/notice_to_visitors"));
    		}catch(Exception $e){
    			$transaction2->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	$count_sql = "SELECT count(*) count FROM `vcos_notice_to_visitors` a LEFT JOIN `vcos_notice_to_visitors_language` b ON a.id = b.n_id 
		RIGHT JOIN (SELECT c.id,d.category_name  FROM vcos_notice_to_visitors_category c LEFT JOIN vcos_notice_to_visitors_category_language d ON c.id=d.category_id WHERE c.state = 1 AND d.iso = '".Yii::app()->language."') e ON a.category_id = e.id
		WHERE b.iso = '".Yii::app()->language."' ORDER BY a.category_id";
    	$count = $db->createCommand($count_sql)->queryRow();
    	//分页
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	//$count = count($restaurant);
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$sql = "SELECT * FROM `vcos_notice_to_visitors` a LEFT JOIN `vcos_notice_to_visitors_language` b ON a.id = b.n_id 
		RIGHT JOIN (SELECT c.id,d.category_name  FROM vcos_notice_to_visitors_category c LEFT JOIN vcos_notice_to_visitors_category_language d ON c.id=d.category_id WHERE c.state = 1 AND d.iso = '".Yii::app()->language."') e ON a.category_id = e.id
		WHERE b.iso = '".Yii::app()->language."' ORDER BY a.category_id LIMIT {$criteria->offset}, {$pager->pageSize}";
    	$notice_to_visitors = $db->createCommand($sql)->queryAll();
    	$this->render('notice_to_visitors',array('pages'=>$pager,'auth'=>$this->auth,'notice_to_visitors'=>$notice_to_visitors));
    }
    
    /**添加游客须知**/
    public function actionNotice_to_visitors_add(){
    	$this->setauth();//检查有无权限
    	$notice_to_visitors = new VcosNoticeToVisitors();
    	$notice_to_visitors_language = new VcosNoticeToVisitorsLanguage();
    	if($_POST){
    		$photo='';
    		if($_FILES['photo']['error']!=4){
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'safe_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		$photo_iso = '';
    		if(isset($_POST['language']) && $_POST['language'] != ''){
    			if($_FILES['photo_iso']['error']!=4){
    				$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'safe_images/'.Yii::app()->params['month'], 'image', 3);
    				$photo_iso=$result['filename'];
    			}
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		$notice_to_visitors->state = $state;
    		$notice_to_visitors->sort_order = $_POST['sort'];
    		$notice_to_visitors->category_id = $_POST['category'];
    		 
    		$photo_url = 'safe_images/'.Yii::app()->params['month'].'/'.$photo;
    		$photo_iso_url = 'safe_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    		
    		//匹配替换编辑器中图片路径
    		$msg = $_POST['describe'];
    		$img_ueditor = Yii::app()->params['img_ueditor_php'];
    		$describe = preg_replace($img_ueditor,'',$msg);
    		if($_POST['describe_iso'] != ''){
    			$msg_iso = $_POST['describe_iso'];
    			$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
    		}
    		 
    		//处理事务
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			$notice_to_visitors->save();
    			if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
    				$sql = "INSERT INTO `vcos_notice_to_visitors_language` (`n_id`,`img_url`,`content`, `iso`) VALUES ('{$notice_to_visitors->primaryKey}','{$photo_url}','{$describe}','".Yii::app()->params['language']."'), ('{$notice_to_visitors->primaryKey}','{$photo_iso_url}','{$describe_iso}', '{$_POST['language']}')";
    				$db->createCommand($sql)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Safe/notice_to_visitors"));
    			}  else {//只添加系统语言时
    				$notice_to_visitors_language->n_id = $notice_to_visitors->primaryKey;
    				$notice_to_visitors_language->img_url = $photo_url;
    				$notice_to_visitors_language->content = $describe;
    				$notice_to_visitors_language->iso = Yii::app()->params['language'];
    				$notice_to_visitors_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Safe/notice_to_visitors"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
    		}
    	}
    	$sql = "SELECT a.id,b.category_name FROM `vcos_notice_to_visitors_category` a  LEFT JOIN `vcos_notice_to_visitors_category_language` b ON a.id=b.category_id WHERE a.state = 1 AND b.iso = '".Yii::app()->language."'";
    	$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('notice_to_visitors_add',array('category_sel'=>$category_sel,'notice_to_visitors'=>$notice_to_visitors,'notice_to_visitors_language'=>$notice_to_visitors_language));
    }
    
    /**编辑游客须知**/
    public function actionNotice_to_visitors_edit(){
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$notice_to_visitors= VcosNoticeToVisitors::model()->findByPk($id);
    	$sql = "SELECT b.id FROM vcos_notice_to_visitors a LEFT JOIN vcos_notice_to_visitors_language b ON a.id = b.n_id WHERE a.id = {$id} AND b.iso ='".Yii::app()->language."'";
    	$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
    	$notice_to_visitors_language = VcosNoticeToVisitorsLanguage::model()->findByPk($id2['id']);
    	if($_POST){
    		$photo='';
    		$photo_iso='';
    		if($_FILES['photo']['error']!=4){
    			$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'safe_images/'.Yii::app()->params['month'], 'image', 3);
    			$photo=$result['filename'];
    		}
    		if(isset($_POST['language']) && $_POST['language'] != ''){
    			if($_FILES['photo_iso']['error']!=4){
    				$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'safe_images/'.Yii::app()->params['month'], 'image', 3);
    				$photo_iso=$result['filename'];
    			}
    		}
    		$state = isset($_POST['state'])?$_POST['state']:'0';
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
    				$columns = array('state'=>$state,'sort_order'=>$_POST['sort'],'category_id'=>$_POST['category']);
    				$db->createCommand()->update('vcos_notice_to_visitors',$columns,'id = :id',array(':id'=>$id));
    				 
    				if($photo_iso){//判断有无上传图片
    					$photo_iso_url = 'safe_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    				}
    				$columns_iso =  array('content'=>$describe);
    				if($photo != ''){//判断有无上传图片
    					$columns_iso['img_url'] = 'safe_images/'.Yii::app()->params['month'].'/'.$photo;
    				}
    				//编辑系统语言
    				$db->createCommand()->update('vcos_notice_to_visitors_language', $columns_iso, 'id=:id', array(':id'=>$id2['id']));
    				//判断外语是新增OR编辑
    				if($_POST['judge']=='add'){
    					//新增外语
    					$db->createCommand()->insert('vcos_notice_to_visitors_language',array('n_id'=>$id,'iso'=>$_POST['language'],'img_url'=>$photo_iso_url,'content'=>$describe_iso));
    				}  else {
    					//编辑外语
    					$columns_iso_language =  array('content'=>$describe_iso);
    					if($photo_iso != ''){//判断有无上传图片
    						$columns_iso_language['img_url'] = 'safe_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    					}
    					$db->createCommand()->update('vcos_notice_to_visitors_language', $columns_iso_language, 'id=:id', array(':id'=>$_POST['judge']));
    				}
    				//事务提交
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Safe/notice_to_visitors"));
    			}  else {//只编辑系统语言状态下
    				$notice_to_visitors->state = $state;
    				$notice_to_visitors->sort_order = $_POST['sort'];
    				$notice_to_visitors->category_id = $_POST['category'];
    				$notice_to_visitors->save();
    				$notice_to_visitors_language->id = $id2['id'];
    				if($photo != ''){//判断有无上传图片
    					$notice_to_visitors_language->img_url = 'safe_images/'.Yii::app()->params['month'].'/'.$photo;
    				}
    				//$cruise_deck_point_language->img_url = 'cruiseinfo_images/'.Yii::app()->params['month'].'/'.$photo_iso;
    				$notice_to_visitors_language->content = $describe;
    				$notice_to_visitors_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Safe/notice_to_visitors"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '修改失败。'), '#');
    		}
    	}
    	$sql = "SELECT a.id,b.category_name FROM `vcos_notice_to_visitors_category` a  LEFT JOIN `vcos_notice_to_visitors_category_language` b ON a.id=b.category_id WHERE a.state = 1 AND b.iso = '".Yii::app()->language."'";
    	$category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
    	$this->render('notice_to_visitors_edit',array('category_sel'=>$category_sel,'notice_to_visitors'=>$notice_to_visitors,'notice_to_visitors_language'=>$notice_to_visitors_language));
    }
    
    public function actionGetiso_notice_to_visitors(){
    	$sql = "SELECT b.id, b.img_url,b.content FROM vcos_notice_to_visitors a LEFT JOIN vcos_notice_to_visitors_language b ON a.id = b.n_id WHERE a.id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
    	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($iso){
    		echo json_encode($iso);
    	}  else {
    		echo 0;
    	}
    }
    
   /**游客须知分类列表**/
   public function actionNotice_to_visitors_category(){
	   	$this->setauth();//检查有无权限
	   	$db = Yii::app()->m_db;
	   	if(isset($_GET['id'])){
	   		$result = VcosNoticeToVisitorsCategory::model()->count();
	   		$count_sql = "select count(*) count from `vcos_notice_to_visitors` WHERE category_id =" .$_GET['id'];
	   		$count_category = Yii::app()->m_db->createCommand($count_sql)->queryRow();
	   		if($result<=1){
	   			die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
	   		}else if($count_category['count'] > 0){
            	die(Helper::show_message(yii::t('vcos', '存在子类不能删除！')));
            }
	   		$did=$_GET['id'];
	   		//事务处理
	   		$transaction=$db->beginTransaction();
	   		try{
	   			$count=VcosNoticeToVisitorsCategory::model()->deleteByPk($did);
	   			$count2 = VcosNoticeToVisitorsCategoryLanguage::model()->deleteAll("category_id in('$did')");
	   			$transaction->commit();
	   			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Safe/notice_to_visitors_category"));
	   		}catch(Exception $e){
	   			$transaction->rollBack();
	   			Helper::show_message(yii::t('vcos', '删除失败。'));
	   		}
	   	}
	   	$count_sql = "SELECT count(*) count FROM vcos_notice_to_visitors_category a LEFT JOIN vcos_notice_to_visitors_category_language b ON a.id = b.category_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.id DESC";
	   	$count = $db->createCommand($count_sql)->queryRow();
	   	$criteria = new CDbCriteria();
	   	$count = $count['count'];
	   	$pager = new CPagination($count);
	   	$pager->pageSize=10;
	   	$pager->applyLimit($criteria);
	   	$sql = "SELECT * FROM vcos_notice_to_visitors_category a LEFT JOIN vcos_notice_to_visitors_category_language b ON a.id = b.category_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
	   	$notice_to_visitors_category = $db->createCommand($sql)->queryAll();
	   	$this->render('notice_to_visitors_category',array('pages'=>$pager,'auth'=>$this->auth,'notice_to_visitors_category'=>$notice_to_visitors_category));
   }
   
   /**游客须知分类添加**/
   public function actionNotice_to_visitors_category_add(){
	   	$this->setauth();//检查有无权限
	   	$notice_to_visitors_category = new VcosNoticeToVisitorsCategory();
	   	$notice_to_visitors_category_language = new VcosNoticeToVisitorsCategoryLanguage();
	   	if($_POST){
	   		
	   		$state = isset($_POST['state'])?$_POST['state']:'0';
	   		$notice_to_visitors_category->state = $state;
	   	
	   	
	   		//事务处理
	   		$db = Yii::app()->m_db;
	   		$transaction=$db->beginTransaction();
	   		try{
	   			$notice_to_visitors_category->save();
	   			if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
	   				$sql = "INSERT INTO `vcos_notice_to_visitors_category_language` (`category_id`, `iso`, `category_name`) VALUES ('{$notice_to_visitors_category->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}'), ('{$notice_to_visitors_category->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}')";
	   				$db->createCommand($sql)->execute();
	   				$transaction->commit();
	   				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Safe/notice_to_visitors_category"));
	   			}  else {//只添加系统语言时
	   				$notice_to_visitors_category_language->category_id = $notice_to_visitors_category->primaryKey;
	   				$notice_to_visitors_category_language->iso = Yii::app()->params['language'];
	   				$notice_to_visitors_category_language->category_name = $_POST['title'];
	   				$notice_to_visitors_category_language->save();
	   				$transaction->commit();
	   				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Safe/notice_to_visitors_category"));
	   			}
	   		}catch(Exception $e){
	   			$transaction->rollBack();
	   			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
	   		}
	   	}
	   	$this->render('notice_to_visitors_category_add',array('notice_to_visitors_category'=>$notice_to_visitors_category,'notice_to_visitors_category_language'=>$notice_to_visitors_category_language));
   }
   
   /**游客须知分类编辑***/
   public function actionNotice_to_visitors_category_edit(){
	   	$this->setauth();//检查有无权限
	   	$id=$_GET['id'];
	   	$notice_to_visitors_category= VcosNoticeToVisitorsCategory::model()->findByPk($id);
	   	$sql = "SELECT b.id FROM vcos_notice_to_visitors_category a LEFT JOIN vcos_notice_to_visitors_category_language b ON a.id = b.category_id WHERE a.id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
	   	$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
	   	$notice_to_visitors_category_language = VcosNoticeToVisitorsCategoryLanguage::model()->findByPk($id2['id']);
	   	if($_POST){
	   		
	   		$state = isset($_POST['state'])?$_POST['state']:'0';
	   	
	   		//事务处理
	   		$db = Yii::app()->m_db;
	   		$transaction=$db->beginTransaction();
	   		try{
	   			if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
	   				//编辑主表
	   				$db->createCommand()->update('vcos_notice_to_visitors_category',array('state'=>$state),'id = :id',array(':id'=>$id));
	   				//编辑系统语言
	   				$category_columns = array('category_name'=>$_POST['title']);
	   				
	   				//编辑系统语言
	   				$db->createCommand()->update('vcos_notice_to_visitors_category_language', $category_columns, 'id=:id', array(':id'=>$id2['id']));
	   				//判断外语是新增OR编辑
	   				if($_POST['judge']=='add'){
	   					//新增外语
	   					$db->createCommand()->insert('vcos_notice_to_visitors_category_language',array('category_id'=>$id,'iso'=>$_POST['language'],'category_name'=>$_POST['title_iso']));
	   				}  else {
	   					//编辑外语
	   					$columns = array('category_name'=>$_POST['title_iso']);
	   					$db->createCommand()->update('vcos_notice_to_visitors_category_language',$columns , 'id=:id', array(':id'=>$_POST['judge']));
	   				}
	   				//事务提交
	   				$transaction->commit();
	   				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Safe/notice_to_visitors_category"));
	   			}  else {//只编辑系统语言状态下
	   				$notice_to_visitors_category->id = $id;
	   				$notice_to_visitors_category->state = $state;
	   				$notice_to_visitors_category->save();
	   				$notice_to_visitors_category_language->id = $id2['id'];
	   				$notice_to_visitors_category_language->category_name = $_POST['title'];
	   				$notice_to_visitors_category_language->save();
	   				$transaction->commit();
	   				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Safe/notice_to_visitors_category"));
	   			}
	   		}catch(Exception $e){
	   			$transaction->rollBack();
	   		}
	   	}
	   	$this->render('notice_to_visitors_category_edit',array('notice_to_visitors_category'=>$notice_to_visitors_category,'notice_to_visitors_category_language'=>$notice_to_visitors_category_language));
   }
   
   public function actionGetiso_category(){
	   	$sql = "SELECT b.id, b.category_name FROM vcos_help_category a LEFT JOIN vcos_help_category_language b ON a.id = b.category_id WHERE a.id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
	   	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
	   	if($iso){
	   		echo json_encode($iso);
	   	}  else {
	   		echo 0;
	   	}
   }
	    
    
 
    
    
}