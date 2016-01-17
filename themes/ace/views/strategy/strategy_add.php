<?php
    $this->pageTitle = Yii::t('vcos','添加攻略');
    $this->pageTag = 'strategy_list';
    
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'strategy_add';

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
                            <?php echo yii::t('vcos', '邮轮攻略管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '添加攻略')?>
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
                                <div class="form-group uniso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '国家')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="country">
                                            <?php 
                                            foreach ($country_sel as $row){
                                            	if($row['iso'] == 'zh_cn'){
                                            ?>
                                            <option class="china_sel" value="<?php echo $row['country_id']?>"><?php echo $row['country_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group iso hidden">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '国家').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="country_iso">
                                            <?php 
                                            foreach ($country_sel as $row){
                                            	if($row['iso'] == 'en'){
                                            ?>
                                            <option class="china_sel" value="<?php echo $row['country_id']?>"><?php echo $row['country_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group uniso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '城市')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="city">
                                            <?php foreach ($city_sel as $row){
                                            	if($row['iso'] == 'zh_cn'){
                                            ?>
                                            <option class="city_sel" value="<?php echo $row['city_id']?>"><?php echo $row['city_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group iso hidden">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '城市').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="city_iso">
                                            <?php foreach ($city_sel as $row){
                                            	if($row['iso'] == 'en'){
                                            ?>
                                            <option class="city_sel" value="<?php echo $row['city_id']?>"><?php echo $row['city_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group uniso">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '所属分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="category">
                                            <?php foreach ($category_sel as $row){ 
                                            if($row['iso']=='zh_cn'){?>
                                            <option value="<?php echo $row['strategy_category_id']?>"><?php echo $row['category_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group iso hidden">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '所属分类').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="category_iso">
                                            <?php foreach ($category_sel as $row){
                                            	if($row['iso']=='en'){?>
                                            <option value="<?php echo $row['strategy_category_id']?>"><?php echo $row['category_name'];?></option>
                                            <?php }}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '攻略名')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '攻略名').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '攻略名')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="16" />
                                        <?php echo $form->error($strategy_language,'strategy_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '描述')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<textarea id="desc" style=" overflow:auto; width: 66.6666%;height: 60px;resize: none;" placeholder="<?php echo yii::t('vcos', '描述')?>" name="desc" maxlength=80></textarea>
                                        <?php echo $form->error($strategy_language,'strategy_describe'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '人均价格')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '人均价格').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="price" type="text" maxlength='10' name="price" placeholder="<?php echo yii::t('vcos', '人均价格')?>" />
                                        <?php echo $form->error($strategy_language,'avg_price'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '地址')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '地址').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="address" type="text" maxlength='80' name="address" placeholder="<?php echo yii::t('vcos', '地址')?>" />
                                        <?php echo $form->error($strategy_language,'address'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '电话号码')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '电话号码').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="phone" type="text" name="phone" maxlength='11' placeholder="<?php echo yii::t('vcos', '电话号码')?>" />
                                        <?php echo $form->error($strategy_language,'telphone'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '类别')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '类别').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="type" type="text" name="type" maxlength='16' placeholder="<?php echo yii::t('vcos', '类别')?>" />
                                        <?php echo $form->error($strategy_language,'strategy_type'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '特色')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '特色').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input class="col-xs-10 col-sm-8 col-md-8" id="feature" type="text" name="feature" maxlength='80' placeholder="<?php echo yii::t('vcos', '特色')?>" />
                                        <?php echo $form->error($strategy_language,'strategy_feature'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '状态').yii::t('vcos','(外语)')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group photo_type hidden">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片类型')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '图片类型').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="photo_type">
                                            <option value="1"><?php echo yii::t('vcos', '大图');?></option>
                                            <option value="2"><?php echo yii::t('vcos', '列表');?></option>
                                            <option value="3"><?php echo yii::t('vcos', '多图');?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group one_photo">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '图片').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo" id="photo"/>
                                        <?php echo $form->error($strategy_language,'img_url'); ?> 
                                    </div>
                                    <label id="one-photo-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group two_photo hidden">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片2')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '图片2').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo2" id="photo2"/>
                                        <?php echo $form->error($strategy_language,'img_url2'); ?> 
                                    </div>
                                    
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group three_photo hidden">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '图片3')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '图片3').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input type="file" name="photo3" id="photo3"/>
                                        <?php echo $form->error($strategy_language,'img_url3'); ?> 
                                    </div>
                                    <label id="one-photo-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label>
                                </div>
                                
                               <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="uniso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '详情')?>：</label>
                                    <label class="iso col-xs-2 col-sm-2 col-md-2 control-label no-padding-right hidden"><?php echo yii::t('vcos', '详情').yii::t('vcos','(外语)')?>：</label>
                                    <div class="col-xs-9 col-sm-9 col-md-9">
                                        <font style="display: none"><?php echo yii::t('vcos', '请输入内容')?></font>
                                        <textarea id="contents" name="contents"></textarea>
                                        <label id="describe-error" class=" hidden" ><?php echo yii::t('vcos', '必填字段')?></label>
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
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.config.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ueditor.all.js"></script>
<script type="text/javascript">
jQuery(function($){
	UE.getEditor('contents');
    $(".iso_choose").click(function(){
    	$check = $(this).attr('check');
        if($check == 'no'){
            $(this).attr('check','yes');
	        $(".iso").removeClass('hidden');
	        $(".uniso").addClass('hidden');
	        $("input[name='name']").attr('placeholder',"<?php echo yii::t('vcos', '攻略名').yii::t('vcos','(外语)')?>");
	        $("textarea[name='desc']").attr('placeholder',"<?php echo yii::t('vcos', '描述').yii::t('vcos','(外语)')?>");
	        $("input[name='price']").attr('placeholder',"<?php echo yii::t('vcos', '人均价格').yii::t('vcos','(外语)')?>");
	        $("input[name='address']").attr('placeholder',"<?php echo yii::t('vcos', '地址').yii::t('vcos','(外语)')?>");
	        $("input[name='phone']").attr('placeholder',"<?php echo yii::t('vcos', '电话号码').yii::t('vcos','(外语)')?>");
	        $("input[name='type']").attr('placeholder',"<?php echo yii::t('vcos', '类别').yii::t('vcos','(外语)')?>");
	        $("input[name='feature']").attr('placeholder',"<?php echo yii::t('vcos', '特色').yii::t('vcos','(外语)')?>");
        }else if($check == 'yes'){
        	$(this).attr('check','no');
            $(this).removeAttr('checked');
            $(".iso").addClass('hidden');
	        $(".uniso").removeClass('hidden');
	        $("input[name='name']").attr('placeholder',"<?php echo yii::t('vcos', '攻略名')?>");
	        $("textarea[name='desc']").attr('placeholder',"<?php echo yii::t('vcos', '描述')?>");
	        $("input[name='price']").attr('placeholder',"<?php echo yii::t('vcos', '人均价格')?>");
	        $("input[name='address']").attr('placeholder',"<?php echo yii::t('vcos', '地址')?>");
	        $("input[name='phone']").attr('placeholder',"<?php echo yii::t('vcos', '电话号码')?>");
	        $("input[name='type']").attr('placeholder',"<?php echo yii::t('vcos', '类别')?>");;
	        $("input[name='feature']").attr('placeholder',"<?php echo yii::t('vcos', '特色')?>");
        }
    });
    

    $('form').submit(function(){
        var a = 1;
        if($('#contents').next().val()==''){
           $('#contents').next().next().show();
           $('#describe-error').removeClass('hidden');
           a = 0;
        }
        
		
		//多图上传判断
		/*
        if($("#upload_file_img").val() == ''){
            alert('文件上传不能为空');
            return false;
        }*/
       if(a == 0){
           return false;
       }
    });
    
    $("#add").validate({
        rules: {
            name:{required:true,stringCheckAll:true},
            desc:{required:true,stringCheckAll:true},
            address:{required:true,stringCheckAll:true},
            type:{required:true,stringCheckAll:true},
            feature:{required:true,stringCheckAll:true},
            price:{required:true, isFloatGtZero:true},
            country:{required:true, digits:true},
            city:{required:true, digits:true},
            category:{required:true, digits:true},
            phone:{required:true, isTel:true},
            photo:{required:true}
        }
    });
   
    
	<?php $path_url = Yii::app()->createUrl('Strategy/CountryGetCity');?>
    $("select[name='country']").change(function(){
        var str = '';
        var country = $(this).val();
     	$.ajax({
         	url:"<?php echo $path_url;?>",
     		type:'get',
     		data:'iso=zh_cn&country='+country,
 		    dataType:'json',
		    success:function(data){
		    	$.each(data,function(key){  
                    str += "<option value="+data[key]['city_id']+">"+data[key]['city_name']+"</option>"; 
                });
		    	$("select[name='city']").html(str);
			}
        });   
    });
    $("select[name='country_iso']").change(function(){
        var str = '';
        var country = $(this).val();
     	$.ajax({
         	url:"<?php echo $path_url;?>",
     		type:'get',
     		data:'iso=en&country='+country,
 		    dataType:'json',
		    success:function(data){
		    	$.each(data,function(key){  
                    str += "<option value="+data[key]['city_id']+">"+data[key]['city_name']+"</option>"; 
                });
		    	$("select[name='city_iso']").html(str);
			}
        });   
    });



    //判断所属分类属于美景时
    $("select[name='category']").change(function(){
    	var this_text = $("select[name='category'] option:selected").text();
    	if(this_text == '美景' || this_text == 'Beautiful scenery'){
        	$(".photo_type").removeClass('hidden');
        }else{
        	$(".photo_type").addClass('hidden');
        }
    });
    $("select[name='category_iso']").change(function(){
    	var this_text = $("select[name='category_iso'] option:selected").text();
    	if(this_text == 'Beautiful scenery'){
        	$(".photo_type").removeClass('hidden');
        }else{
        	$(".photo_type").addClass('hidden');
        }
    });

    //判断图片类型选择多图时，由于图片控件自动加载完导致后期更改图片上传数量无效
    
    $("select[name='photo_type']").change(function(){
    	var this_val = $(this).val();
    	if(this_val == 3){
        	//多文件上传显示
        	$(".two_photo").removeClass('hidden');
        	$(".three_photo").removeClass('hidden');
        	$("input[name='photo2']").addClass('required');
        	$("input[name='photo3']").addClass('required');
    		//解决单文件上传和多文件上传样式冲突
    		$("#demo .file-label").remove();
        }else{
            //单文件上传显示
        	$(".two_photo").addClass('hidden');
        	$(".three_photo").addClass('hidden');
        	$("input[name='photo2']").removeClass('required');
        	$("input[name='photo3']").removeClass('required');
        }
    });
    <?php
       $this->widget('UploadjsWidget',array('form_id'=>'add'));
    ?>
});
</script>



