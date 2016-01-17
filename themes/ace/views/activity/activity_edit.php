<?php
    $this->pageTitle = Yii::t('vcos','编辑活动');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'activity_add';
?>
<link rel="stylesheet"  href="<?php echo $theme_url; ?>/assets/css/daterangepicker.css" />  
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/bootstrap-timepicker.css" /> 
<?php 
    //navbar 挂件
    $disable = 1;
    $this->widget('navbarWidget',array('disable'=>$disable));
?>
<div class="main-container" id="main-container">
    <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
            <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
            </a>
            <?php
            //菜单挂件
             $this->widget('menuWidget', array('menu_type'=>$menu_type));
            ?>
            <div class="main-content"> 
                <?php
                    //面包屑挂件
                    $this->widget('breadcrumbWidget');
                ?>
                <div class="page-content">
                    <div class="page-header">
                        <h1>
                            <?php echo yii::t('vcos', '活动管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑活动')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <?php  
                            //使用小物件生成form元素  
                            $form=$this->beginWidget('CActiveForm',array(
                                'htmlOptions'=>array(
                                    'class'=>'form-horizontal',
                                    'role'=>'form',
                                    'id'=>'edit',
                                    'enctype'=>'multipart/form-data',
                                ),
                            ));  
                            ?> 
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动名称')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '活动名称')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="42" value="<?php echo $activity['activity_name']?>" />
                                        <?php echo $form->error($activity,'activity_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动描述')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<textarea id="desc" style=" overflow:auto; width: 66.6666%;height: 60px;resize: none;" placeholder="<?php echo yii::t('vcos', '描述')?>" name="desc" maxlength=80><?php echo $activity['activity_desc']?></textarea>
                                        <?php echo $form->error($activity,'activity_desc'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '有效日期')?>：</label>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </span>
                                                <input class="form-control" type="text" name="time" id="time" value="<?php echo substr($activity['start_time'],0,10).' - '.substr($activity['end_time'],0,10)?>" data-rel="tooltip" title="开始时间为当天00:00:00,结束时间为当天23:59:59" data-placement="bottom"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo $form->error($activity,'sale_start_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '开始时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="stime" name="stime" type="text" class="form-control col-xs-8 col-sm-8 col-md-8" maxlength="100" placeholder="<?php echo yii::t('vcos', '开始时间')?>" value="<?php echo substr($activity['start_time'],11,-1)?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($activity,'sale_start_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '结束时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="etime" name="etime" type="text" class="form-control col-xs-6 col-sm-6 col-md-6" maxlength="100" placeholder="<?php echo yii::t('vcos', '结束时间')?>" value="<?php echo substr($activity['end_time'],11,-1)?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($activity,'sale_end_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$activity['activity_img'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($activity['status']==1){echo "checked='checked'";}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '是否显示分类')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($activity['is_show_category']==1){echo "checked='checked'";}?> class="ace ace-switch ace-switch-5" name="show" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '是否显示活动头')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($activity['is_show_head']==1){echo "checked='checked'";}?> class="ace ace-switch ace-switch-5" name="show_head" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <input type="hidden" value="" id="judge" name="judge">
                                <input type="submit" value="提交" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
                            <?php  
                                $this->endWidget();  
                            ?>
                        </div><!-- /.col-xs-12 -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div><!-- /.main-content -->
             <?php
                    //设置容器配置挂件
                    $this->widget('settingsContainerWidget');
            ?>
    </div><!-- /.main-container-inner -->
        
        <!-- scrool up widget start-->
        <?php
            $this->widget('scrollUpWidget');
        ?>
        <!-- scrool up widget end-->
        
</div><!-- /.main-container -->
<!-- basic scripts -->

<!--[if !IE]> -->

<script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/uncompressed/additional-methods.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/moment.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
jQuery(function($){

    $("#edit").validate({
        rules: {
            name:{required:true,stringCheckAll:true}
        }
    });

    /**查看该港口名是否已经存在**/
    $('form').submit(function(){
    	var a=1;
    	var date = $("#time").val();
    	if(date == ''){
        	alert("<?php echo Yii::t('vcos','请输入有效日期');?>");
        	a = 0;
        }
        date = date.split(' - ');
        if(date[0] == date[1]){
           //日期为同一天需判断结束时间不能大于开始时间
            var stime = $("#stime").val();
            var etime = $("#etime").val();
            if(stime > etime){
                alert("<?php echo Yii::t('vcos','请输入正确的结束时间');?>");
                a = 0;
            }
        }
       if(a == 0){
           return false;
       }
    });
    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#time').daterangepicker({
        dateFormat:'yy-mm-dd'
    });

    $('#stime').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
	}).next().on(ace.click_event, function(){
	        $(this).prev().focus();
	});
	$('#etime').timepicker({
	        minuteStep: 1,
	        showSeconds: true,
	        showMeridian: false
	}).next().on(ace.click_event, function(){
	        $(this).prev().focus();
	});
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
    ?>
    
});
</script>
