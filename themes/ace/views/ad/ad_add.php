<?php
    $this->pageTitle = Yii::t('vcos','新增广告');
    $theme_url = Yii::app()->theme->baseUrl;
    $menu_type = 'ad_add';
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
    <style>
    	.hidden_type {display:none;}
	</style>
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
                            <?php echo yii::t('vcos', '广告管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '新增广告')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
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
                                        <input type="radio" check='no' id="en" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles" placeholder="<?php echo yii::t('vcos', '标题')?>" class="col-xs-10 col-sm-8 col-md-8" name="title" maxlength="80" />
                                        <?php echo $form->error($ad_language,'name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles" placeholder="<?php echo yii::t('vcos', '标题').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="title_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '跳转方式')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select name='type' class="col-xs-10 col-sm-8 col-md-8" id='type' >
                                        	<option value='0'><?php echo yii::t('vcos', '模块跳转');?></option>
                                        	<option value='1'><?php echo yii::t('vcos', 'http跳转');?></option>
                                        </select>
                                        <?php echo $form->error($ad,'link_type'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <!-- 模块链接跳转 -->
                                <div class="form-group" id="link_1">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '模块链接')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php echo yii::t('vcos', '邮轮动态')?>
                                        <select id="link_model" style="width:57%" name="link_model" >
                                        	<?php if($title_sel != ''){
                                        		foreach($title_sel as $row){	
                                        	?>
                                        	  <option value="<?php echo $row['article_id']?>"><?php echo $row['article_title']?></option>
                                        	<?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group  hidden iso" id="link_1_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '模块链接').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php echo yii::t('vcos', '邮轮动态')?>
                                        <select id="link_models" style="width:57%" name="link_model_iso" >
                                        	<?php if($title_en_sel != ''){
                                        		foreach($title_en_sel as $row){	
                                        	?>
                                        	  <option value="<?php echo $row['article_id']?>"><?php echo $row['article_title']?></option>
                                        	<?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <!-- url链接跳转 -->
                                <div class="form-group hidden" id="link_2">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '链接url')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="link_url" placeholder="<?php echo yii::t('vcos', '链接url')?>" class="col-xs-10 col-sm-8 col-md-8" name="link_url" maxlength="80" /> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso hidden_type" id="link_2_iso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '链接url').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="link_urls" placeholder="<?php echo yii::t('vcos', '链接url').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="link_url_iso" maxlength="80" /> 
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
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '广告图片显示位置')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" name="position">
                                            <?php foreach ($position as $row){ ?>
                                            <option value="<?php echo $row['position_id']?>"><?php echo yii::t('vcos', $row['position_name']);?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                    <?php echo $form->error($ad_language,'img_url'); ?>
                                </div>
                               <div class="space-4"></div> 
                                <div class="form-group  hidden iso iso_img">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo_iso" id="photo1"/>
                                    </div>
                                </div>
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
    $("#en").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
        	$(".iso").removeClass('hidden');
        }else if($check == 'yes'){
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
        }
    });
    
    $("#add").validate({
        rules: {
            title: {required:true,stringCheckAll:true},
            title_iso: {stringCheckAll:true},
            link_url: {url:true},
            link_url_iso: {url:true},
            photo:"required"
        },
        messages:{
			title:{
	            stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			},
			title_iso:{
		        stringCheckAll: "<?php echo yii::t('vcos', '只能包含中文、英文、数字、下划线、逗号、句号等字符')?>",
			}
		}
    });
    <?php
        $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>

    $("select[id='type']").change(function(){
	    var val = $(this).val();
	    if(val == 0){
		    //模块跳转
		    $("#link_1").removeClass('hidden');
		    $("#link_1_iso").removeClass('hidden_type');
		    $('#link_2').addClass('hidden');
		    $("#link_2_iso").addClass('hidden_type');
		    $("#link_2 input:text").removeClass('required');
		    
		}else if(val == 1){
			//http跳转
		    $("#link_1").addClass('hidden');
		    $("#link_1_iso").addClass('hidden_type');
		    $('#link_2').removeClass('hidden');
			$("#link_2_iso").removeClass('hidden_type');
		    $("#link_2 input:text").addClass('required');
		}
	});

    $('form').submit(function(){
		var val = $("select[id='type']").val();
		var rg = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
		if(val == 1){
			//http链接
			var link = $('#link_2').find("input[name='link_url']").val(); 
			var aa = rg.test(link);
		    if(!rg.test(link)){
		        alert("<?php echo yii::t('vcos', '正确填写http链接!')?>");
		        return false;
		    }
		}
	    if($("#en").is(":checked")){
		    //外语选中
			var link_iso = $('#link_2_iso').find("input[name='link_url_iso']").val();
			if(!rg.test(link_iso)){
			        alert("<?php echo yii::t('vcos', '正确填写http链接!')?>");
			        return false;
			    }
		}
	
	});
});
</script>

