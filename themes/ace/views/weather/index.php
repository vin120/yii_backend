<?php
    $this->pageTitle = Yii::t('vcos','天气预告列表');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'report_list';
?>
<?php 
    //navbar 挂件
    $this->widget('navbarWidget');
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
                                <?php echo yii::t('vcos', '天气管理')?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', '天气预告列表')?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->
                            <div class="row">
                                <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                        <style>
                                        .list_select_option{margin-bottom:10px;}
                                        .city_sel{margin-left:20px;width:250px;}
                                        </style>
                                            <div class="table-responsive">
                                            <div class="list_select_option">
                                                  <label><?php echo yii::t('vcos', '请选择国家')?>:</label>
                                                  <select class='city_sel' name='country_all_sel'>
                                                  <?php
                                                   $path_url_first = Yii::app()->createUrl('Weather/Report_list',array('country'=> 0,'res'=>$res));
                                                  ?>
                                                    <option value="<?php echo $path_url_first;?>" <?php if($country_but == 0){echo 'selected';}?>><?php echo yii::t('vcos', '全部')?></option>
                                                  <?php
                                                  if($country_sel != ''){
                                                  foreach($country_sel as $row){
                                                    $path_url = Yii::app()->createUrl('Weather/Report_list',array('country'=> $row['country_id'],'res'=>$res));
                                                  ?>
                                                    <option value="<?php echo $path_url;?>" <?php if($row['country_id'] == $country_but){echo 'selected';}?>><?php echo $row['country_name']?></option>
                                                  <?php }}?>
                                                  </select>
                                                  
                                                  <label><?php echo yii::t('vcos', '请选择城市')?>:</label>
                                                  <select class='city_sel' name='city_all_sel'>
                                                  <?php
                                                  $path_life_url_first = Yii::app()->createUrl('Weather/Report_list',array('country'=>$country_but,'city'=>0,'res'=>$res));
                                                  ?>
                                                    <option value="<?php echo $path_life_url_first;?>" <?php if($city_but == 0){echo 'selected';}?>><?php echo yii::t('vcos', '全部')?></option>
                                                    <?php
                                                    if($city_sel != ''){
                                                    foreach($city_sel as $str){
                                                    $path_life_url = Yii::app()->createUrl('Weather/Report_list',array('country'=>$country_but,'city'=> $str['city_id'],'res'=>$res));
                                                  ?>
                                                    <option value="<?php echo $path_life_url;?>" <?php if($str['city_id'] == $city_but){echo 'selected';}?>><?php echo $str['city_name']?></option>
                                                  <?php }}?>
                                                  </select>
                                                  
                                                 <label><?php echo yii::t('vcos', '请选择语言')?>:</label>
                                                  <select class='city_sel' name='lang_all_sel'>
                                                  <?php $path_url_all = Yii::app()->createUrl('Weather/Report_list',array('res'=> 'all','country'=>$country_but,'city'=>$city_but));?>
                                                    <option value="<?php echo $path_url_all;?>" <?php if($res == 'all'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '全部')?></option>
                                                  <?php $path_url_zh = Yii::app()->createUrl('Weather/Report_list',array('res'=> 'zh_cn','country'=>$country_but,'city'=>$city_but));?>
                                                    <option value="<?php echo $path_url_zh;?>" <?php if($res == 'zh_cn'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '中文')?></option>
                                                  <?php $path_url_en = Yii::app()->createUrl('Weather/Report_list',array('res'=> 'en','country'=>$country_but,'city'=>$city_but));?>
                                                    <option value="<?php echo $path_url_en;?>" <?php if($res == 'en'){echo "selected='selected'";}?>><?php echo yii::t('vcos', '英文')?></option>
                                                  </select>
                                                </div>
                                                <form method="post" name="weather" action="">
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
                                                            <th><?php echo yii::t('vcos', '城市')?></th>
                                                            <th><?php echo yii::t('vcos', '天气预告')?></th>
                                                            <th><?php echo yii::t('vcos', '开始显示时间')?></th>
                                                            <th><?php echo yii::t('vcos', '结束显示时间')?></th>
                                                            <th><?php echo yii::t('vcos', '风向')?></th>
                                                            <th><?php echo yii::t('vcos', '风速')?></th>
                                                            <th><?php echo yii::t('vcos', '最低温度')?></th>
                                                            <th><?php echo yii::t('vcos', '最高温度')?></th>
                                                            <th><?php echo yii::t('vcos', '操作')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($record as $key=>$row) { ?>
                                                        <tr>
                                                            <td class="center">
                                                                <label>
                                                                    <input type="checkbox" name="ids[]" value="<?php echo $row['record_id'];?>" class="ace isclick" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </td>
                                                            <td><?php echo ++$key;?></td>
                                                            <td><?php echo $row['city_name']?></td>
                                                            <td><?php echo $row['weather_name']?></td>
                                                            <td><?php echo $row['record_start_time'];?></td>
                                                            <td><?php echo $row['record_end_time'];?></td>
                                                            <td><?php echo $row['wind_direction']?></td>
                                                            <td><?php echo $row['wind_scale']?></td>
                                                            <td><?php echo $row['record_temperature_min'];?></td>
                                                            <td><?php echo $row['record_temperature_max'];?></td>
                                                            <td>
                                                                <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                    <a href="<?php echo Yii::app()->createUrl("Weather/Report_edit?id={$row['record_id']}");?>" class="btn btn-xs btn-info" title="<?php echo yii::t('vcos', '编辑');?>">
                                                                        <i class="icon-edit bigger-120"></i>
                                                                    </a>
                                                                    <?php if(in_array('106', $auth) || $auth[0] == '0'){?>
                                                                    <a href="#" id="<?php echo $row['record_id'];?>" class="delete btn btn-xs btn-warning" title="<?php echo yii::t('vcos', '删除');?>">
                                                                        <i class="icon-trash bigger-120"></i>
                                                                    </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                    <div class="inline position-relative">
                                                                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="icon-cog icon-only bigger-110"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                                            <li>
                                                                                <a href="<?php echo Yii::app()->createUrl("Weather/Report_edit?id={$row['record_id']}");?>" class="tooltip-info" data-rel="tooltip" title="<?php echo yii::t('vcos', '编辑');?>">
                                                                                    <span class="green">
                                                                                        <i class="icon-edit bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                            <?php if(in_array('106', $auth) || $auth[0] == '0'){?>
                                                                            <li>
                                                                                <a href="#" id="<?php echo $row['record_id'];?>" class="delete tooltip-info" data-rel="tooltip" title="<?php echo yii::t('vcos', '删除');?>">
                                                                                    <span class="red">
                                                                                        <i class="icon-trash bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                                </form>
                                                <div class="center">
                                                    <?php if(in_array('106', $auth) || $auth[0] == '0'){?>
                                                    <button class="btn btn-xs btn-warning" id="submit">
                                                        <i class="icon-trash bigger-125"></i>
                                                        <span class="bigger-110 no-text-shadow"><?php echo yii::t('vcos', '删除选中')?></span>
                                                    </button>
                                                    <?php } ?>
                                                    <a href="<?php echo Yii::app()->createUrl('Weather/Report_post');?>" class="btn btn-xs">
                                                        <i class="icon-pencil align-top bigger-125"></i>
                                                        <span class="bigger-110 no-text-shadow"><?php echo yii::t('vcos', '添加')?></span>
                                                    </a>
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
                <div id="dialog-confirm" class="hide">
                    <div class="alert alert-info bigger-110">
                        <?php echo yii::t('vcos', '这条记录将被永久删除，并且无法恢复.')?>
                    </div>
                    <div class="space-6"></div>
                    <p class="bigger-110 bolder center grey">
                        <i class="icon-hand-right blue bigger-120"></i>
                        <?php echo yii::t('vcos', '确定吗?')?>
                    </p>
                </div><!-- #dialog-confirm -->
                <div id="dialog-confirm-multi" class="hide">
                    <div class="alert alert-info bigger-110" id="isempty1">
                        <?php echo yii::t('vcos', '这些选中的记录将被永久删除，并且无法恢复.')?>
                    </div>
                    <div class="space-6"></div>
                    <p class="bigger-110 bolder center grey" id="isempty2">
                        <i class="icon-hand-right blue bigger-120"></i>
                        <?php echo yii::t('vcos', '确定吗?')?>
                    </p>
                </div><!-- #dialog-confirm -->
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
                        location.href="<?php echo Yii::app()->createUrl("Weather/Report_list");?>"+"?id="+$a;
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
                    "id" :"danger2",
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
                        $('#danger2').show();
                        $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '删除选中的记录！')?>");
                        $('#isempty1').html("<?php echo yii::t('vcos', '这些选中的记录将被永久删除，并且无法恢复。')?>");
                        $('#isempty2').show();
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
        if(!$('.isclick').is(':checked')){
            $('#danger2').hide();
            $('.widget-header h4').html("<i class='icon-warning-sign red'></i><?php echo yii::t('vcos', '没有选中！')?>");
            $('#isempty1').html("<?php echo yii::t('vcos', '请选择删除项。')?>");
            $('#isempty2').hide();
        }
    }); 

    $(".list_select_option select[name='country_all_sel']").change(function(){
        var path = $(this).val();
        window.location.href=path;
    });
    
    $(".list_select_option select[name='city_all_sel']").change(function(){
        var path = $(this).val();
        window.location.href=path;
    }); 
    $(".list_select_option select[name='lang_all_sel']").change(function(){
        var path = $(this).val();
        window.location.href=path;
    });
});
</script>
