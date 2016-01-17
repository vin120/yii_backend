<?php
    $this->pageTitle = Yii::t('vcos','添加休闲服务新图片');
    $this->pageTag = 'service_img_list';
    
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'service_img_add';
?>
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
                            <?php echo yii::t('vcos', '休闲服务管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '添加休闲服务新图片')?>
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
                                        <input type="radio" check='no'  class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分类名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="lifeservice">
                                            <?php foreach ($lifeservice_sel as $row){ ?>
                                            <option value="<?php echo $row['lc_id']?>"><?php echo $row['lc_name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="life_category">
                                            <?php foreach ($life_title_sel as $str){?>
                                            <option value="<?php echo $str['ls_id']?>"><?php echo $str['ls_title'];?></option>
                                            <?php }?>
                                        </select>
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
                                    <label id="upload_img_title" class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <label id="upload_img_title1" class="hidden col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                    	<input id="upload_file_img" type="hidden" name="file_img" value="" />
                                    	<?php $url = Yii::app()->createUrl('Uploader/ImgFileUpload',array('service_images'));?>
                                        <div id="demo" class="demo" lang="<?php echo Yii::app()->language; ?>" data="<?php echo $url;?>"></div>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- 引用控制层插件样式 -->
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/zyUpload.css" type="text/css">
<!-- 引用核心层插件 -->
<script type="text/javascript" src="<?php echo $theme_url; ?>/assets/js/zyFile.js"></script>
<!-- 引用控制层插件 -->
<script type="text/javascript" src="<?php echo $theme_url; ?>/assets/js/zyUpload.js"></script>
<!-- 引用初始化JS -->
<script type="text/javascript" src="<?php echo $theme_url; ?>/assets/js/uP_demo.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
    	
        if($check == 'no'){
            //选中状态
            $(this).attr('check','yes');
	        $(".iso").removeClass('hidden');
	        $(".iso input:text").addClass('required');
	        $("#upload_img_title").addClass('hidden');
	        $("#upload_img_title1").removeClass('hidden');
        }else if($check == 'yes'){
           	//取消状态
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
	        $(".iso input:text").removeClass('required');
	        $("#upload_img_title").removeClass('hidden');
	        $("#upload_img_title1").addClass('hidden');
        }
    });
    
    $("#add").validate({
        rules: {
            //state:{required:true, number:true},
            lifeservice:{required:true, number:true},
            life_category:{required:true, number:true},
        }
    });

    $('form').submit(function(){
      if($("#upload_file_img").val() == ''){
          alert('文件上传不能为空');
          return false;
      }
    });


    <?php $path_url = Yii::app()->createUrl('Lifeservice/CategoryGetLifeservice'); ?>
    $("select[name='lifeservice']").change(function(){
        var str = '';
        var lifeservice = $(this).val();
     	$.ajax({
         	url:"<?php echo $path_url;?>",
     		type:'get',
     		data:'lifeservice='+lifeservice,
 		    dataType:'json',
 		    success:function(data){
 		    	$.each(data,function(key){  
                    str += "<option value="+data[key]['ls_id']+">"+data[key]['ls_title']+"</option>"; 
                });
 		    	$("select[name='life_category']").html(str);
 			}
        });   
    });

   
    
});
</script>



