<?php
    $this->pageTitle = Yii::t('vcos','添加甲板');
    $this->pageTag = 'cruise_deck_list';
    
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'cruise_deck_add';
?>
<?php 
    //navbar 挂件
    $disable = 1;
    $this->widget('navbarWidget',array('disable'=>$disable));
?>    
<link rel="stylesheet"  href="<?php echo $theme_url; ?>/assets/css/daterangepicker.css" />            
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
                            <?php echo yii::t('vcos', '公共设施管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '添加甲板')?>
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
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '甲板名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '甲板名')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="30" />
                                        <?php echo $form->error($deck_language,'deck_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_name">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '甲板名').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name_iso" placeholder="<?php echo yii::t('vcos', '甲板名').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="name_iso" maxlength="30" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '甲板层')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="layer"  placeholder="<?php echo yii::t('vcos', '甲板层')?>" class="col-xs-10 col-sm-8 col-md-8" name="layer" maxlength="4" />
                                        <?php echo $form->error($deck,'deck_layer'); ?> 
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
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                    <?php echo $form->error($deck_language,'img_url'); ?> 
                                </div>
                               <div class="space-4"></div> 
                                <div class="form-group  hidden iso iso_img">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo_iso" id="photo1"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
   
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>
    
    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
	        $(".iso").removeClass('hidden');
	        $(".iso input:text").addClass('required');
	        $(".iso input:file").addClass('required');
        }else if($check == 'yes'){
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
            $(".iso input:file").removeClass('required');
	        $(".iso input:text").removeClass('required');
        }
    });
    /**查看该港口名是否已经存在**/
    $('form').submit(function(){
        var msg = checkDeck();
	    if(msg == 0){
		    alert('甲板名已存在!');
	       return false;
	    }
    });
  
    $("#add").validate({
        rules: {
            name: {required:true,stringCheckAll:true},
            name_iso: {stringCheckAll:true},
            layer:{required:true, digits:true},
            photo:"required",
        },
        messages:{
            name:{
		            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			name_iso:{
		        stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			}
		}
       
    });
  
});
function checkDeck(){
    flag = 1;
    $service_name = $("input[name='name']").val();
	$url = "<?php echo Yii::app()->createUrl("Cruiseinfo/DeckGetAgain")?>";
	$.ajax({
		type:'post',
		data:'title='+$service_name,
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

