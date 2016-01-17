<?php

class ArticleController extends Controller
{
    
    public function actionArticle_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //批量删除
        if($_POST){
            $ids=implode('\',\'', $_POST['ids']);
            $a = count($_POST['ids']);
            $result = VcosArticle::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosArticle::model()->deleteAll("article_id in('$ids')");
                $count2 = VcosArticleLanguage::model()->deleteAll("article_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Article/Article_list")); 
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosArticle::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosArticle::model()->deleteByPk($did);
                $count2 = VcosArticleLanguage::model()->deleteAll("article_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Article/Article_list"));    
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        $count_sql = "SELECT count(*) count FROM vcos_article a LEFT JOIN vcos_article_language b ON a.article_id = b.article_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.article_time DESC";
        $count = $db->createCommand($count_sql)->queryRow();
        //分页
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_article a LEFT JOIN vcos_article_language b ON a.article_id = b.article_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.article_time DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $article = $db->createCommand($sql)->queryAll();
        //渲染页面
        $this->render('article_list',array('pages'=>$pager,'auth'=>$this->auth,'article'=>$article));
    }
        
    public function actionArticle_add()
    {
        $this->setauth();//检查有无权限
        $article = new VcosArticle();
        $article_language = new VcosArticleLanguage();
        if($_POST){
        	//var_dump($_POST);exit;
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'article_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $times = date("Y/m/d H:i:s",time());
            $time = explode(" - ", $_POST['time']);
            $s_time = $time[0] . ' ' . $_POST['stime'];
            $e_time = $time[1] . ' ' . $_POST['etime'];
           
            $stime = date('Y/m/d H:i:s',strtotime($s_time));
            $etime = date('Y/m/d H:i:s',strtotime($e_time));
            $article->article_time = $times;
            $article->article_start_time = $stime;
            $article->article_end_time = $etime;
            $article->article_state = $state;
            $article->article_img_url = 'article_images/'.Yii::app()->params['month'].'/'.$photo;
            
            //匹配替换编辑器中图片路径
            $msg = $_POST['contents'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['contents_iso'] != ''){
            	$msg_iso = $_POST['contents_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //处理事务
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $article->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_article_language` (`article_id`, `iso`, `article_title`, `article_content`, `article_abstract`) VALUES ('{$article->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$describe}', '{$_POST['abstract']}'), ('{$article->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$describe_iso}', '{$_POST['abstract_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Article/Article_list"));
                }  else {//只添加系统语言时
                    $article_language->article_id = $article->primaryKey;
                    $article_language->iso = Yii::app()->params['language'];
                    $article_language->article_content = $describe;
                    $article_language->article_title =  $_POST['title'];
                    $article_language->article_abstract = $_POST['abstract'];
                    $article_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Article/Article_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('article_add',array('article'=>$article,'article_language'=>$article_language));
    }
    public function actionArticle_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $article= VcosArticle::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_article a LEFT JOIN vcos_article_language b ON a.article_id = b.article_id WHERE a.article_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $article_language = VcosArticleLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $photo='';
            if($_FILES['photo']['error']!=4){
                $result=Helper::upload_file('photo', Yii::app()->params['img_save_url'].'article_images/'.Yii::app()->params['month'], 'image', 3);
                $photo=$result['filename'];
            }
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $times = date("Y/m/d H:i:s",time());
            $time = explode(" - ", $_POST['time']);
            $s_time = $time[0] . ' ' . $_POST['stime'];
            $e_time = $time[1] . ' ' . $_POST['etime'];
            $stime = date('Y/m/d H:i:s',strtotime($s_time));
            $etime = date('Y/m/d H:i:s',strtotime($e_time));
            
            //匹配替换编辑器中图片路径
            $msg = $_POST['contents'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['contents_iso'] != ''){
            	$msg_iso = $_POST['contents_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $columns = array('article_time'=>$times,'article_start_time'=>$stime,'article_end_time'=>$etime,'article_state'=>$state);
                    if($photo){//判断有无上传图片
                        $columns['article_img_url'] = 'article_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $db->createCommand()->update('vcos_article',$columns,'article_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_article_language', array('article_title'=>$_POST['title'], 'article_abstract'=>$_POST['abstract'], 'article_content'=>$describe), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_article_language',array('article_id'=>$id,'iso'=>$_POST['language'],'article_title'=>$_POST['title_iso'],'article_abstract'=>$_POST['abstract_iso'],'article_content'=>$describe_iso));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_article_language', array('article_title'=>$_POST['title_iso'], 'article_abstract'=>$_POST['abstract_iso'], 'article_content'=>$describe_iso), 'id=:id', array(':id'=>$_POST['judge']));
                        }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Article/Article_list"));
                }  else {//只编辑系统语言
                    $article->article_id = $id;
                    $article->article_time = $times;
                    $article->article_start_time = $stime;
                    $article->article_end_time = $etime;
                    $article->article_state = $state;
                    if($photo){
                        $article->article_img_url = 'article_images/'.Yii::app()->params['month'].'/'.$photo;
                    }
                    $article->save();
                    $article_language->id = $id2['id'];
                    $article_language->article_content = $describe;
                    $article_language->article_title =  $_POST['title'];
                    $article_language->article_abstract = $_POST['abstract'];
                    $article_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Article/Article_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'));
            } 
        }
        $this->render('article_edit',array('article'=>$article,'article_language'=>$article_language));
    }
    
    public function actionGetiso()
    {
        $sql = "SELECT b.id, b.article_title, b.article_content, b.article_abstract FROM vcos_article a LEFT JOIN vcos_article_language b ON a.article_id = b.article_id WHERE a.article_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
}