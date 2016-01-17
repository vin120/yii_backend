<?php
    $this->pageTitle = Yii::t('vcos','添加旅行日程');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'travelschedule_add';
?>
<?php 
    //navbar 挂件
    $disable = 1;
    $this->widget('navbarWidget',array('disable'=>$disable));
?>      
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/bootstrap-timepicker.css" />       
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
                            <?php echo yii::t('vcos', '旅行日程管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '添加旅行日程')?>
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
                                    'id'=>'add',
                                    'enctype'=>'multipart/form-data',
                                ),
                            ));  
                            ?> 
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '添加外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check='no' class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles" placeholder="<?php echo yii::t('vcos', '标题')?>" class="col-xs-10 col-sm-8 col-md-8" name="title" maxlength="80" />
                                        <?php echo $form->error($schedule_language,'ts_title'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_title">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题').yii::t('vcos','').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles2" placeholder="<?php echo yii::t('vcos', '标题').yii::t('vcos','').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="title_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '描述')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<textarea id="desc" style=" overflow:auto; width: 66.6666%;height: 60px;resize: none;" placeholder="<?php echo yii::t('vcos', '描述')?>" name="desc" maxlength=80></textarea>
                                        <?php echo $form->error($schedule_language,'ts_desc'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_desc">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    <textarea id="desc2" style=" overflow:auto; width: 66.6666%;height: 60px;resize: none;" placeholder="<?php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>" name="desc_iso" maxlength=80></textarea>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动地点')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="address" class="col-xs-10 col-sm-8 col-md-8" name="address" maxlength="80" placeholder="<?php echo yii::t('vcos', '活动地点')?>" />
                                        <?php echo $form->error($schedule_language,'ts_address'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_address">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动地点').yii::t('vcos','').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="address2" class="col-xs-10 col-sm-8 col-md-8" name="address_iso" maxlength="80" placeholder="<?php echo yii::t('vcos', '活动地点').yii::t('vcos','').yii::t('vcos','(外语)')?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动日期')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="time" class="col-xs-10 col-sm-8 col-md-8 date-picker" name="time" maxlength="100" placeholder="<?php echo yii::t('vcos', '活动日期')?>" />
                                        <?php echo $form->error($schedule,'ts_time'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动开始时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="stime" name="stime" type="text" class="form-control col-xs-8 col-sm-8 col-md-8" maxlength="100" placeholder="<?php echo yii::t('vcos', '活动开始时间')?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($schedule,'ts_start_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动结束时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="etime" name="etime" type="text" class="form-control col-xs-6 col-sm-6 col-md-6" maxlength="100" placeholder="<?php echo yii::t('vcos', '活动结束时间')?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($schedule,'ts_end_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo" id="photo"/>
                                        <?php echo $form->error($schedule,'ts_img_url'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '内容')?>：</label>
                                    <div class="col-xs-9 col-sm-9 col-md-9">
                                        <textarea id="contents" name="contents"></textarea>
                                        <font style="display: none"><?php echo yii::t('vcos', '请输入内容')?></font>
                                    </div>
                                    <?php echo $form->error($schedule_language,'ts_content'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_content">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '内容').yii::t('vcos','').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-9 col-sm-9 col-md-9">
                                        <textarea id="contents2" name="contents_iso"></textarea>
                                        <font style="display: none"><?php echo yii::t('vcos', '请输入内容').yii::t('vcos','').yii::t('vcos','(外语)')?></font>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.config.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.all.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    jQuery.validator.addMethod("etime", function(value, element) {   
        var assigntime = $("#stime").val();
        var deadlinetime = $("#etime").val();
        var reg = new RegExp(':','g');
        assigntime = assigntime.replace(reg,'/');//正则替换
        deadlinetime = deadlinetime.replace(reg,'/');
        assigntime = new Date(parseInt(Date.parse(assigntime),10));
        deadlinetime = new Date(parseInt(Date.parse(deadlinetime),10));
        if(assigntime>deadlinetime){
            return false;
        }else{
            return true;
        }
    }, "<?php echo Yii::t('vcos','请输入正确的结束时间');?>");
    
    UE.getEditor('contents');
    UE.getEditor('contents2');
    
    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
	        $(".iso").removeClass('hidden');
	        $(".iso input:text").addClass('required');
	        $(".iso textarea").addClass('required');
        }else if($check == 'yes'){
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
	        $(".iso input:text").removeClass('required');
	        $(".iso textarea").removeClass('required');
        }
    });
    
    $('form').submit(function(){
        var a = 1;
        if($('#contents').next().val()==''){
           $('#contents').next().next().show();
           a = 0;
        }
        if(!$(".iso_content").hasClass("hidden")){
            if($('#contents2').next().val()==''){
                $('#contents2').next().next().show();
                a = 0;
            }
        }
       if(a == 0){
           return false;
       }
    });
    
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>
    
    $("#add").validate({
        rules: {
            title: {required:true,stringCheckAll:true},
            address:{required:true,stringCheckAll:true},
            time:{
                required:true,
                dateISO:true
            },
            stime:"required",
            etime:{
                required:true,
                etime:true
            },
            photo:"required",
            desc:{required:true,stringCheckAll:true},
            title_iso: {stringCheckAll:true},
            address_iso:{stringCheckAll:true},
            desc_iso:{stringCheckAll:true}
        },
        messages:{
			title:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	desc:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	address:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
    		},
	    	title_iso:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	desc_iso:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	address_iso:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
    		}
		}
    });

    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
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
});
</script>