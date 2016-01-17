<?php
    $this->pageTitle = Yii::t('vcos','商品列表');
    $theme_url = Yii::app()->theme->baseUrl;
    $menu_type = 'product_list';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
    if(in_array('295', $auth) || $auth[0] == '0'){
        $canadd = TRUE;
    }  else {
        $canadd = False;
    }
    if(in_array('296', $auth) || $auth[0] == '0'){
        $canedit = TRUE;
    }  else {
        $canedit = False;
    }
    if(in_array('297', $auth) || $auth[0] == '0'){
        $candelete = TRUE;
    }  else {
        $candelete = FALSE;
    }
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
                                <?php echo yii::t('vcos', '商品管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '商品列表')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                            	<style>
			                                        .list_select_option{margin-bottom:10px;}
			                                        .city_sel{margin-left:5px;width:150px;}
		                                        </style>
                                            	<div class="list_select_option">
                                             	  <label><?php echo yii::t('vcos', '请选择分类')?>:</label>
                                             	  <select class='city_sel' name='cat1_all_sel'>
                                             	  <?php
                                             	  foreach($cat1_sel as $row){
                                             	  ?>
                                             	  	<option value="<?php echo $row['category_code'];?>" <?php if($row['category_code'] == $cat1_but){echo 'selected';}?>><?php echo $row['name']?></option>
                                             	  <?php }?>
                                             	  </select>
                                             	  <select class='city_sel' name='cat2_all_sel'>
                                             	  <?php
                                             	  foreach($cat2_sel as $row){
                                             	  ?>
                                             	  	<option value="<?php echo $row['category_code'];?>" <?php if($row['category_code'] == $cat2_but){echo 'selected';}?>><?php echo $row['name']?></option>
                                             	  <?php }?>
                                             	  </select>
                                             	  <select class='city_sel' name='cat2_all_sel'>
                                             	  <?php
                                             	  foreach($cat3_sel as $row){
                                             	  ?>
                                             	  	<option value="<?php echo $row['category_code'];?>" <?php if($row['category_code'] == $cat3_but){echo 'selected';}?>><?php echo $row['name']?></option>
                                             	  <?php }?>
                                             	  </select>
                                             	  
                                             	</div>
                                                <form method="post" action="">
                                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">
                                                                <label>
                                                                    <input type="checkbox" class="ace" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </th>
                                                            <th><?php echo yii::t('vcos', '序号')?></th>
                                                            <th><?php echo yii::t('vcos', '商品店铺')?></th>
                                                            <th><?php echo yii::t('vcos', '商品品牌')?></th>
                                                            <th><?php echo yii::t('vcos', '商品分类')?></th>
                                                            <th><?php echo yii::t('vcos', '商品编码')?></th>
                                                            <th><?php echo yii::t('vcos', '商品名')?></th>
                                                            <th><?php echo yii::t('vcos', '产地')?></th>
                                                            <th><?php echo yii::t('vcos', '商品描述')?></th>
                                                            <th><?php echo yii::t('vcos', '商品图片')?></th>
                                                            <th><?php echo yii::t('vcos', '状态')?></th>
                                                            <th><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($product as $key=>$row) { ?>
                                                        <tr>
                                                            <td class="center">
                                                                <label>
                                                                    <input type="checkbox" name="ids[]" value="<?php echo $row['product_id'];?>" class="ace isclick" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </td>
                                                            <td><?php echo ++$key;?></td>
                                                            <td><?php if($row['shop_title']==''){echo '自营产品';}else{echo $row['shop_title'];}?></td>
                                                            <td><?php echo $row['brand_cn_name'];?></td>
                                                            <td><?php echo $row['name'];?></td>
                                                            <td><?php echo $row['product_code'];?></td>
                                                            <td><?php echo $row['product_name'];?></td>
                                                            <td><?php echo $row['origin'];?></td>
                                                            <td><?php echo Helper::truncate_utf8_string($row['product_desc'], 20);?></td>
                                                            <td><img src="<?php echo Yii::app()->params['imgurl'].$row['product_img'];?>" width="50" height="50"></td>
                                                            <td><?php echo $row['status']?yii::t('vcos', '启用'):yii::t('vcos', '禁用');?></td>
                                                            <td>
                                                                <?php
                                                                    $this->widget('ManipulateWidget',array(
                                                                        'ControllerName'=>'Product',
                                                                        'MethodName'=>'product_edit',
                                                                        'id'=>$row['product_id'],
                                                                        'canedit'=>$canedit,
                                                                        'candelete'=>$candelete,
                                                                    ));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                                </form>
                                                <div class="center">
                                                    <?php
                                                        //底部操作挂件
                                                        $this->widget('BotWidget',array(
                                                            'ControllerName'=>'Product',
                                                            'MethodName'=>'product_add',
                                                            'canadd'=>$canadd,
                                                            'candelete'=>$candelete,
                                                        ));
                                                    ?>
                                                </div>
                                                <div class="center">
                                                    <?php
                                                    $this->widget('MyCLinkPager',array(
                                                        'pages'=>$pages,
                                                        'header'=>false,
                                                        'htmlOptions'=>array('class'=>'pagination'),
                                                        'firstPageLabel'=>yii::t('vcos', '首页'),
                                                        'lastPageLabel'=>yii::t('vcos', '尾页'),
                                                        'prevPageLabel'=>'«',
                                                        'nextPageLabel'=>'»',
                                                        'maxButtonCount'=>5,
                                                        'cssFile'=>false,
                                                        ));
                                                    ?>
                                                </div>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /span -->
                                    </div><!-- /row -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.page-content -->
                </div><!-- /.main-content -->
                <?php
                    //删除确认框
                    $this->widget('ConfirmWidget',array(
                        'div_id'=>'dialog-confirm',
                        'title_content'=>yii::t('vcos', '这条记录将被永久删除，并且无法恢复。'),
                    ));
                ?>
                <?php
                    //批量删除确认框
                    $this->widget('ConfirmWidget',array(
                        'div_id'=>'dialog-confirm-multi',
                        'title_id'=>'isempty1',
                        'title_content'=>yii::t('vcos', '这些选中的记录将被永久删除，并且无法恢复。'),
                        'confirm_id'=>'isempty2',
                    ));
                ?>
                <!-- /#ace-settings-container start-->
                <?php
                    //设置容器配置挂件
                    $this->widget('settingsContainerWidget');
                ?>
                <!-- /#ace-settings-container end-->
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
<script src="<?php echo $theme_url; ?>/assets/js/jquery-ui-1.10.3.full.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function(){
                this.checked = that.checked;
                $(this).closest('tr').toggleClass('selected');
            });
        });
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function(title) {
            var $title = this.options.title || '&nbsp;'
            if( ("title_html" in this.options) && this.options.title_html == true )
                title.html($title);
            else title.text($title);
            }
        }));
        $( ".delete" ).on('click', function(e) {
            var $a = $(this).attr("id");
            e.preventDefault();
            $( "#dialog-confirm" ).removeClass('hide').dialog({
                resizable: false,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?></h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-trash bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '删除？')?>",
                        "class" : "btn btn-danger btn-xs ",
                        click: function() {
                        	var res = CheckPass();
                            if(res == 1){
                            location.href="<?php echo Yii::app()->createUrl("Product/product_list");?>"+"?id="+$a;
                            }else if(res == 0){
                                alert('输入密码有误!');
                            }
                            $( this ).dialog( "close" );
                        }
                    }
                    ,
                    {
                        html: "<i class='icon-remove bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '取消？')?>",
                        "class" : "btn btn-xs ",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ]
            });
        }); 
         
        $( "#submit" ).on('click', function(e) {
            e.preventDefault();
            $( "#dialog-confirm-multi").removeClass('hide').dialog({
                closeOnEscape:false, 
                open:function(event,ui){$(".ui-dialog-titlebar-close").hide();} ,
                resizable: false,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除选中的记录？')?></h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-trash bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '删除？')?>",
                        "class" : "btn btn-danger btn-xs ",
                        "id" :"danger",
                        click: function() {
                        	var res = CheckPass();
                            if(res == 1){
                            	$("form:first").submit();
                            }else if(res == 0){
                                alert('输入密码有误!');
                            }
                            //$("form:first").submit();
                            $( this ).dialog( "close" );
                        }
                    }
                    ,
                    {
                        html: "<i class='icon-remove bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '取消？')?>",
                        "class" : "btn btn-xs ",
                        click: function() {
                            $('#danger').show();
                            $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除选中的记录！')?>");
                            $('#isempty1').html("<?php echo yii::t('vcos', '这些选中的记录将被永久删除，及关联的其它记录，并且无法恢复。')?>");
                            $('#isempty2').show();
                            $( this ).dialog( "close" );
                        }
                    }
                ]
            });
            if(!$('.isclick').is(':checked')){
                $('#danger').hide();
                $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '没有选中！')?>");
                $('#isempty1').html("<?php echo yii::t('vcos', '请选择删除项。')?>");
                $('#isempty2').hide();
            }
        }); 


        /**分类筛选:一级**/
        $("select[name='cat1_all_sel']").change(function(){
            var this_code = $(this).val();
            var str = '';
            var str_ch = '';
            var str_pr = '';
            <?php $path_url = Yii::app()->createUrl('Product/GetCategoryChild');?>
            
            $.ajax({
                url:"<?php echo $path_url;?>",
                type:'get',
                data:'parent_code='+this_code,
             	dataType:'json',
            	success:function(data){
            		$.each(data,function(key){  
                       str += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                    });
            		$("select[name='cat2_all_sel']").html(str);
            		$.ajax({
                        url:"<?php echo $path_url;?>",
                        type:'get',
                        data:'parent_code='+data[0]['category_code'],
                     	dataType:'json',
                    	success:function(data){
                    		$.each(data,function(key){  
                               str_ch += "<option value="+data[key]['category_code']+">"+data[key]['name']+"</option>"; 
                            });
                    		$("select[name='cat3_all_sel']").html(str_ch);
                    		//var code = data[0]['category_code'];
                    		//<php $path_url_link = Yii::app()->createUrl('Product/product_list');?>
                    		//window.location.href="<php echo $path_url_link;?>";
                    	}        
                 });
            	}        
            });
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
