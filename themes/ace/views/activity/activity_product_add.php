<?php
    $this->pageTitle = Yii::t('vcos','添加活动商品');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'activity_product_add';
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
                                    <?php echo yii::t('vcos', '添加活动商品')?>
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
                            	<div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="activity">
                                    		<?php foreach($activity as $row){?>
                                            <option value="<?php echo $row['activity_id'];?>"><?php echo $row['activity_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($activity_product,'activity_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '类型')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="product_type">
                                            <option value="3">店铺</option>
                                            <option value="4">活动</option>
                                            <option value="6">商品</option>
                                        </select>
                                        <?php echo $form->error($activity_product,'product_type'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group shop_sel">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '店铺')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="shop">
                                    		<?php foreach($shop as $row){?>
                                            <option value="<?php echo $row['shop_id'];?>"><?php echo $row['shop_title']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($activity_product,'product_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group activity_sel hidden">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="activity_child">
                                    		<?php foreach($activity_child as $row){?>
                                            <option value="<?php echo $row['activity_id'];?>"><?php echo $row['activity_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($activity_product,'product_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group product_sel hidden">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '商品')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<?php if($layer_1){?>
                                    	<select style="width:20%;" id="category_one" name="category_1">
                                          <?php foreach($layer_1 as $lay1){?>  
                                            <option value="<?php echo $lay1['category_code']?>"><?php echo $lay1['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_2){?>
                                    	<select style="width:20%;" id="category_two" name="category_2">
                                          <?php foreach($layer_2 as $lay2){?>  
                                            <option value="<?php echo $lay2['category_code']?>"><?php echo $lay2['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                        <?php if($layer_3){?>
                                    	<select style="width:20%;" id="category_three" name="category_3">
                                          <?php foreach($layer_3 as $lay3){?>  
                                            <option value="<?php echo $lay3['category_code']?>"><?php echo $lay3['name']?></option>
                                        	<?php }?>
                                        </select>
                                        <?php }?>
                                    	<select style="width:35%;" id="product_sel" name="product">
                                    		<?php foreach($product as $row){?>
                                            <option value="<?php echo $row['product_id'];?>"><?php echo $row['product_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($activity_product,'product_id'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group category_sel hidden">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '活动分类')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="activity_category">
                                    		<?php foreach($activity_category as $row){?>
                                            <option value="<?php echo $row['activity_cid'];?>"><?php echo $row['activity_category_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($activity_product,'activity_cid'); ?> 
                                    </div>
                                </div>
                                
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '排序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="sort" placeholder="<?php echo yii::t('vcos', '排序')?>" class="col-xs-10 col-sm-8 col-md-8" name="sort" maxlength="10" />
                                        <?php echo $form->error($activity_product,'sort_order'); ?> 
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
                                                <input class="form-control" type="text" name="time" id="time" data-rel="tooltip" title="开始时间为当天00:00:00,结束时间为当天23:59:59" data-placement="bottom"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo $form->error($activity_product,'start_show_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '开始时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="stime" name="stime" type="text" class="form-control col-xs-8 col-sm-8 col-md-8" maxlength="100" placeholder="<?php echo yii::t('vcos', '开始时间')?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($activity_product,'start_show_time'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '结束时间')?>：</label>
                                    <div class="col-xs-5 col-sm-5 col-md-5 input-group bootstrap-timepicker">
                                        <input id="etime" name="etime" type="text" class="form-control col-xs-6 col-sm-6 col-md-6" maxlength="100" placeholder="<?php echo yii::t('vcos', '结束时间')?>"/>
                                        <span class="input-group-addon">
                                            <i class="icon-time bigger-110"></i>
                                        </span>
                                    </div>
                                    <?php echo $form->error($activity_product,'end_show_time'); ?> 
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
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/moment.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/daterangepicker.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
jQuery(function($){
  
    
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
    
    $("#add").validate({
        rules: {
            sort:{required:true,isIntGtZero:true}
        }
    });


   $("select[name='product_type']").change(function(){
	   var this_id = $(this).val();
	   if(this_id == 3){
		   //店铺
		   $(".shop_sel").removeClass('hidden');
		   $(".activity_sel").addClass('hidden');
		   $(".product_sel").addClass('hidden');
		   $(".category_sel").addClass('hidden');
	   }else if(this_id == 6){
		   //商品
		   $(".shop_sel").addClass('hidden');
		   $(".product_sel").removeClass('hidden');
		   $(".category_sel").removeClass('hidden');
		   $(".activity_sel").addClass('hidden');
	   }else if(this_id == 4){
		   //商品
		   $(".activity_sel").removeClass('hidden');
		   $(".shop_sel").addClass('hidden');
		   $(".product_sel").addClass('hidden');
		   $(".category_sel").addClass('hidden');
	   }
	});


   /**改变商品分类一级,获取二级**/
   $('#category_one').change(function(){
       var this_code = $(this).val();
       var str = '';
       var str_ch = '';
       var str_pr = '';
       <?php $path_url = Yii::app()->createUrl('Activity/GetCategoryChild');?>
       <?php $path_url_product = Yii::app()->createUrl('Activity/GetCategoryProduct');?>
       $.ajax({
           url:"<?php echo $path_url;?>",
           type:'get',
           data:'parent_code='+this_code,
        	dataType:'json',
       	success:function(data){
       		$.each(data,function(key){  
                  str += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
               });
       		$("select[name='category_2']").html(str);
       		$.ajax({
                   url:"<?php echo $path_url;?>",
                   type:'get',
                   data:'parent_code='+data[0]['category_code'],
                	dataType:'json',
               	success:function(data){
               		$.each(data,function(key){  
                          str_ch += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                       });
               		$("select[name='category_3']").html(str_ch);
               		$.ajax({
                        url:"<?php echo $path_url_product;?>",
                        type:'get',
                        data:'parent_code='+data[0]['category_code'],
                     	dataType:'json',
                    	success:function(data){
                    		$.each(data,function(key){  
                               str_pr += "<option value="+data[key]['product_id']+">"+data[key]['product_name']+"</option>"; 
                            });
                    		$("select[name='product']").html(str_pr);
                    	}        
                 });
               	}        
            });
       	}        
       });
   });

   /**改变商品分类二级,获取三级**/
   $('#category_two').change(function(){
       var this_code = $(this).val();
       var str = '';
       var str_pr = '';
       <?php $path_url = Yii::app()->createUrl('Activity/GetCategoryChild');?>
       <?php $path_url_product = Yii::app()->createUrl('Activity/GetCategoryProduct');?>
       $.ajax({
           url:"<?php echo $path_url;?>",
           type:'get',
           data:'parent_code='+this_code,
        	dataType:'json',
       	success:function(data){
       		$.each(data,function(key){  
                  str += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
               });
       		$("select[name='category_3']").html(str);
       		$.ajax({
                url:"<?php echo $path_url_product;?>",
                type:'get',
                data:'parent_code='+data[0]['category_code'],
             	dataType:'json',
            	success:function(data){
            		$.each(data,function(key){  
                       str_pr += "<option value="+data[key]['product_id']+">"+data[key]['product_name']+"</option>"; 
                    });
            		$("select[name='product']").html(str_pr);
            	}        
         });
       	}      
       });
   });

   /**改变商品分类三级,获取商品**/
   $('#category_three').change(function(){
       var this_code = $(this).val();
       var str_pr = '';
       <?php $path_url_product = Yii::app()->createUrl('Activity/GetCategoryProduct');?>
       $.ajax({
           url:"<?php echo $path_url_product;?>",
           type:'get',
           data:'parent_code='+this_code,
	        dataType:'json',
	       	success:function(data){
	       		$.each(data,function(key){  
	       			str_pr += "<option value="+data[key]['product_id']+">"+data[key]['product_name']+"</option>"; 
	               });
	       		$("select[name='product']").html(str_pr);
	       		
	       	}      
       });
   });


   /**顶级活动改变 ，子级活动改变,活动分类改变***/
   $("select[name='activity']").change(function(){
	   var this_id = $(this).val();
	   var str_pr = '';
       <?php $path_url = Yii::app()->createUrl('Activity/GetActivityChild');?>
       $.ajax({
           url:"<?php echo $path_url;?>",
           type:'get',
           data:'parent_id='+this_id,
	        dataType:'json',
	       	success:function(data){
	       		$.each(data,function(key){  
	       			str_pr += "<option value="+data[key]['activity_id']+">"+data[key]['activity_name']+"</option>"; 
	               });
	       		$("select[name='activity_child']").html(str_pr);
	       		
	       	}      
       });
       var str_pr_category = '';
       <?php $path_url = Yii::app()->createUrl('Activity/GetActivityCategory');?>
       $.ajax({
           url:"<?php echo $path_url;?>",
           type:'get',
           data:'parent_id='+this_id,
	        dataType:'json',
	       	success:function(data){
	       		$.each(data,function(key){  
	       			str_pr_category += "<option value="+data[key]['activity_cid']+">"+data[key]['activity_category_name']+"</option>"; 
	               });
	       		$("select[name='activity_category']").html(str_pr_category);
	       		
	       	}      
       });
   });


});
</script>