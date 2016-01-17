<?php
    $this->pageTitle = Yii::t('vcos','添加权限分组');
    $theme_url = Yii::app()->theme->baseUrl;
    
    $menu_type = 'role_add';
?>
<?php 
    //navbar 挂件
    $disable = 1;
    $this->widget('navbarWidget',array('disable'=>$disable));
?>
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace.css" />
<!DOCTYPE html>
<div class="main-container">
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
                        <?php echo yii::t('vcos', '权限管理')?>
                        <small>
                            <i class="icon-double-angle-right"></i>
                            <?php echo yii::t('vcos', '添加权限分组')?>
                        </small>
                    </h1>
                </div><!-- /.page-header -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-11">
                        <form class="form-horizontal" role="form" method="post" action="" id="add">
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分组名')?>：</label>
                            <div class="col-xs-8 col-sm-8 col-md-7">
                                <input type="text" id="role" placeholder="<?php echo yii::t('vcos', '分组名')?>" class="col-xs-10 col-sm-8 col-md-8" name="role" maxlength="80" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '状态')?>：</label>
                            <label style="margin-left: 10px;">
                                <input id="id-button-borders" type="checkbox" checked="checked" class="ace ace-switch ace-switch-5" name="state" value="1" />
                                <span class="lbl"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分组说明')?>：</label>
                            <div class="col-xs-8 col-sm-8 col-md-7">
                                <input class="col-xs-10 col-sm-8 col-md-8" id="describe" type="text" maxlength='80' name="describe" placeholder="<?php echo yii::t('vcos', '分组说明')?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 col-sm-2 col-md-2 control-label no-padding-right"><?php echo yii::t('vcos', '分配权限')?>：</label>
                            <div class="widget-box transparent col-xs-8 col-sm-8 col-md-8">
                                <div class="widget-body">
                                    <div class="widget-main padding-8">
                                        <div id="treeview" class="tree"></div>
                                        <div class="hr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" id="hidden" name="hidden" />
                        <input type="submit" value="<?php echo yii::t('vcos', '提交')?>" id="submit" class="btn btn-primary" style="margin-left: 45%"/>      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- basic scripts -->
<!--[if !IE]> -->
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery.js'>"+"<"+"/script>");
</script>
<!-- <![endif]-->
<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery-1.10.2.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script src="<?php echo $theme_url; ?>/assets/js/bootstrap.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/uncompressed/additional-methods.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/fuelux/fuelux.tree.js"></script>
<!-- ace scripts -->
<script src="<?php echo $theme_url; ?>/assets/js/ace-elements.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/ace.js"></script>
		
<script type="text/javascript">
$(function() {
    var remoteUrl = 'menu_permission';
    var remoteDateSource = function(options, callback) {
        var parent_id = null
        if( !('text' in options || 'type' in options) ){
            parent_id = 0;//load first level data
        }
        else if('type' in options && options['type'] == 'folder') {//it has children
            if('additionalParameters' in options && 'children' in options.additionalParameters)
                parent_id = options.additionalParameters['id']
        }

        if(parent_id !== null) {
            $.ajax({
                url: remoteUrl,
                data: 'id='+parent_id,
                type: 'POST',
                dataType: 'json',
                success : function(response) {
                    if(response.status == "OK"){
                        callback({ data: response.data });
                        <?php foreach($permission_click as $row){?>
                        $('#treeview').children().eq(<?php echo $row['parent_eq']?>).children().eq(1).children().eq(<?php echo $row['click']?>).click(function(){
                            $('#treeview').children().eq(<?php echo $row['parent_eq']?>).children().eq(1).children().eq(<?php echo $row['chose']?>).addClass("tree-selected");
                            $('#treeview').children().eq(<?php echo $row['parent_eq']?>).children().eq(1).children().eq(<?php echo $row['chose']?>).children().children().eq(0).removeClass("fa-times").addClass("fa-check");
                        });
                        <?php } ?>
                    }
                },
                error: function(response) {
                        //console.log(response);
                }
            })
        }
    }
    $('#treeview').ace_tree({
        dataSource: remoteDateSource ,
        multiSelect: true,
        loadingHTML: '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
        'open-icon' : 'ace-icon tree-minus',
        'close-icon' : 'ace-icon tree-plus',
        'selectable' : true,
        'selected-icon' : 'ace-icon fa fa-check',
        'unselected-icon' : 'ace-icon fa fa-times',
        cacheItems: true,
        folderSelect: false,
    });
    //show selected items inside a modal
    $('#submit').on('click', function() {
        var output = '';
        var show = '';
        var items = $('#treeview').tree('selectedItems');
        for(var i in items) if (items.hasOwnProperty(i)) {
            var item = items[i];
            output += item.additionalParameters['id'] + ",";
            show += item.additionalParameters['id'] + ":"+ item.text+"\n";
        }
        $('#hidden').val(output);
        $('#modal-tree-items').modal('show');
        $('#tree-value').css({'width':'98%', 'height':'200px'}).val(show);
    });
    if(location.protocol == 'file:') alert("For retrieving data from server, you should access this page using a webserver.");
    
    $("#add").validate({
        ignore: "",
        rules: {
            role: {
                required:true,
                stringCheckAll:true,
                remote: {
                    url: "checkroleajax", 
                    type: "post",
                    dataType: "json", 
                    data: {
                        role: function() {
                            return $("#role").val()+'|'+$("#role_id").val();
                        }
                    }
                }
            },
            describe: {required:true,stringCheckAll:true},
            hidden: "required"
        },
        messages:{
            role:{
                required:"<?php echo yii::t('vcos', '请输入分组名')?>",
                remote:"<?php echo yii::t('vcos', '此分组名已被使用')?>"
            },
            describe:"<?php echo yii::t('vcos', '请正确输入分组描述')?>",
            hidden:"<?php echo yii::t('vcos', '请分配权限')?>"
        }
    });
});
</script>