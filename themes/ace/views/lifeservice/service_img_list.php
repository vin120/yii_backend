<?php
    $this->pageTitle = Yii::t('vcos','休闲服务图片列表');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'service_img_list';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
    if(in_array('165', $auth) || $auth[0] == '0'){
        $canadd = TRUE;
    }  else {
        $canadd = False;
    }
    if(in_array('167', $auth) || $auth[0] == '0'){
        $canedit = TRUE;
    }  else {
        $canedit = False;
    }
    if(in_array('169', $auth) || $auth[0] == '0'){
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
                                <?php echo yii::t('vcos', '休闲服务管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '休闲服务图片列表')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                        <style>
                                        .list_select_option{margin-bottom:10px;}
                                        .lifeservice_sel{margin-left:20px;width:250px;}
                                        </style>
                                            <div class="table-responsive">
                                            <div class="list_select_option">
                                             	  <label><?php echo yii::t('vcos', '请选择服务分类')?>:</label>
                                             	  <select class='lifeservice_sel' name='lifeservice_all_sel'>
                                             	  <?php
                                             	   $path_url_first = Yii::app()->createUrl('Lifeservice/service_img_list',array('lifeservice'=> 0,'res'=>$res));
                                             	  ?>
                                             	  	<option value="<?php echo $path_url_first;?>" <?php if($res_but == 0){echo 'selected';}?>><?php echo yii::t('vcos', '全部')?></option>
                                             	  <?php foreach($lifeservice_sel as $row){
                                             	  	$path_url = Yii::app()->createUrl('Lifeservice/service_img_list',array('lifeservice'=> $row['lc_id'],'res'=>$res));
                                             	  ?>
                                             	  	<option value="<?php echo $path_url;?>" <?php if($row['lc_id'] == $res_but){echo 'selected';}?>><?php echo $row['lc_name']?></option>
                                             	  <?php }?>
                                             	  </select>
                                             	  <label><?php echo yii::t('vcos', '请选择服务')?>:</label>
                                             	  <select class='lifeservice_sel' name='life_all_sel'>
                                             	  <?php
                                             	   $path_url_first = Yii::app()->createUrl('Lifeservice/service_img_list',array('lifeservice'=> $res_but,'res'=>$res,'life'=>0));
                                             	  ?>
                                             	  	<option value="<?php echo $path_url_first;?>" <?php if($life_but == 0){echo 'selected';}?>><?php echo yii::t('vcos', '全部')?></option>
                                             	  <?php if($life_sel != ''){
                                             	  	foreach($life_sel as $row){
                                             	  		$path_url = Yii::app()->createUrl('Lifeservice/service_img_list',array('lifeservice'=> $res_but,'res'=>$res,'life'=>$row['ls_id']));
                                             	  ?>
                                             	  <option value="<?php echo $path_url;?>" <?php if($row['ls_id'] == $life_but){echo 'selected';}?>><?php echo $row['ls_title']?></option>
                                             	  <?php }}?>
                                             	  </select>
                                             	  
                                             	  <label><?php echo yii::t('vcos', '请选择语言')?>:</label>
                                             	  <select class='lifeservice_sel' name='lang_all_sel'>
                                             	  <?php $path_url_all = Yii::app()->createUrl('Lifeservice/service_img_list',array('res'=> 'all','lifeservice'=>$res_but,'life'=>$life_but));?>
                                             	  	<option value="<?php echo $path_url_all;?>" <?php if($res == 'all'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '全部')?></option>
                                             	  <?php $path_url_zh = Yii::app()->createUrl('Lifeservice/service_img_list',array('res'=> 'zh_cn','lifeservice'=>$res_but,'life'=>$life_but));?>
                                             	  	<option value="<?php echo $path_url_zh;?>" <?php if($res == 'zh_cn'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '中文')?></option>
                                             	  <?php $path_url_en = Yii::app()->createUrl('Lifeservice/service_img_list',array('res'=> 'en','lifeservice'=>$res_but,'life'=>$life_but));?>
                                             	  	<option value="<?php echo $path_url_en;?>" <?php if($res == 'en'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '英文')?></option>
                                             	  </select>
                                             	 
                                             	</div>
                                                <form method="post" name="cp">
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
                                                            <th><?php echo yii::t('vcos', '分类名')?></th>
                                                            <th><?php echo yii::t('vcos', '标题')?></th>
                                                            <th><?php echo yii::t('vcos', '图片')?></th>
                                                            <th><?php echo yii::t('vcos', '状态')?></th>
                                                            <th><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	 
                                                        <?php foreach ($lifeservice as $key=>$row) { ?>
                                                        <tr>
                                                            <td class="center">
                                                                <label>
                                                                    <input type="checkbox" name="ids[]" value="<?php echo $row['id'];?>" class="ace isclick" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </td>
                                                            <td><?php echo ++$key;?></td>
                                                            <td><?php echo $row['lc_name'];?></td>
                                                            <td><?php echo $row['ls_title'];?></td>
                                                            <td><img src="<?php echo Yii::app()->params['imgurl'].$row['img_url'];?>" width="50"/></td>
                                                            <td><?php echo $row['state']?yii::t('vcos', '启用'): yii::t('vcos', '禁用');?></td>
                                                            <td>
                                                                <?php
                                                                    //操作挂件
                                                                    $this->widget('ManipulateWidget',array(
                                                                        'ControllerName'=>'Lifeservice',
                                                                        'MethodName'=>'service_img_edit',
                                                                        'id'=>$row['id'],
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
                                                            'ControllerName'=>'Lifeservice',
                                                            'MethodName'=>'service_img_add',
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
            closeOnEscape:false, 
            open:function(event,ui){$(".ui-dialog-titlebar-close").hide();} ,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除这条记录？')?></h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; <?php echo yii::t('vcos', '删除？')?>",
                    "class" : "btn btn-danger btn-xs ",
                    click: function() {
                        location.href="<?php echo Yii::app()->createUrl("Lifeservice/service_img_list");?>"+"?id="+$a;
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
                        $("form:first").submit();
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
                        $('#isempty1').html("<?php echo yii::t('vcos', '这些选中的记录将被永久删除，并且无法恢复。')?>");
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
	
    
    
    $(".list_select_option select[name='lifeservice_all_sel']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});

    $(".list_select_option select[name='life_all_sel']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});
    
    $(".list_select_option select[name='lang_all_sel']").change(function(){
    	var path = $(this).val();
		window.location.href=path;
	});

	
   
});
</script>

