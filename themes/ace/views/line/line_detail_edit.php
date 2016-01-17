<?php
    $this->pageTitle = Yii::t('vcos','编辑航线介绍');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'line_detail_add';
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
                            <?php echo yii::t('vcos', '航线管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑航线介绍')?>
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
                                    'id'=>'edit',
                                    'role'=>'form',
                                		'enctype'=>'multipart/form-data',
                                )
                            ));  
                            ?> 
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '编辑外语')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="radio" check='no' class="iso_choose" name="language" value="en" />English
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '航线名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="line">
                                            <?php foreach ($line as $row){ ?>
                                            <option value="<?php echo $row['line_id']?>" <?php if($detail['line_id']==$row['line_id']){echo 'selected';}?> ><?php echo $row['line_name'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles" placeholder="<?php echo yii::t('vcos', '标题')?>" class="col-xs-10 col-sm-8 col-md-8" name="title" maxlength="80" value="<?php echo $detail_language['title'];?>"/>
                                        <?php echo $form->error($detail_language,'title'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_title">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '标题').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="titles2" placeholder="<?php echo yii::t('vcos', '标题').yii::t('vcos','(外语)')?>" class="col-xs-10 col-sm-8 col-md-8" name="title_iso" maxlength="80" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($detail['detail_state']){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '排序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="sequence" placeholder="<?php echo yii::t('vcos', '排序')?>" class="col-xs-10 col-sm-8 col-md-8" name="sequence" maxlength="5" value="<?php echo $detail['sequence']?>"/>
                                        <?php echo $form->error($detail,'sequence'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <img src="<?php echo Yii::app()->params['imgurl'].$detail_language['img_url'];?>" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo" id="photo"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group  hidden iso iso_img">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                    <img src="" class="col-xs-3 col-sm-3 col-md-3" title="<?php echo yii::t('vcos', '原图片')?>" />
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <input type="file" name="photo_iso" id="photo1"/>
                                    </div>
                                </div>  
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '航线介绍')?>：</label>
                                    <div class="col-xs-9 col-sm-9 col-md-9">
                                        <!-- <font style="display: none"><php echo yii::t('vcos', '请输入航线介绍')?></font> -->
                                        <?php 
		                                $msg = $detail_language['content'];
		                                $img_ueditor_old = Yii::app()->params['img_ueditor_old'];
		                                $count = preg_replace($img_ueditor_old,Yii::app()->params['img_ueditor'],$msg);
		                               // var_dump($count);
		                                ?>
                                        <textarea rows="10" cols="80" id="describe" name="describe"><?php echo $count;?></textarea>
                                        <label id="describe-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label>
                                    </div>
                                  
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group hidden iso iso_describe">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '航线介绍').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-9 col-sm-9 col-md-9">
                                        <!-- <font style="display: none"><php echo yii::t('vcos', '请输入航线介绍').yii::t('vcos','(外语)')?></font> -->
                                        <textarea rows="10" cols="80" id="describe2" name="describe_iso"></textarea>
                                        <label id="describe2-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label>
                                    </div>
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
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.config.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.all.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($){
    
    UE.getEditor('describe');
   
    
    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
	        $a = $(this).val();
	        $b = '<?php echo $_GET['id']?>';
	        $img_url = '<?php echo Yii::app()->params['imgurl'];?>';
	        $ueditor_url = "<?php echo Yii::app()->params['img_ueditor'];?>";
	        $img_ueditor_old = <?php echo Yii::app()->params['img_ueditor_old_js'];?>;
	        $.post("<?php echo Yii::app()->createUrl("line/getiso_detail")?>",{iso:$a,id:$b},function(data){
	            if(data != 0){
	                var result = jQuery.parseJSON(data);
	                $(".iso input:text").val('');
	                $(".iso textarea").html('');
	                $(".iso_title input:text").val(result['title']);
	                var msg = result['content'];
	                var reg = $img_ueditor_old;
	                msg= msg.replace(reg,$ueditor_url);
	                $(".iso_describe textarea").html(msg);
	                UE.getEditor('describe2');
	                $(".iso").removeClass('hidden'); 
	                $img_url = $img_url + result['img_url'];
	                $(".iso_img > img").attr('src',$img_url);
	                $(".iso input:text").addClass('required');
	                $("#judge").val(result['id']);
	            }else{
	                $(".iso").removeClass('hidden');
	                $(".iso input:text").addClass('required');
	                $(".iso input:file").addClass('required');
	                $("#judge").val('add');
	                UE.getEditor('describe2');
	            }
	        });
        }else if($check == 'yes'){
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso input:file").removeClass('required');
            $(".iso").addClass('hidden');
            $(".iso input:text").removeClass('required');
            $("#judge").val('');
        }
    });
    
    $('form').submit(function(){
        var a = 1;
       if($('#describe').next().val()==''){
           $('#describe').next().next().show();
           $('#describe-error').removeClass('hidden');
           a = 0;
       }
       if(!$(".iso_describe").hasClass("hidden")){
	       if($('#describe2').next().val()==''){
	           $('#describe2').next().next().show();
	           $('#describe2-error').removeClass('hidden');
	           a = 0;
	       }
       }
       if(a == 0){
           return false;
       }
    });
    
    $("#edit").validate({
        rules: {
            title: {required:true,stringCheckAll:true},
            sequence:{
                required:true,
                digits:true
            }
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
	        $this->widget('UploadjsWidget',array('form_id'=>'edit'));
	    ?>
});
</script>