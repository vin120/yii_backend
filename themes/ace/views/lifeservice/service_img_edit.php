<?php
    $this->pageTitle = Yii::t('vcos','编辑休闲服务图片');
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
                                    <?php echo yii::t('vcos', '编辑休闲服务图片')?>
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
                            	<div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '添加外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check=<?php if($lifeservice_img['iso'] == 'zh_cn'){echo 'no';}else{echo 'yes';}?>  class="iso_choose" name="language" value="<?php echo $lifeservice_img['iso']?>" <?php if($lifeservice_img['iso'] == 'en'){echo "checked";}?>/>English
                                    </div>
                                </div>
                              <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分类名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="lifeservice">
                                            <?php foreach ($lifeservice_sel as $row){ ?>
                                            <option value="<?php echo $row['lc_id']?>" <?php if($lifeservice_category == $row['lc_id']){echo 'selected';}?>><?php echo $row['lc_name'];?></option>
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
                                            <option value="<?php echo $str['ls_id']?>" <?php if($str['ls_id'] == $lifeservice_img['lifeservice_id']){echo "selected";}?>><?php echo $str['ls_title'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
								<div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php echo $lifeservice_img['state']?'checked="checked"':'';?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                             
                                    <label id="upload_img_title" class="<?php if($lifeservice_img['iso']!='zh_cn'){echo 'hidden';}?> col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <label id="upload_img_title1" class="<?php if($lifeservice_img['iso']=='zh_cn'){echo 'hidden';}?> col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                  
                                    <img src="<?php echo Yii::app()->params['imgurl'].$lifeservice_img['img_url'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo" id="photo"/>
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $("#edit").validate({
        rules: {
        	rules: {
                lifeservice:{required:true, number:true},
                life_category:{required:true, number:true},
               // state:{required:true, number:true},
            }
        }
    });
   
  
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
    ?>


    <?php $path_url = Yii::app()->createUrl('Lifeservice/CategoryGetLifeservice'); ?>
    $("select[name='lifeservice']").change(function(){
        var str = '';
        var lifeservice = $(this).val();
        var title = <?php echo $lifeservice_img['lifeservice_id'];?>;
     	$.ajax({
         	url:"<?php echo $path_url;?>",
     		type:'get',
     		data:'lifeservice='+lifeservice+'&title='+title,
 		    dataType:'json',
 		    success:function(data){
 		    	$.each(data,function(key){  
                    str += "<option value="+data[key]['ls_id']+">"+data[key]['ls_title']+"</option>"; 
                });
 		    	$("select[name='life_category']").html(str);
 			}
        });   
    });

    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
            $(this).attr('value','en');
            $("#upload_img_title").addClass('hidden');
	        $("#upload_img_title1").removeClass('hidden');
        }else if($check == 'yes'){
        	$(this).attr('check','no');
        	$(this).attr('value','zh_cn');
            $(this).removeAttr('checked');
	        $("#upload_img_title").removeClass('hidden');
	        $("#upload_img_title1").addClass('hidden');
           
        }
    });
    
});
</script>


