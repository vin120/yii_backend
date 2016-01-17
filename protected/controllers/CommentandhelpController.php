<?php

class CommentandhelpController extends Controller
{
    public function actionCommonproblem()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //批量删除
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosCommonProblems::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosCommonProblems::model()->deleteAll("cm_id in('$ids')");
                $count2 = VcosCommonProblemsLanguage::model()->deleteAll("cm_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/commonproblem"));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosCommonProblems::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosCommonProblems::model()->deleteByPk($did);
                $count2 = VcosCommonProblemsLanguage::model()->deleteAll("cm_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/commonproblem"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //分页
        $count_sql = "SELECT count(*) count FROM vcos_common_problems a LEFT JOIN vcos_common_problems_language b ON a.cm_id = b.cm_id 
		RIGHT JOIN (SELECT c.id,d.category_name  FROM vcos_help_category c LEFT JOIN vcos_help_category_language d ON c.id=d.category_id WHERE c.state = 1 AND d.iso = '".Yii::app()->language."') e ON a.category_id = e.id
		WHERE b.iso = '".Yii::app()->language."' ORDER BY a.category_id ";
        $count = $db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_common_problems a LEFT JOIN vcos_common_problems_language b ON a.cm_id = b.cm_id 
		RIGHT JOIN (SELECT c.id,d.category_name  FROM vcos_help_category c LEFT JOIN vcos_help_category_language d ON c.id=d.category_id WHERE c.state = 1 AND d.iso = '".Yii::app()->language."') e ON a.category_id = e.id
		WHERE b.iso = '".Yii::app()->language."' ORDER BY a.category_id  LIMIT {$criteria->offset}, {$pager->pageSize}";
        $cp = $db->createCommand($sql)->queryAll();
        //渲染页面
        $this->render('common_problem',array('pages'=>$pager,'auth'=>$this->auth,'cp'=>$cp));
    }

    public function actionCommonproblem_add()
    {
        $this->setauth();//检查有无权限
        $commonProblems = new VcosCommonProblems(); 
        $commonProblems_language = new VcosCommonProblemsLanguage();
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $commonProblems->cm_state = $state;
            $commonProblems->category_id = $_POST['category'];
            //匹配替换编辑器中图片路径
            $msg = $_POST['reply'];
            $img_ueditor = Yii::app()->params['img_ueditor_php'];
            $describe = preg_replace($img_ueditor,'',$msg);
            if($_POST['reply_iso'] != ''){
            	$msg_iso = $_POST['reply_iso'];
            	$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
            }
            //事物处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $commonProblems->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_common_problems_language` (`cm_id`, `iso`, `cm_title`, `cm_reply`) VALUES ('{$commonProblems->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}', '{$describe}'), ('{$commonProblems->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}', '{$describe_iso}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/commonproblem"));
                }  else {//只添加系统语言时
                    $commonProblems_language->cm_id = $commonProblems->primaryKey;
                    $commonProblems_language->iso = Yii::app()->params['language'];
                    $commonProblems_language->cm_title = $_POST['title'];
                    $commonProblems_language->cm_reply = $describe;
                    $commonProblems_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/commonproblem"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $sql = "SELECT a.id,b.category_name FROM `vcos_help_category` a  LEFT JOIN `vcos_help_category_language` b ON a.id=b.category_id WHERE a.state = 1 AND b.iso = '".Yii::app()->language."'";
        $category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        //渲染页面
        $this->render('commonproblem_add',array('category_sel'=>$category_sel,'commonProblems'=>$commonProblems,'commonProblems_language'=>$commonProblems_language));
    }

    public function actionCommonproblem_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $cp=  VcosCommonProblems::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_common_problems a LEFT JOIN vcos_common_problems_language b ON a.cm_id = b.cm_id WHERE a.cm_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $cp_language = VcosCommonProblemsLanguage::model()->findByPk($id2['id']);
        if($_POST){
        	//匹配替换编辑器中图片路径
        	$msg = $_POST['reply'];
        	$img_ueditor = Yii::app()->params['img_ueditor_php'];
        	$describe = preg_replace($img_ueditor,'',$msg);
        	if($_POST['reply_iso'] != ''){
        		$msg_iso = $_POST['reply_iso'];
        		$describe_iso = preg_replace($img_ueditor,'',$msg_iso);
        	}
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_common_problems',array('cm_state'=>$state,'category_id'=>$_POST['category']),'cm_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_common_problems_language', array('cm_title'=>$_POST['title'], 'cm_reply'=>$describe), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_common_problems_language',array('cm_id'=>$id,'iso'=>$_POST['language'],'cm_title'=>$_POST['title_iso'],'cm_reply'=>$describe_iso));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_common_problems_language', array('cm_title'=>$_POST['title_iso'], 'cm_reply'=>$describe_iso), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/commonproblem"));
                }  else {//只编辑系统语言状态下
                    $cp->cm_id = $id;
                    $cp->cm_state = $state;
                    $cp->category_id = $_POST['category'];
                    $cp->save();
                    $cp_language->id = $id2['id'];
                    $cp_language->cm_title = $_POST['title'];
                    $cp_language->cm_reply = $describe;
                    $cp_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/commonproblem"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
            }         
        }
        $sql = "SELECT a.id,b.category_name FROM `vcos_help_category` a  LEFT JOIN `vcos_help_category_language` b ON a.id=b.category_id WHERE a.state = 1 AND b.iso = '".Yii::app()->language."'";
        $category_sel = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('commonproblem_edit',array('category_sel'=>$category_sel,'cp'=>$cp,'cp_language'=>$cp_language));
    }
    
    public function actionGetiso_cm()
    {
        $sql = "SELECT b.id, b.cm_title, b.cm_reply FROM vcos_common_problems a LEFT JOIN vcos_common_problems_language b ON a.cm_id = b.cm_id WHERE a.cm_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionCommenttype_list()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        //批量删除
        if($_POST){
            $a = count($_POST['ids']);
            $result = VcosCommentType::model()->count();
            if($a == $result){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $ids=implode('\',\'', $_POST['ids']);
            //事务处理
            $transaction=$db->beginTransaction();
            try{
                $count=VcosCommentType::model()->deleteAll("comment_type_id in('$ids')");
                $count2 = VcosCommentTypeLanguage::model()->deleteAll("comment_type_id in('$ids')");
                $transaction->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/commenttype_list"));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //单条删除
        if(isset($_GET['id'])){
            $result = VcosCommentType::model()->count();
            if($result<=1){
                die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
            }
            $did=$_GET['id'];
            //事务处理
            $transaction2=$db->beginTransaction();
            try{
                $count=VcosCommentType::model()->deleteByPk($did);
                $count2 = VcosCommentTypeLanguage::model()->deleteAll("comment_type_id in('$did')");
                $transaction2->commit();
                Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/commenttype_list"));
            }catch(Exception $e){
                $transaction2->rollBack();
                Helper::show_message(yii::t('vcos', '删除失败。'));
            }
        }
        //分页
        $criteria = new CDbCriteria();
        $count = VcosCommentType::model()->count();
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_comment_type a LEFT JOIN vcos_comment_type_language b ON a.comment_type_id = b.comment_type_id WHERE b.iso = '".Yii::app()->params['language']."' ORDER BY a.comment_type_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $ct = $db->createCommand($sql)->queryAll();
        //渲染页面
        $this->render('commenttype_list',array('pages'=>$pager,'auth'=>$this->auth,'ct'=>$ct));
    }
    
    public function actionCommenttype_add()
    {
        $this->setauth();//检查有无权限
        $ct = new VcosCommentType(); 
        $ct_language = new VcosCommentTypeLanguage();
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $ct->comment_type_state = $state;
            //事物处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $ct->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_comment_type_language` (`comment_type_id`, `iso`, `comment_type_name`) VALUES ('{$ct->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}'), ('{$ct->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/commenttype_list"));
                }  else {//只添加系统语言时
                    $ct_language->comment_type_id = $ct->primaryKey;
                    $ct_language->iso = Yii::app()->params['language'];
                    $ct_language->comment_type_name = $_POST['title'];
                    $ct_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/commenttype_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        
        //渲染页面
        $this->render('commenttype_add',array('ct'=>$ct,'ct_language'=>$ct_language));
    }
    
    public function actionCommenttype_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $ct=  VcosCommentType::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_comment_type a LEFT JOIN vcos_comment_type_language b ON a.comment_type_id = b.comment_type_id WHERE a.comment_type_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $ct_language = VcosCommentTypeLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_comment_type',array('comment_type_state'=>$state),'comment_type_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_comment_type_language', array('comment_type_name'=>$_POST['title']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_comment_type_language',array('comment_type_id'=>$id, 'iso'=>$_POST['language'], 'comment_type_name'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_comment_type_language', array('comment_type_name'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/commenttype_list"));
                }  else {//只编辑系统语言状态下
                    $ct->comment_type_id = $id;
                    $ct->comment_type_state = $state;
                    $ct->save();
                    $ct_language->id = $id2['id'];
                    $ct_language->comment_type_name = $_POST['title'];
                    $ct_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/commenttype_list"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
            }         
        }
        $this->render('commenttype_edit',array('ct'=>$ct,'ct_language'=>$ct_language));
    }
    
    public function actionGetiso_ct()
    {
        $sql = "SELECT b.id, b.comment_type_name FROM vcos_comment_type a LEFT JOIN vcos_comment_type_language b ON a.comment_type_id = b.comment_type_id WHERE a.comment_type_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionSurvey()
    {
        $this->setauth();//检查有无权限
        $db = Yii::app()->m_db;
        if($_POST){
        	$a = count($_POST['ids']);
        	$result = VcosSurvey::model()->count();
        	if($a == $result){
        		die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
        	}
        	$ids=implode('\',\'', $_POST['ids']);
        	//事务处理
        	$transaction=$db->beginTransaction();
        	try{
        		$count=VcosSurvey::model()->deleteAll("survey_id in('$ids')");
        		$count2 = VcosSurveyLanguage::model()->deleteAll("survey_id in('$ids')");
        		$count_result = VcosSurveyResult::model()->deleteAll("survey_id in('$ids')");
        		$transaction->commit();
        		Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/survey"));
        	}catch(Exception $e){
        		$transaction->rollBack();
        		Helper::show_message(yii::t('vcos', '删除失败。'));
        	}
        }
        if(isset($_GET['id'])){
        	$result = VcosSurvey::model()->count();
        	if($result<=1){
        		die(Helper::show_message(yii::t('vcos', '不能把所有记录删除！')));
        	}
        	$did=$_GET['id'];
        	//事务处理
        	$transaction2=$db->beginTransaction();
        	try{
        		$count=VcosSurvey::model()->deleteByPk($did);
        		$count2 = VcosSurveyLanguage::model()->deleteAll("survey_id in('$did')");
        		$count_result = VcosSurveyResult::model()->deleteAll("survey_id in('$did')");
        		$transaction2->commit();
        		Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/survey"));
        	}catch(Exception $e){
        		$transaction2->rollBack();
        		Helper::show_message(yii::t('vcos', '删除失败。'));
        	}
        }
        $count_sql = "SELECT count(*) count FROM vcos_survey a LEFT JOIN vcos_survey_language b ON a.survey_id = b.survey_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.survey_id DESC";
        $count = Yii::app()->m_db->createCommand($count_sql)->queryRow();
        $criteria = new CDbCriteria();
        $count = $count['count'];
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT * FROM vcos_survey a LEFT JOIN vcos_survey_language b ON a.survey_id = b.survey_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.survey_id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $survey = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('survey',array('pages'=>$pager,'auth'=>$this->auth,'survey'=>$survey));
    }
    
    public function actionSurvey_add()
    {
        $this->setauth();//检查有无权限
        $survey= new VcosSurvey();
        $survey_language = new VcosSurveyLanguage();
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $survey->survey_state = $state;
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                $survey->save();
                if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
                    $sql = "INSERT INTO `vcos_survey_language` (`survey_id`, `iso`, `survey_title`) VALUES ('{$survey->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}'), ('{$survey->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}')";
                    $db->createCommand($sql)->execute();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/survey"));
                }  else {//只添加系统语言时
                    $survey_language->survey_id = $survey->primaryKey;
                    $survey_language->iso = Yii::app()->params['language'];
                    $survey_language->survey_title = $_POST['title'];
                    $survey_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/survey"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '添加失败。'), '#');
            }
        }
        $this->render('survey_add',array('survey'=>$survey, 'survey_language'=>$survey_language));
    }
    
    public function actionSurvey_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $survey= VcosSurvey::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_survey a LEFT JOIN vcos_survey_language b ON a.survey_id = b.survey_id WHERE a.survey_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $survey_language = VcosSurveyLanguage::model()->findByPk($id2['id']);
        if($_POST){
            //事务处理
            $state = isset($_POST['state'])?$_POST['state']:'0';
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_survey', array('survey_state'=>$state),'survey_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_survey_language', array('survey_title'=>$_POST['title']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_survey_language', array('survey_id'=>$id, 'iso'=>$_POST['language'], 'survey_title'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_survey_language', array('survey_title'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/survey"));
                }  else {//只编辑系统语言状态下
                    $survey->survey_id = $id;
                    $survey->survey_state = $state;
                    $survey->save();
                    $survey_language->id = $id2['id'];
                    $survey_language->survey_title = $_POST['title'];
                    $survey_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/survey"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('vcos', '修改失败。'), '#');
            }
        }
        $this->render('survey_edit',array('survey'=>$survey,'survey_language'=>$survey_language));
    }
    
    public function actionGetiso_survey()
    {
        $sql = "SELECT b.id, b.survey_title FROM vcos_survey a LEFT JOIN vcos_survey_language b ON a.survey_id = b.survey_id WHERE a.survey_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionSurvey_grade()
    {
        $this->setauth();//检查有无权限
        $sql = "SELECT * FROM vcos_survey_choose a LEFT JOIN vcos_survey_choose_language b ON a.survey_choose_id = b.survey_choose_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.survey_choose_id ASC";
        $grade = Yii::app()->m_db->createCommand($sql)->queryAll();
        $this->render('survey_grade',array('auth'=>$this->auth,'grade'=>$grade));
    }
    
    public function actionSurvey_grade_edit()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $grade = VcosSurveyChoose::model()->findByPk($id);
        $sql = "SELECT b.id FROM vcos_survey_choose a LEFT JOIN vcos_survey_choose_language b ON a.survey_choose_id = b.survey_choose_id WHERE a.survey_choose_id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
        $id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
        $grade_language = VcosSurveyChooseLanguage::model()->findByPk($id2['id']);
        if($_POST){
            $state = isset($_POST['state'])?$_POST['state']:'0';
            //事务处理
            $db = Yii::app()->m_db;
            $transaction=$db->beginTransaction();
            try{
                if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
                    //编辑主表
                    $db->createCommand()->update('vcos_survey_choose', array('survey_choose_state'=>$state),'survey_choose_id = :id',array(':id'=>$id));
                    //编辑系统语言
                    $db->createCommand()->update('vcos_survey_choose_language', array('survey_choose_name'=>$_POST['title']), 'id=:id', array(':id'=>$id2['id']));
                    //判断外语是新增OR编辑
                    if($_POST['judge']=='add'){
                        //新增外语
                        $db->createCommand()->insert('vcos_survey_choose_language', array('survey_choose_id'=>$id, 'iso'=>$_POST['language'], 'survey_choose_name'=>$_POST['title_iso']));
                    }  else {
                        //编辑外语
                        $db->createCommand()->update('vcos_survey_choose_language', array('survey_choose_name'=>$_POST['title_iso']), 'id=:id', array(':id'=>$_POST['judge']));
                    }
                    //事务提交
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/survey_grade"));
                }  else {//只编辑系统语言状态下
                    $grade->survey_choose_id = $id;
                    $grade->survey_choose_state = $state;
                    $grade->save();
                    $grade_language->id = $id2['id'];
                    $grade_language->survey_choose_name = $_POST['title'];
                    $grade_language->save();
                    $transaction->commit();
                    Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/survey_grade"));
                }
            }catch(Exception $e){
                $transaction->rollBack();
            }
        }
        $this->render('survey_grade_edit',array('grade'=>$grade,'grade_language'=>$grade_language));
    }
    
    public function actionGetiso_grade()
    {
        $sql = "SELECT b.id, b.survey_choose_name FROM vcos_survey_choose a LEFT JOIN vcos_survey_choose_language b ON a.survey_choose_id = b.survey_choose_id WHERE a.survey_choose_id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
        $iso = Yii::app()->m_db->createCommand($sql)->queryRow();
        if($iso){
            echo json_encode($iso);
        }  else {
            echo 0;
        }
    }
    
    public function actionSurvey_statistics()
    {
        $this->setauth();//检查有无权限
        $id=$_GET['id'];
        $db= Yii::app()->m_db;
        $sql = "SELECT b.survey_title FROM vcos_survey a LEFT JOIN vcos_survey_language b ON a.survey_id = b.survey_id WHERE a.survey_id = {$id} AND b.iso = '".Yii::app()->language."'";
        $title = $db->createCommand($sql)->queryRow();
        $sql2 = "SELECT a.survey_choose_id, b.survey_choose_name FROM vcos_survey_choose a LEFT JOIN vcos_survey_choose_language b ON a.survey_choose_id = b.survey_choose_id WHERE b.iso = '".Yii::app()->language."'";
        $grade = $db->createCommand($sql2)->queryAll();
        $grade_num = VcosSurveyChoose::model()->count();
        $condition=array();
        $result = array();
        for($i=1,$j=0;$i<=$grade_num;$i++,$j++){
            $condition[] = "survey_id={$id} and survey_choose_id={$grade[$j]['survey_choose_id']}";
        }
        foreach($condition as $row){
            $result[] = VcosSurveyResult::model()->count($row);
        }
        $this->render('survey_statistics',array('grade'=>$grade,'result'=>$result,'title'=>$title));
    }
    
    public function actionUser_comment()
    {
        $this->setauth();//检查有无权限
        //分页
        $criteria = new CDbCriteria();
        $criteria->order = 'comment_time DESC';
        $count = VcosComment::model()->count();
        $pager = new CPagination($count);
        $pager->pageSize=10;
        $pager->applyLimit($criteria);
        $sql = "SELECT c.comment_type_name, a.comment_time, a.comment_content, a.membership_id, a.comment_id 
                FROM vcos_comment a, vcos_comment_type_language c
                WHERE a.comment_type_id = c.comment_type_id AND c.iso = '".Yii::app()->language."'
                ORDER BY a.comment_time DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
        $comment = Yii::app()->m_db->createCommand($sql)->queryAll();
        foreach($comment as $key=>$row){
            $sql = "SELECT cn_name FROM vcos_member WHERE member_id = {$row['membership_id']}";
            $name = Yii::app()->db->createCommand($sql)->queryRow();
            $comment[$key]['cn_name'] = $name['cn_name'];
        }
        $this->render('user_comment',array('pages'=>$pager,'comment'=>$comment));
    }
    
    public function actionUser_comment_detail()
    {
        $this->setauth();//检查有无权限
        $id = $_GET['id'];
        $sql = "SELECT c.comment_type_name, a.comment_time, a.comment_content, a.membership_id
                FROM vcos_comment a, vcos_comment_type_language c
                WHERE a.comment_type_id = c.comment_type_id AND a.comment_id = '$id' AND c.iso = '".Yii::app()->language."'";
        $comment = Yii::app()->m_db->createCommand($sql)->queryRow();
        $sql = "SELECT * FROM vcos_member WHERE member_id = {$comment['membership_id']}";
        $user = Yii::app()->db->createCommand($sql)->queryRow();
        $this->render('user_comment_detail',array('comment'=>$comment,'user'=>$user));
    }
    
    
    /**常见问题分类列表***/
    public function actionHelp_category(){
    	$this->setauth();//检查有无权限
    	$db = Yii::app()->m_db;
    	if(isset($_GET['id'])){
    		$result = VcosHelpCategory::model()->count();
    		$count_sql = "select count(*) count from `vcos_common_problems` WHERE category_id =" .$_GET['id'];
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
    			$count=VcosHelpCategory::model()->deleteByPk($did);
    			$count2 = VcosHelpCategoryLanguage::model()->deleteAll("category_id in('$did')");
    			$transaction->commit();
    			Helper::show_message(yii::t('vcos', '删除成功。'), Yii::app()->createUrl("Commentandhelp/help_category"));
    		}catch(Exception $e){
    			$transaction->rollBack();
    			Helper::show_message(yii::t('vcos', '删除失败。'));
    		}
    	}
    	$count_sql = "SELECT count(*) count FROM vcos_help_category a LEFT JOIN vcos_help_category_language b ON a.id = b.category_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.id DESC";
    	$count = $db->createCommand($count_sql)->queryRow();
    	$criteria = new CDbCriteria();
    	$count = $count['count'];
    	$pager = new CPagination($count);
    	$pager->pageSize=10;
    	$pager->applyLimit($criteria);
    	$sql = "SELECT * FROM vcos_help_category a LEFT JOIN vcos_help_category_language b ON a.id = b.category_id WHERE b.iso = '".Yii::app()->language."' ORDER BY a.id DESC LIMIT {$criteria->offset}, {$pager->pageSize}";
    	$help_category = $db->createCommand($sql)->queryAll();
    	$this->render('help_category',array('pages'=>$pager,'auth'=>$this->auth,'help_category'=>$help_category));
    } 
    
    /**常见问题分类添加**/
    public function actionHelp_category_add(){
	    	$this->setauth();//检查有无权限
	    	$help_category = new VcosHelpCategory();
	    	$help_category_language = new VcosHelpCategoryLanguage();
	    	if($_POST){
	    	
	    		$state = isset($_POST['state'])?$_POST['state']:'0';
	    		$help_category->state = $state;
	    
	    		//事务处理
	    		$db = Yii::app()->m_db;
	    		$transaction=$db->beginTransaction();
	    		try{
	    			$help_category->save();
	    			if(isset($_POST['language']) && $_POST['language'] != ''){//判读是否同时添加系统语言和外语
	    				$sql = "INSERT INTO `vcos_help_category_language` (`category_id`, `iso`, `category_name`) VALUES ('{$help_category->primaryKey}', '".Yii::app()->params['language']."', '{$_POST['title']}'), ('{$help_category->primaryKey}', '{$_POST['language']}', '{$_POST['title_iso']}')";
	    				$db->createCommand($sql)->execute();
	    				$transaction->commit();
	    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/help_category"));
	    			}  else {//只添加系统语言时
	    				$help_category_language->category_id = $help_category->primaryKey;
	    				$help_category_language->iso = Yii::app()->params['language'];
	    				$help_category_language->category_name = $_POST['title'];
	    				$help_category_language->save();
	    				$transaction->commit();
	    				Helper::show_message(yii::t('vcos', '添加成功。'), Yii::app()->createUrl("Commentandhelp/help_category"));
	    			}
	    		}catch(Exception $e){
	    			$transaction->rollBack();
	    			Helper::show_message(yii::t('vcos', '添加失败。'), '#');
	    		}
	    	}
	    	$this->render('help_category_add',array('help_category'=>$help_category,'help_category_language'=>$help_category_language));
    }
    
    /**常见问题分类编辑**/
    public function actionHelp_category_edit(){
    	$this->setauth();//检查有无权限
    	$id=$_GET['id'];
    	$help_category= VcosHelpCategory::model()->findByPk($id);
    	$sql = "SELECT b.id FROM vcos_help_category a LEFT JOIN vcos_help_category_language b ON a.id = b.category_id WHERE a.id = {$id} AND b.iso ='".Yii::app()->params['language']."'";
    	$id2 = Yii::app()->m_db->createCommand($sql)->queryRow();
    	$help_category_language = VcosHelpCategoryLanguage::model()->findByPk($id2['id']);
    	if($_POST){
    	
    		$state = isset($_POST['state'])?$_POST['state']:'0';
    		 
    		//事务处理
    		$db = Yii::app()->m_db;
    		$transaction=$db->beginTransaction();
    		try{
    			if(isset($_POST['language']) && $_POST['language'] != ''){//编辑系统语言和外语状态下
    				//编辑主表
    				$db->createCommand()->update('vcos_help_category',array('state'=>$state),'id = :id',array(':id'=>$id));
    				//编辑系统语言
    				$category_columns = array('category_name'=>$_POST['title']);
    	
    				//编辑系统语言
    				$db->createCommand()->update('vcos_help_category_language', $category_columns, 'id=:id', array(':id'=>$id2['id']));
    				//判断外语是新增OR编辑
    				if($_POST['judge']=='add'){
    					//新增外语
    					$db->createCommand()->insert('vcos_help_category_language',array('category_id'=>$id,'iso'=>$_POST['language'],'category_name'=>$_POST['title_iso']));
    				}  else {
    					//编辑外语
    					$columns = array('category_name'=>$_POST['title_iso']);
    					$db->createCommand()->update('vcos_help_category_language',$columns , 'id=:id', array(':id'=>$_POST['judge']));
    				}
    				//事务提交
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/help_category"));
    			}  else {//只编辑系统语言状态下
    				$help_category->id = $id;
    				$help_category->state = $state;
    				$help_category->save();
    				$help_category_language->id = $id2['id'];
    				$help_category_language->category_name = $_POST['title'];
    				$help_category_language->save();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', '修改成功。'), Yii::app()->createUrl("Commentandhelp/help_category"));
    			}
    		}catch(Exception $e){
    			$transaction->rollBack();
    		}
    	}
    	$this->render('help_category_edit',array('help_category'=>$help_category,'help_category_language'=>$help_category_language));
    }
    
    
    public function actionGetiso_category(){
    	$sql = "SELECT b.id, b.category_name FROM vcos_notice_to_visitors_category a LEFT JOIN vcos_notice_to_visitors_category_language b ON a.id = b.category_id WHERE a.id = '{$_POST['id']}' AND b.iso = '{$_POST['iso']}'";
    	$iso = Yii::app()->m_db->createCommand($sql)->queryRow();
    	if($iso){
    		echo json_encode($iso);
    	}  else {
    		echo 0;
    	}
    }
    
    
    
    
    
    
    
}

