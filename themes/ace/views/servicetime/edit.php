<?php
    $this->pageTitle = Yii::t('vcos','编辑服务时间');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'servicetime_add';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
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
                            <?php echo yii::t('vcos', '服务时间表管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑服务时间')?>
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
                                    'id'=>'edit'
                                ),
                            ));  
                            ?> 
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '编辑外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check='no' class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <input type='hidden' id='service_id' value="<?php echo $service['service_id']?>"/>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '部门名称')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles" placeholder="<?php echo yii::t('vcos', '部门名称')?>" class="col-xs-10 col-sm-8 col-md-8" name="title" maxlength="80" value="<?php echo $service_language['service_department'];?>" />
                                        <?php echo $form->error($service_language,'service_department'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_title">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '部门名称').yii::t('vcos','').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles2" placeholder="<?php echo yii::t('vcos', '部门名称').yii::t('vcos','').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="title_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($service['service_state']){echo'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '电话')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="tel" type="text" name="tel" placeholder="<?php echo yii::t('vcos', '电话')?>" value="<?php echo $service['service_tel'];?>" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '地址')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="address" placeholder="<?php echo yii::t('vcos', '地址')?>" class="col-xs-10 col-sm-8 col-md-8" name="address" maxlength="80" value="<?php echo $service_language['service_address'];?>"/>
                                        <?php echo $form->error($service_language,'service_address'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_address">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '地址').yii::t('vcos','').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="address2" placeholder="<?php echo yii::t('vcos', '地址').yii::t('vcos','').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="address_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '营业时间')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="time" placeholder="<?php echo yii::t('vcos', '营业时间')?>" class="col-xs-10 col-sm-8 col-md-8" name="time" maxlength="80" value="<?php echo $service_language['service_opening_time'];?>"/>
                                        <?php echo $form->error($service_language,'service_opening_time'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_time">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '营业时间').yii::t('vcos','').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="time2" placeholder="<?php echo yii::t('vcos', '营业时间').yii::t('vcos','').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="time_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <input type="hidden" value="" id="judge" name="judge">
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
<script src="<?php echo $theme_url; ?>/assets/js/typeahead-bs2.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/uncompressed/additional-methods.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/bootbox.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $("#edit").validate({
        rules: {
            title: {required:true,stringCheckAll:true},
            tel:{required:true,isTel:true},
            address:{required:true,stringCheckAll:true},
            time:{required:true,stringCheckAll:true},
            title_iso: {stringCheckAll:true},
            tel_iso:{isTel:true},
            address_iso:{stringCheckAll:true},
            time_iso:{stringCheckAll:true},
        },
        messages:{
			title:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	tel:{
	    			isTel: "<?php echo yii::t('vcos', '请正确填写您的联系方式')?>",
	    	},
	    	address:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	time:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	title_iso:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	tel_iso:{
	    			isTel: "<?php echo yii::t('vcos', '请正确填写您的联系方式')?>",
	    	},
	    	address_iso:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	},
	    	time_iso:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
	    	}
		}
    });
    
    $(".iso_choose").click(function(){
    	 $check = $(this).attr('check');
         if($check == 'no'){
             $(this).attr('check','yes');
	        $a = $(this).val();
	        $b = '<?php echo $_GET['id']?>';
	        $.post("<?php echo Yii::app()->createUrl("servicetime/getiso")?>",{iso:$a,id:$b},function(data){
	            if(data != 0){
	                var result = jQuery.parseJSON(data);
	                $(".iso input:text").val('');
	                $(".iso_title input:text").val(result['service_department']);
	                $(".iso_address input:text").val(result['service_address']);
	                $(".iso_time input:text").val(result['service_opening_time']);
	                $(".iso").removeClass('hidden'); 
	                $(".iso input:text").addClass('required');
	                $("#judge").val(result['id']);
	            }else{
	                $(".iso").removeClass('hidden');
	                $(".iso input:text").addClass('required');
	                $("#judge").val('add');
	            }
	        });
         }else if($check == 'yes'){
        	 $(this).attr('check','no');
             $(this).removeAttr('checked');
             $(".iso").addClass('hidden');
             $(".iso input:text").removeClass('required');
             $("#judge").val('');
         }
    });
    /**查看该港口名是否已经存在**/
    $('form').submit(function(){
        var msg = checkService();
	    if(msg == 0){
		    alert('部门名称已存在!');
	       return false;
	    }
    });
});
function checkService(){
    flag = 1;
    $service_name = $("input[name='title']").val();
    $this_id = $("input[id='service_id']").val();
	$url = "<?php echo Yii::app()->createUrl("Servicetime/ServiceGetAgain")?>";
	$.ajax({
		type:'post',
		data:'title='+$service_name+'&this_id='+$this_id,
		url:$url,
		async: false,
		success:function(data){
		    if(data > 0){
				flag =  0;
		    }else{
				flag =  1;
			}
		}
	});
	return flag;
}
</script>



