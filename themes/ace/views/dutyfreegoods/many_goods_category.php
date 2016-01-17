<?php
    $this->pageTitle = Yii::t('vcos','多级商品分类');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'many_goods_category';
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
    	.hidden_child{
	    	width:0;
			height:0;
			border-top:6px solid transparent;
			border-bottom: 6px solid transparent;
			border-left: 8px solid #ccc;
			display:inline-block;
			margin-right:4px;
			cursor:pointer;
			
    	}
    	.blank_left{
    		width:12px;
    		display:inline-block;
    	}
    	.show_child{
    		width:0;
			height:0;
			border-left:6px solid transparent;
			border-right:6px solid transparent;
			border-top:8px solid #ccc; 
			cursor:pointer;
			position:relative;
			top:16px;
			right:2px;
    	}
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
                            <?php echo yii::t('vcos', '免税精品管理')?>
                            <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '多级商品分类')?>
                            </small>
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                           <table  id="many_goods_category" class="table table-striped table-bordered table-hover">
                                <thead>
                                	<tr>
                                        <th><?php echo yii::t('vcos', '分类编码')?></th>
                                        <th><?php echo yii::t('vcos', '分类名称')?></th>
                                        <th><?php echo yii::t('vcos', '排序')?></th>
                                        <th><?php echo yii::t('vcos', '状态')?></th>
                                        <th><?php echo yii::t('vcos', '操作')?>&nbsp;<span id='add_one_category'>添加一级分类</span></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                	<?php if($data){?>
                                	<?php foreach ($data as $key=>$row) { ?>
                                	<!-- <php $child=0; if($key+1 < count($data)){if($data[$key+1]['parent_code'] == $row['goods_category_code']){$child = 1;}}?> -->
                                       <tr parent="<?php echo $row['parent_cid']?>" class="<?php if($row['level']!=1){echo "hidden";}?>" layer="<?php echo $row['level']?>" edit="0" val="<?php echo $row['cid']?>">
                                          <td><?php if($row['level']!=1){?><span class="category_code_first hidden"><?php echo $row['parent_cid']?></span><?php }?><input class="category_code<?php if($row['level']!=1){echo ' hidden';}?>" type="<?php if($row['level']==1){echo 'hidden';}else{echo 'text';}?>" style="width:<?php if($row['level']==2){echo '28px';}else{echo '35px';}?>" name="category_code[]" value="<?php if($row['level']==1){echo $row['category_code'];}elseif($row['level']==2){echo substr($row['category_code'],2);}elseif($row['level']==3){echo substr($row['category_code'],4);}?>" maxlength="<?php if($row['level']==1){echo '2';}else{echo $row['level'];}?>"/><span class="cat_code"><?php echo $row['category_code']?></span></td>
                                          <td><i hid="0" class="show_click <?php if($row['level']!=3){echo "hidden_child";}else{echo "blank_left";}?>"></i><label class="label_line">|<?php if($row['level']==1){echo '一';}elseif($row['level']==2){echo '一一一';}elseif($row['level']==3){echo '一一一一一';}?></label><input type="text" class="category_name hidden" value="<?php echo $row['name']?>" name="category_name[]"/><span class="cat_name"><?php echo $row['name']?></span></td>
                                          <td><input style="width:50px;" type="text" value="<?php echo $row['sort_order']?>" class="category_sort hidden" name="category_sort[]"/><span class="cat_sort"><?php echo $row['sort_order']?></span></td>
                                          <td><label class="category_state hidden" style="margin-left: 10px;"><input  id="id-button-borders" type="checkbox" <?php if($row['status']==1){echo 'checked="checked"';}?> class="ace ace-switch ace-switch-5" name="state[]" value="1" /><span class="lbl"></span></label><span class="cat_state"><?php if($row['status']==1){echo '启用';}else{echo '禁用';}?></span></td>
                                          <td><?php if($row['level']!=3){?><span class="<?php if($row['level']==1){echo "add_two_category";}else{echo "add_three_category";}?>">添加</span>&nbsp;<?php }?><span class="edit_category">编辑</span>&nbsp;<span class="del_category">删除</span>&nbsp;<span class="add_finish">完成</span></td>             
                                     </tr>
                                    <?php }?>
                                	<?php }?>
                                </tbody>
                                
                                
                           </table>
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
<style>
	.hidden{display:none;}
	.label_line{margin-top:-1px;}
