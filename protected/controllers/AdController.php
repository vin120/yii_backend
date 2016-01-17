<?php
class AdController extends Controller
{
    public function actionAd_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //多条删除
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $a = count($_POST['ids']);
            $result = VcosAd::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosAd::model()->deleteAll("ad_id in('$ids')");
                $count2 = VcosAdLanguage::model()->deleteAll("ad_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Ad/ad_list"));   
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosAd::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosAd::model()->deleteByPk($did);
                $count2 = VcosAdLanguage::model()->deleteAll("ad_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Ad/ad_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $criteria = new CDbCriteria();
        $count = VcosAd::model()->count();
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT a.*, b.name,b.img_url,b.link_url FROM vcos_ad a LEFT JOIN vcos_ad_language b ON b.ad_id = a.ad_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.ad_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $ad = $db->createCommand($sql)->queryAll();
        //渲染页面
        $this->render('ad_list',array('pages'=>$pager,'auth'=>$this->auth,'ad'=>$ad));
    }
    public function actionAd_add()
    {
        $this->setauth();//检查有无权限
        $ad = new VcosAd();
        $ad_language = new VcosAdLanguage();
        if($_POST){
        	/*
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'myad_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }*/
        	$photo='';
        	if($_FILES['photo']['error']!=4){
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'myad_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	$photo_iso = '';
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		if($_FILES['photo_iso']['error']!=4){
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'myad_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
        	$photo_url = 'myad_images/'.Yii::app()->params['month'].'/'.$photo;
        	$photo_iso_url = 'myad_images/'.Yii::app()->params['month'].'/'.$photo_iso;
        	
        	if($_POST['type'] == 0){
        		//模块
        		$link_url = "article?article_id=".$_POST['link_model'];
        		if(isset($_POST['language']) && $_POST['language'] != ''){
        			$link_url_iso = "article?article_id=".$_POST['link_model_iso'];
        		}
        		
        	}else if($_POST['type'] == 1){
        		$link_url = $_POST['link_url'];
        		if(isset($_POST['language']) && $_POST['language'] != ''){
        			$link_url_iso = $_POST['link_url_iso'];
        		}
        	}
        	
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $ad->ad_state = $state;
            $ad->ad_position = $_POST['position'];
            $ad->link_type = $_POST['type'];
            //$ad->ad_img_url = 'myad_images/'.Yii::app()->params['month'].'/'.$photo;
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $ad->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_ad_language` (`ad_id`, `iso`, `name`,`img_url`,`link_url`) VALUES ('{$ad->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}','{$photo_url}','{$link_url}'), ('{$ad->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}','{$photo_iso_url}','{$link_url_iso}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Ad/ad_list"));
                }  else {//只添加系统语言时
                    $ad_language->ad_id = $ad->primaryKey;
                    $ad_language->iso = Yii::app()->params['language'];
                    $ad_language->name = $_POST['title'];
                    $ad_language->img_url = $photo_url;
                    $ad_language->link_url = $link_url;
                    $ad_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Ad/ad_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT a.article_id,b.article_title  FROM `vcos_article` a LEFT JOIN `vcos_article_language` b ON a.article_id = b.article_id WHERE b.iso = 'zh_cn' AND a.article_state = '1'";
        $title_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        $sql = "SELECT a.article_id,b.article_title  FROM `vcos_article` a LEFT JOIN `vcos_article_language` b ON a.article_id = b.article_id WHERE b.iso = 'en' AND a.article_state = '1'";
        $title_en_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        $position = VcosAdPosition::model()->findAll();
        $this->render('ad_add',array('title_en_sel'=>$title_en_sel,'title_sel'=>$title_sel,'position'=>$position,'ad'=>$ad,'ad_language'=>$ad_language));
    }
    
    public function actionAd_edit()
    {
        $this->setauth();//检查有无权限
        $id = $_GET['id'];
        $ad = VcosAd::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_ad a LEFT JOIN vcos_ad_language b ON a.ad_id = b.ad_id WHERE a.ad_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $ad_language = VcosAdLanguage::model()->findByPk($id2['id']);
        if($_POST){
        	/*
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'myad_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }*/
        	$photo='';
        	$photo_iso='';
        	if($_FILES['photo']['error']!=4){
        		$result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'myad_images/'.Yii::app()->params['month'], 'image', 3);
        		$photo=$result['filename'];
        	}
        	if(isset($_POST['language']) && $_POST['language'] != ''){
        		if($_FILES['photo_iso']['error']!=4){
        			$result=Helper::upload_file('photo_iso', Yii::app()->params['img_save_url'].'myad_images/'.Yii::app()->params['month'], 'image', 3);
        			$photo_iso=$result['filename'];
        		}
        	}
        	/*
        	$photo_iso_url = '';
        	if($photo_iso){//判断有无上传图片
        		$photo_iso_url = 'myad_images/'.Yii::app()->params['month'].'/'.$photo_iso;
        	}*/
        	$photo_url = '';
        	if($photo){//判断有无上传图片
        		$photo_url = 'myad_images/'.Yii::app()->params['month'].'/'.$photo;
        	}
        	if($_POST['type'] == 0){
        		//模块
        		$link_url = "article?article_id=".$_POST['link_model'];
        		if(isset($_POST['language']) && $_POST['language'] != ''){
        			$link_url_iso = "article?article_id=".$_POST['link_model_iso'];
        		}
        	
        	}else if($_POST['type'] == 1){
        		$link_url = $_POST['link_url'];
        		if(isset($_POST['language']) && $_POST['language'] != ''){
        			$link_url_iso = $_POST['link_url_iso'];
        		}
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('ad_state'=>$state,'ad_position'=>$_POST['position'],'link_type'=>$_POST['type']);
                   
                    $db->createCommand()->update('vcos_ad',$columns,'ad_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $l_colums = array('name'=>$_POST['title'],'link_url'=>$link_url);
                    if($photo){//判断有无上传图片
                    	$l_colums['img_url'] = 'myad_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_ad_language',$l_colums, 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $columns = array('ad_id'=>$id,'iso'=>$_POST['language'],'name'=>$_POST['title_iso'],'link_url'=>$link_url_iso);
                        if($photo_iso){//判断有无上传图片
                        	$columns['img_url'] = 'myad_images/'.Yii::app()->params['month'].'/'.$photo_iso;
                        }
                        $db->createCommand()->insert('vcos_ad_language',$columns);
                    }  else {
                        //编辑外语
                        $columns = array('name'=>$_POST['title_iso'],'link_url'=>$link_url_iso);
                        if($photo_iso){//判断有无上传图片
                        	$columns['img_url'] = 'myad_images/'.Yii::app()->params['month'].'/'.$photo_iso;
                        }
                        $db->createCommand()->update('vcos_ad_language',$columns , 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Ad/ad_list"));
                }  else {//只编辑系统语言状态下
                    $ad->ad_id = $id;
                    $ad->ad_state = $state;
                    $ad->ad_position = $_POST['position'];
                    $ad->link_type = $_POST['type'];
                    $ad->save();
                    $ad_language->id = $id2['id'];
                    $ad_language->name = $_POST['title'];
                    if($photo){//判断有无上传图片
                    	$ad_language->img_url = 'myad_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    //$ad_language->img_url = $photo_url;
                    $ad_language->link_url = $link_url;
                    $ad_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Ad/ad_list"));      
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $sql = "SELECT a.article_id,b.article_title  FROM `vcos_article` a LEFT JOIN `vcos_article_language` b ON a.article_id = b.article_id WHERE b.iso = 'zh_cn' AND a.article_state = '1'";
        $title_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        $sql = "SELECT a.article_id,b.article_title  FROM `vcos_article` a LEFT JOIN `vcos_article_language` b ON a.article_id = b.article_id WHERE b.iso = 'en' AND a.article_state = '1'";
        $title_en_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        $position = VcosAdPosition::model()->findAll();
        $this->render('ad_edit',array('title_sel'=>$title_sel,'title_en_sel'=>$title_en_sel,'ad'=>$ad,'position'=>$position,'ad_language'=>$ad_language));
    }
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.name,b.img_url,b.link_url FROM vcos_ad a LEFT JOIN vcos_ad_language b ON a.ad_id = b.ad_id WHERE a.ad_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
}