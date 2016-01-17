<?php
    $this->pageTitle = Yii::t('vcos','编辑导航组分类');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'navigation_group_category_add';
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
		.cat_name_list{color:red;}
		.cat_name_list  span{margin-right:2px;}
		.category_sel ul{list-style:none;}
		.category_sel li{cursor:pointer;margin-right:3px;float:left;}
		.cat_name_list > span{cursor:pointer;}
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
                            <?php echo yii::t('vcos', '导航管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '编辑导航组分类')?>
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
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '导航组')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="navigation_group">
                                    		<?php foreach($navigation_group as $row){?>
                                            <option value="<?php echo $row['navigation_group_id']?>" <?php if($navigation_group_category['navigation_group_id']==$row['navigation_group_id']){echo "selected='selected'";}?>><?php echo $row['navigation_group_name']?></option>
                                            <?php }?>
                                        </select>
                                        <?php echo $form->error($navigation_group_category,'navigation_group_cid'); ?> 
                                    </div>
                                </div>
                            	<div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '导航组分类名')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="name" placeholder="<?php echo yii::t('vcos', '导航组分类名')?>" class="col-xs-10 col-sm-8 col-md-8" name="name" maxlength="20" value="<?php echo $navigation_group_category['navigation_category_name']?>" />
                                        <?php echo $form->error($navigation_group_category,'navigation_category_name'); ?> 
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '排序')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                        <input type="text" id="sort" placeholder="<?php echo yii::t('vcos', '排序')?>" class="col-xs-10 col-sm-8 col-md-8" name="sort" maxlength="10" value="<?php echo $navigation_group_category['sort_order']?>"/>
                                        <?php echo $form->error($navigation_group_category,'sort_order'); ?> 
                                    </div>
                                </div>
                            	<div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分类类型')?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7">
                                    	<select class="col-xs-10 col-sm-8 col-md-8" id="form-field-select-1" name="type">
                                            <option value="1" <?php if($navigation_group_category['category_type']==1){echo "selected='selected'";}?>>分类</option>
                                            <option value="2" <?php if($navigation_group_category['category_type']==2){echo "selected='selected'";}?>>品牌</option>
                                            <option value="3" <?php if($navigation_group_category['category_type']==3){echo "selected='selected'";}?>>店铺</option>
                                        </select>
                                        <?php echo $form->error($navigation_group_category,'category_type'); ?> 
                                    </div>
                                </div>
                                <input type="hidden" name="mapping" value=""/>
                                <div class="space-4"></div>
                                <div class="form-group type_val">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right cate_name"><?php if($navigation_group_category['category_type']==1){echo "分类名";}elseif($navigation_group_category['category_type']==2){echo "品牌名";}elseif($navigation_group_category['category_type']==3){echo "店铺名";}?>：</label>
                                    <div class="col-xs-8 col-sm-8 col-md-7 category_sel <?php if($navigation_group_category['category_type']!=1){echo "hidden";}?>">
                                    	<select style="width:30%" id="form-field-select-1" name="cat1" class="cat1">
                                    		<option value='0'>请选择</option>
                                    		<?php
                                    		if($cat1_sel != ''){
                                    		foreach($cat1_sel as $c1){?>
                                    		<option value="<?php echo $c1['category_code']?>" <?php if($c1['category_code'] == $cat1_val){echo "selected='selected'";}?>><?php echo $c1['name']?></option>
                                    		<?php }}?>
                                        </select>
                                        <select style="width:30%" id="form-field-select-1" name="cat2" class="cat2">
                                        	<?php if($cat2_sel != ''){
                                        		foreach($cat2_sel as $c2){?>
                                    		<option value="<?php echo $c2['category_code']?>" <?php if($c2['category_code'] == $cat2_val){echo "selected='selected'";}?>><?php echo $c2['name']?></option>
                                    		<?php }}?>
                                        </select>
                                        <div class="cat_list" style="border:1px solid #ccc;">
                                        	<div class="checked_list">您选中：<span class="cat_name_list">
                                        	<?php if(strlen($checked_sel[0]['category_code']) == 7){
                                        		foreach($checked_sel as $ch){?>
                                        		<span val="<?php echo $ch['category_code']?>"><?php echo $ch['name']?>、</span>
                                        	<?php }}else{?>
                                        		<span class="two_val" val="<?php echo $cat2_val?>"><?php echo $cat2_name;?></span>
                                        	<?php }?>
                                        	</span>
                                        	</div>
                                        	<span class="two_checked" style="cursor:pointer;margin-left: 4%;margin-bottom:5px;margin-top:5px;"><?php echo $cat2_name;?></span>
                                        	<ul class="three_list">
                                        		<?php if($cat3_sel){
                                        		foreach($cat3_sel as $c3){?>
                                        		<li value="<?php echo $c3['category_code']?>"><?php echo $c3['name']?>、</li>
                                        		<?php }}?>
                                        	</ul>
                                        	<div style="clear:both;"></div>
                                        	<label>注意:只能选择一个二级分类或者选择多个三级分类</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 col-sm-8 col-md-7 hidden one_sel <?php if($navigation_group_category['category_type']==1){echo "hidden";}?>">
                                    	<select class="col-xs-10 col-sm-8 col-md-8 " id="form-field-select-1" name="one_val">
                                    		
                                        </select>
                                    </div>
                                    <?php echo $form->error($navigation_group_category,'mapping_id'); ?> 
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '是否高亮')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($navigation_group_category['is_highlight']){echo "checked='checked'";}?> class="ace ace-switch ace-switch-5" name="highlight" value="1" />
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                                    <label style="margin-left: 10px;">
                                        <input id="id-button-borders" type="checkbox" <?php if($navigation_group_category['status']){echo "checked='checked'";}?> class="ace ace-switch ace-switch-5" name="state" value="1" />
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
<script type="text/javascript">
jQuery(function($){

    $("#edit").validate({
        rules: {
        	name:{required:true,stringCheckAll:true},
            sort:{required:true,isIntGtZero:true}
        }
    });
    $('form').submit(function(){
        var a=1;
        var val = $("select[name='type'] option:selected").val();
        if(val==1){
        	if($("select[name='cat1'] option:selected").val()==0){
            	alert('请选择分类!');
            	a = 0;
            	return false;
            }
            var two_code = $("select[name='cat2'] option:selected").val();
            if(two_code == 0){
            	alert('请选择分类!');
            	a = 0;
            }
            if($(".cat_name_list").html() == ''){
            	alert('未选中分类!');
            	a = 0;
            	return false;
            }
        	var arr = $('.cat_name_list > span');
        	var str = '';
        	arr.each(function(){
            	var num = $(this).attr('val');
            	if(num == two_code){
                	str = num;
                }else{
                    str += num+',';
                }
            });
        	$("input[name='mapping']").val(str);
        }
        
        if(a == 0){
            return false;
        }
    });

	$("select[name='type']").change(function(){
		var this_val = $(this).val();
		if(this_val == 1){
			//分类
			$(".cate_name").html('分类名：');
			$('.one_sel').addClass('hidden');
			$('.category_sel').removeClass('hidden');
		}else if(this_val ==2 || this_val==3){
			//店铺3
			//品牌2
			var name = '';
			if(this_val == 2){name='品牌名:';}else{name='店铺名:';}
			var str = '';
			<?php $path_url = Yii::app()->createUrl('Navigation/CategoryTypeGetChild');?>
			$.ajax({
				url:"<?php echo $path_url;?>",
	            type:'get',
	            data:'type='+this_val,
	         	dataType:'json',
	        	success:function(data){
	        		$.each(data,function(key){  
	                   str += "<option value="+data[key]['val1']+">"+data[key]['val2']+"</option>"; 
	                });
	                $(".cate_name").html(name);
	                $(".category_sel").addClass('hidden');
	                $('.one_sel').removeClass('hidden');
	        		$("select[name='one_val']").html(str);
	        	}
			});
		}
		//alert(this_val);
	});

	$("select[name='cat1']").change(function(){
		var this_code = $(this).val();
		if(this_code == 0){$('.cat2').addClass('hidden');$('.cat_list').addClass('hidden');return false;}
		var str = '<option value="0">请选择</option>';
		<?php $path_url = Yii::app()->createUrl('Navigation/GetCategoryChild');?>
        $.ajax({
            url:"<?php echo $path_url;?>",
            type:'get',
            data:'code='+this_code,
         	dataType:'json',
        	success:function(data){
        		$.each(data,function(key){  
                   str += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                });
                $(".cat2").removeClass('hidden');
        		$("select[name='cat2']").html(str);
        	}        
        });
	});

	$("select[name='cat2']").change(function(){
		var this_code = $(this).val();
		if(this_code == 0){$('.cat_list').addClass('hidden');return false;}
		$('.cat_list').removeClass('hidden');
		var text = $(".cat2 option:selected").html();  
		$('.cat_list').find('.two_checked').html(text);
		var checked="<span class='two_val' val='"+this_code+"'>"+text+"</span>";
		$('.cat_name_list').html(checked);
		var str = '';
		<?php $path_url = Yii::app()->createUrl('Navigation/GetCategoryChild');?>
        $.ajax({
            url:"<?php echo $path_url;?>",
            type:'get',
            data:'code='+this_code,
         	dataType:'json',
        	success:function(data){
        		$.each(data,function(key){  
                   str += "<li value="+data[key]['category_code']+">"+data[key]['name']+"、</li>"; 
                });
                
        		$(".three_list").html(str);
        	}        
        });
		//alert(text);
	});

	$('.two_checked').click(function(){
		var this_code = $(".cat2 option:selected").val();
		var this_text = $(this).html();
		var str = "<span class='two_val' val='"+this_code+"'>"+this_text+"</span>";
		$('.cat_name_list').html(str);
	});

	$('.cat_list').on('click','.three_list > li',function(e){
		var this_code = $(this).attr('value');
		var this_name = $(this).html();
		var arr = $('.cat_name_list').find("span[val='"+this_code+"']");
		if(arr.length==1) return false;
		var str = "<span val='"+this_code+"'>"+this_name+"</span>";
		$('.cat_name_list').find('.two_val').remove();
		$('.cat_name_list').append(str);
	});

	$('.cat_list').on('click','.cat_name_list > span',function(e){
		$(this).remove();
	});
   
    
});
</script>