</style>
<script type="text/javascript">
jQuery(function($){
    /**增加一级分类**/
	$("#add_one_category").click(function(){
		//查询是否存在其他地方正在操作
		var num =$("#many_goods_category tbody tr[edit='1']").length;
		if(num != 0){
			alert('正在执行操作,不能继续添加!');
			return false;
			}
		//查询一级分类是否存在10-99中商品
		var number = 1;
		$.ajax({
			type: "get",
			url: "<?php echo Yii::app()->createUrl("Dutyfreegoods/Check_goods_number")?>",
			async: false, 
			data: 'layer=1',
			success: function (data) { 
			    if(data){ 
			    	if(data > 90) number=0;
			    }
			}
		});
		//一级分类超过90种商品则不可再添加
		if(number == 0){alert('该分类下已经存在99种商品,不能再添加更多!'); return false;}
		
		//查询数据库id
		var this_id = '';
		$.ajax({
			type: "get",
			url: "<?php echo Yii::app()->createUrl("Dutyfreegoods/CategoryMaxId")?>",
			async: false, 
			data: 'layer=1',
			success: function (data) { 
			    if(data != 0){ 
				    data = (parseInt(data)) +1;
				    if(data == 100){this_id = '';}else{
				    this_id = String(data); }
				    
			    }else{this_id = String(10);}
			}
		 });
		var str = '';
	    str += '<tr class="" layer="1" edit="1" val="0" parent="0">';
        str += '<td><input type="text" maxlength="2" style="width:35px;" class="category_code" value="'+this_id+'"/><span class="cat_code hidden">'+this_id+'</span></td>';
        str += '<td><i hid="0" class="show_click hidden_child"></i><label class="label_line">|一</label><input type="text" class="category_name" value="" name="category_name[]"/><span class="cat_name hidden">aaa</span></td>';      
        str += '<td><input style="width:50px;" type="text" value="" class="category_sort" name="category_sort[]"/><span class="cat_sort hidden">12</span></td>';    
    	str += '<td><label class="category_state" style="margin-left: 10px;"><input  id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state[]" value="1" /><span class="lbl"></span></label><span class="cat_state hidden">禁用</span></td>';
    	str += '<td><span class="add_two_category">添加</span>&nbsp;<span class="edit_category">编辑</span>&nbsp;<span class="del_category">删除</span>&nbsp;<span class="add_finish">完成</span></td>';
    	str += '</tr>';
		
    	$("#many_goods_category").append(str);
		//alert();
	});

	/**增加二级分类**/
	$(document).on('click','.add_two_category',function(e){
	    var this_val = $(this).parent().parent();
	  //查询是否存在其他地方正在操作
		var num =$("#many_goods_category tbody tr[edit='1']").length;
		if(num != 0){
			alert('正在执行操作,不能继续添加!');
			return false;
			}
			
		//查询二级分类是否存在10-99中商品
		var this_parent_code = this_val.find('.cat_code').html();
		var number = 1;
		$.ajax({
			type: "get",
			url: "<?php echo Yii::app()->createUrl("Dutyfreegoods/Check_goods_number")?>",
			async: false, 
			data: 'layer=2&code='+this_parent_code,
			success: function (data) { 
			    if(data != 0){ 
			    	if(data > 99) number=0;
			    }
			}
		});
		//二级分类超过90种商品则不可再添加
		if(number == 0) {alert('该分类下已经存在99种商品,不能再添加更多!');return false};
		//return false;
	  	//查询数据库id
		var this_id = '';
		var parent = this_val.find(".cat_code").html();
		$.ajax({ 
			type: "get",
			url: "<?php echo Yii::app()->createUrl("Dutyfreegoods/CategoryMaxId")?>",
			async: false, 
			data: 'layer=2&parent='+parent,
			success: function (data) { 
			    if(data !=0){ 
				    data = (parseInt(data)) +1;
				    this_id = String(data); 
			    }else{
				    this_id = String(parent+'01');
				}
			}
		 });
		var first_code = this_id.substr(0,2);
		var code = this_id.substr(2);
		//判断增加的编码开头是否超越父级
		if(parseInt(parent) != parseInt(first_code)){
			first_code = parent;
			code = '';
			this_id = '';
		}
		
	    var str = '';
	    str += '<tr class="" layer="2" edit="1" val="0" parent="'+first_code+'">';
        str += '<td><span class="category_code_first">'+first_code+'</span><input class="category_code" type="text" style="width:28px;" name="category_code[]" value="'+code+'" maxlength="2"/><span class="cat_code hidden">'+this_id+'</span></td>';
        str += '<td><i hid="0" class="show_click hidden_child"></i><label class="label_line">|一一一</label><input class="category_name" type="text" value="" name="category_name[]"/><span class="cat_name hidden">bbb</span></td>';      
        str += '<td><input style="width:50px;" class="category_sort" type="text" value="" name="category_sort[]"/><span class="cat_sort hidden">13</span></td>';    
    	str += '<td><label class="category_state" style="margin-left: 10px;"><input id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state[]" value="1" /><span class="lbl"></span></label><span class="cat_state hidden">禁用</span></td>';
    	str += '<td><span class="add_three_category">添加</span>&nbsp;<span class="edit_category">编辑</span>&nbsp;<span class="del_category">删除</span>&nbsp;<span class="add_finish">完成</span></td>';
    	str += '</tr>';
    	this_val.after(str);
	});

	/**增加三级分类**/
	$(document).on('click','.add_three_category',function(e){
	  //查询是否存在其他地方正在操作
	  	var this_val = $(this).parent().parent();
		var num =$("#many_goods_category tbody tr[edit='1']").length;
		if(num != 0){
			alert('正在执行操作,不能继续添加!');
			return false;
			}

		//查询三级分类是否存在10-99中商品
		var this_parent_code = this_val.find('.cat_code').html();
		var number = 1;
		$.ajax({
			type: "get",
			url: "<?php echo Yii::app()->createUrl("Dutyfreegoods/Check_goods_number")?>",
			async: false, 
			data: 'layer=3&code='+this_parent_code,
			success: function (data) { 
			    if(data){ 
			    	if(data > 999) number=0;
			    }
			}
		});
		//三级分类超过90种商品则不可再添加
		if(number == 0) {alert('该分类下已经存在999种商品,不能再添加更多!');return false};
		//return false;
		
	  	//查询数据库id
	  	var parent = this_val.find(".cat_code").html();
		var this_id = '';
		$.ajax({ 
			type: "get",
			url: "<?php echo Yii::app()->createUrl("Dutyfreegoods/CategoryMaxId")?>",
			async: false, 
			data: 'layer=3&parent='+parent,
			success: function (data) { 
			    if(data != 0){ 
				    data = (parseInt(data)) +1;
				    this_id = String(data); 
			    }else{
				    this_id = String(parent + '001');
				}
			}
		 });
		var first_code = this_id.substr(0 ,4);
		var code = this_id.substr(4);
		//判断增加的编码开头是否超越父级
		if(parent != first_code){
			first_code = parent;
			code = '';
			this_id = '';
		}
		
	    var str = '';
	    str += '<tr class="" layer="3" edit="1"  val="0" parent="'+first_code+'">';
        str += '<td><span class="category_code_first">'+first_code+'</span><input class="category_code" type="text" style="width:35px;" name="category_code[]" value="'+code+'" maxlength="3"><span class="cat_code hidden">'+this_id+'</span></td>';
        str += '<td><i hid="0" class="show_click blank_left"></i><label class="label_line">|一一一一一</label><input type="text" class="category_name" value="" name="category_name[]"/><span class="cat_name hidden">ccc</span></td>';      
        str += '<td><input style="width:50px;" class="category_sort" type="text" value="" name="category_sort[]"/><span class="cat_sort hidden">14</span></td>';    
    	str += '<td><label class="category_state" style="margin-left: 10px;"><input  id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state[]" value="1" /><span class="lbl"></span></label><span class="cat_state hidden">启用</span></td>';
    	str += '<td><span class="edit_category">编辑</span>&nbsp;<span class="del_category">删除</span>&nbsp;<span class="add_finish">完成</span></td>';
    	str += '</tr>';
    	this_val.after(str);
	});

	/**分类提交**/
	$(document).on('click','.add_finish',function(e){
		var this_obj = $(this).parent().parent();
		var this_edit = this_obj.attr('edit');
		var this_layer = this_obj.attr('layer');
		if(this_edit == 0){return false;}
		
		//判断该行数据是新增还是修改
		var this_id = this_obj.attr('val');
		var code_first = this_obj.find(".category_code_first").html();
		var code = this_obj.find(".category_code").val();
		var name = this_obj.find(".category_name").val();
		var sort = this_obj.find(".category_sort").val();
		var state = this_obj.find('input:checkbox:checked').val();
		if(state != 1){ state = 0;}
		//判断提交完成是否有存在值为空
		if(code == '' || name == '' || sort == ''){
			alert('不能存在空值!');
			return false;
		}
		//验证
		var ex = /^\d+$/;
		if (!ex.test(sort) || sort<=0) {
		   // 则为整数
			alert('排序必须为正整数!');
			return false;
		} 
		
		
		if(this_layer != 1){
			 code = code_first+code;
			 parent_code = code_first;
		}else{
			parent_code = 0;
		}
		//return false;
		//var data = 'parent_code='+parent_code+'&code='+code+'&name='+name+'&sort='+sort+'&state='+state;
		//alert(data);
		//return false;
		//判断编码是否符合
		//先判断编码位数是否正确
		var this_layer = this_obj.attr('layer');
		if(code.length != 2 && this_layer == 1){alert('编码必须为两位数');return false;}
		if(code.length != 4 && this_layer == 2){alert('编码必须为四位数');return false;}
		if(code.length != 7 && this_layer == 3){alert('编码必须为七位数');return false;}
		
		//再判断该条数据是编辑还是新增，是否可以使用该编码
		var is_add_or_edit = this_obj.attr('val');
		//编码是否可用，0代表不可用，1代表可使用
		var is_may = 0;
		$.ajax({
			type:'get',
			async: false, 
			url:'<?php echo Yii::app()->createUrl("Dutyfreegoods/Check_code_exites")?>',
			data:'is_code='+is_add_or_edit+'&code='+code,
			success:function(msg){
				is_may = msg;
			}
		});
		if(is_may == 0) {alert('该条数据编码已经存在使用，请更换编码!'); return false;}
		
		
		
		//数据入库
		$.post("<?php echo Yii::app()->createUrl("Dutyfreegoods/Many_goods_category_data")?>",{id:this_id,parent_code:parent_code,code:code,name:name,sort:sort,state:state},function(data){
		    if(data != 0){
			    alert("<?php echo yii::t('vcos', '入库成功!')?>");
			    
		    }else{
				alert("<?php echo yii::t('vcos', '入库失败!')?>");
			}
		    location.href = "<?php echo Yii::app()->createUrl("Dutyfreegoods/many_goods_category")?>";//location.href实现客户端页面的跳转
			
		});
		/*
		//提交完成后将数据赋值在span文本内，隐藏文本框
		if(this_layer != 1){
			//不是一级分类
			this_obj.find(".category_code_first").addClass('hidden');
			this_obj.find(".category_code").addClass('hidden');
			this_obj.find(".cat_code").html(code);
			this_obj.find(".cat_code").removeClass('hidden');
		}else{
			//一级分类
			this_obj.find(".category_code").attr('type','hidden');
			this_obj.find(".cat_code").html(code);
			this_obj.find(".cat_code").removeClass('hidden');
		}
		this_obj.find(".category_name").addClass('hidden');
		this_obj.find(".cat_name").html(name);
		this_obj.find(".cat_name").removeClass('hidden');
		this_obj.find(".category_sort").addClass('hidden');
		this_obj.find(".cat_sort").html(sort);
		this_obj.find(".cat_sort").removeClass('hidden');
		var state_text = '启用';
		if(state == 0) state_text = '禁用';
		this_obj.find(".category_state").addClass('hidden');
		this_obj.find(".cat_state").html(state_text);
		this_obj.find(".cat_state").removeClass('hidden');
		this_obj.attr('edit','0');
		this_obj.attr('parent',parent_code);
		//this_obj.attr('val',code);
		//alert(data);
		*/
	});

	/**编辑分类**/
	$(document).on('click','.edit_category',function(e){
	    //查询是否存在其他地方正在操作
	  	var this_obj = $(this).parent().parent();
		var num =$("#many_goods_category tbody tr[edit='1']").length;
		if(num != 0){
			alert('正在执行操作,不能继续添加!');
			return false;
			}
		//查询存在子类不允许编辑编码code
		var this_code = this_obj.find(".cat_code").html();
		//0代码不允许编辑编码，1代码允许编辑编码
		var is_may = 0;
		$.ajax({
			type:'get',
			async: false, 
			url:'<?php echo Yii::app()->createUrl("Dutyfreegoods/Check_is_child")?>',
			data:'code='+this_code,
			success:function(msg){
				is_may = msg;
			}
		});
		//查看当前状态
		var this_layer = this_obj.attr('layer');
		if(is_may != 0){
		if(this_layer == 1){
		    this_obj.find(".category_code").attr('type','text');
		    this_obj.find(".cat_code").addClass('hidden');
		}else{
		    this_obj.find(".category_code_first").removeClass('hidden');
		    this_obj.find(".category_code").removeClass('hidden');
			this_obj.find(".cat_code").addClass('hidden');
		}}
		this_obj.find(".category_name").removeClass('hidden');
		this_obj.find(".cat_name").addClass('hidden');
		this_obj.find(".category_sort").removeClass('hidden');
		this_obj.find(".cat_sort").addClass('hidden');
		this_obj.find(".category_state").removeClass('hidden');
		this_obj.find(".cat_state").addClass('hidden');
		this_state = this_obj.attr('edit','1');
	});



	/**删除分类**/
	$(document).on('click','.del_category',function(e){
		//查询是否存在其他地方正在操作
	  	var this_obj = $(this).parent().parent();
	  	if(this_obj.attr('edit')==0){
		var num =$("#many_goods_category tbody tr[edit='1']").length;
		if(num != 0){
			alert('正在执行操作,不能继续添加!');
			return false;
			}
	  	}
		var this_layer = this_obj.attr('layer');
		var this_val = this_obj.attr('val');
		var this_code = this_obj.find(".cat_code").html();
		
		//0代码存在子类，1代码不存在子类
		var is_may = 1;
		//先判断是否存在子类
		if(this_layer != 3){
			$.ajax({
				type:'get',
				async: false, 
				url:'<?php echo Yii::app()->createUrl("Dutyfreegoods/Check_is_child")?>',
				data:'code='+this_code,
				success:function(msg){
					is_may = msg;
				}
			});
		}
		
		if(is_may == 1){
			var r = confirm("是否确认删除！");   
		}else{
			var r = confirm("存在子类,是否确认删除?确认删除会把子类一同删除!");  
		}

		if(r == false)	return false;

		//判断该条数据是否是数据库已经存在的数据，若不存在说明是添加行未入库数据，无需操作数据库
		if(this_val==0){
			this_obj.remove();
			return false;
		}
		var res = CheckPass();
        if(res == 0){
            alert('输入密码有误!');
            return false;
        }
		//return false;
		//数据删除
		$.post("<?php echo Yii::app()->createUrl("Dutyfreegoods/del_many_goods_category")?>",{id:this_val,code:this_code},function(data){
		    if(data != 0){
			    alert("<?php echo yii::t('vcos', '删除成功!')?>");
			    //使用页面跳转则无需使用jquery把行移除
			    location.href = "<?php echo Yii::app()->createUrl("Dutyfreegoods/many_goods_category")?>";//location.href实现客户端页面的跳转  
			    
		    }else{
				alert("<?php echo yii::t('vcos', '删除失败!')?>");
				//使用页面跳转则无需使用jquery把行移除
			    location.href = "<?php echo Yii::app()->createUrl("Dutyfreegoods/many_goods_category")?>";//location.href实现客户端页面的跳转  
			    
			}
		});
	});
		
	//点击伸展子类或收缩子类
	$(document).on('click','.show_click',function(e){
		var this_obj = $(this).parent().parent();
		var num =$("#many_goods_category tbody tr[edit='1']").length;
		if(num != 0){
			alert('正在执行操作,不能继续添加!');
			return false;
			}
		var this_code = this_obj.find('.cat_code').html();
		var this_layer = this_obj.attr('layer');
		var this_hid = $(this).attr('hid');
		//alert(this_hid);
		//判断是伸展还是收缩
		if(this_hid == 0){
			//本是收缩，需展开
			this_obj.parent().find("tr[parent='"+this_code+"']").removeClass('hidden');
			$(this).attr('hid','1');
			$(this).removeClass('hidden_child');
			$(this).addClass('show_child');
		}else if(this_hid == 1){
			//已经展开，需收缩
			this_obj.parent().find("tr[parent^='"+this_code+"']").addClass('hidden');
			if(this_layer ==1){
			//收缩时将子类或子类的子类一起收缩，并将箭头号更换为隐藏子类状态
			this_obj.parent().find("tr[parent='"+this_code+"'] .show_click").removeClass('show_child');
			this_obj.parent().find("tr[parent='"+this_code+"'] .show_click").addClass('hidden_child');
			}
			$(this).attr('hid','0');
			$(this).addClass('hidden_child');
			$(this).removeClass('show_child');
		}
	});
});

function CheckPass(){
	var c = prompt('请输入用户密码');
	var res = 0;
	if(c == null) res = 2;
	else{
	<?php $path_url = Yii::app()->createUrl('Site/CheckUserPass');?>
    $.ajax({
        url:"<?php echo $path_url;?>",
        type:'get',
        async:false,
        data:'pass='+c,
     	dataType:'json',
    	success:function(data){
    		if(data == 1){
        		//密码正确
    			res = 1;
        	}
    	}      
    });
	}
    return res;
}
</script>


