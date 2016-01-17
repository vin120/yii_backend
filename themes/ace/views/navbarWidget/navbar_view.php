<?php
    $theme_url = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript(); 
    //注册JS文件
    if(empty($disable)){
        $cs->registerScriptFile($theme_url.'/assets/js/ace-elements.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($theme_url.'/assets/js/ace.min.js', CClientScript::POS_END);
    }
    $sex = 1;//MembershipService::getMembershipSex(yii::app()->user->id)->sex;
    $user_photo = 'user.jpg';
    if(2 == $sex){
        $user_photo = 'user_f.png';
    }
?>

<div class="navbar navbar-default" id="navbar">
        <?php 
            $theme_url = Yii::app()->theme->baseUrl; 
            Yii::app()->clientScript->registerScriptFile($theme_url . "/assets/js/artDialog4.1.7/artDialog.js?skin=default", CClientScript::POS_BEGIN );
        ?>
        <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
            var iTime,jTime,kTime;
            var myartDialog;
            $(function(){
                artDialog.notice = function (options) {
                    var opt = options || {},
                    api, aConfig, hide, wrap, top,
                    duration = 800;
                    var config = {
                        left: '100%',
                        top: '100%',
                        fixed: true,
                        drag: false,
                        resize: false,
                        follow: null,
                        lock: false,
                        init: function(here){
                            api = this;
                            aConfig = api.config;
                            wrap = api.DOM.wrap;
                            top = parseInt(wrap[0].style.top);
                            hide = top + wrap[0].offsetHeight;
                            wrap.css('top', hide + 'px')
                                .animate({top: top + 'px'}, duration, function () {
                                    opt.init && opt.init.call(api, here);
                                });
                        },
                        close: function(here){
                            wrap.animate({top: hide + 'px'}, duration, function () {
                                opt.close && opt.close.call(this, here);
                                aConfig.close = $.noop;
                                api.close();
                            });

                            return false;
                        }
                    };	
                    for (var i in opt) {
                        if (config[i] === undefined) config[i] = opt[i];
                    };
                    return artDialog(config);
                };
                <?php if(in_array('126',$auth) || $auth[0] == '0'){?>
                iTime=setTimeout('getchecklsbooking()',60000);
                <?php } ?>
                <?php if(in_array('129',$auth) || $auth[0] == '0'){?>
                iTime=setTimeout('getcheckgoodsorder()',50000);
                <?php } ?>
            });
            <?php if(in_array('126',$auth) || $auth[0] == '0'){?>
            function getchecklsbooking(){
                clearTimeout(iTime);
                $.post("checklsbooking", {},function(data) {  
                    if(data > 0){
                        if("undefined" != typeof art.dialog.list['individualOrders']){
                            art.dialog.list['individualOrders'].close();    
                        }
                        getcheckpreferential('preferential','<?php echo Yii::t('vcos','新的预定');?>','<a href="<?php echo Yii::app()->createUrl('Lifeservice/service_booking_list');?>"><?php echo Yii::t('vcos','有新的休闲服务预定');?></a>');
                    }else{
                        if("undefined" != typeof art.dialog.list['preferential']){
                            art.dialog.list['preferential'].close();    
                        }
                    }
                },'json');
                iTime=setTimeout('getchecklsbooking()',60000);
            }
            <?php }?>
            <?php if(in_array('129',$auth) || $auth[0] == '0'){?>
            function getcheckgoodsorder(){
                clearTimeout(iTime);
                $.post("checkgoodsorder", {},function(data) {  
                    if(data > 0){
                        if("undefined" != typeof art.dialog.list['individualOrders']){
                            art.dialog.list['individualOrders'].close();    
                        }
                        getcheckpreferential('preferential','<?php echo Yii::t('vcos','新的订单');?>','<a href="<?php echo Yii::app()->createUrl('Dutyfreegoods/goods_order_list');?>"><?php echo Yii::t('vcos','有新的免税商城订单');?></a>');
                    }else{
                        if("undefined" != typeof art.dialog.list['preferential']){
                            art.dialog.list['preferential'].close();    
                        }
                    }
                },'json');
                iTime=setTimeout('getcheckgoodsorder()',50000);
            }
            <?php }?>
            function getcheckpreferential(id,title,content){              
                myartDialog = art.dialog.notice({
                    id: id,
                    title: title,
                    width: 180,// 必须指定一个像素宽度值或者百分比，否则浏览器窗口改变可能导致artDialog收缩
                    content: content,
                    icon: 'face-smile'
                });
            }
            
        </script>

        <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                        <a href="#" class="navbar-brand">
                                <small>
                                    <i class="icon-flag"></i>
                                        <?php echo Yii::t('vcos','毕升邮轮管理系统');?>
                                </small>
                        </a><!-- /.brand -->
                </div><!-- /.navbar-header -->

                <div class="navbar-header pull-right" role="navigation">
                        <ul class="nav ace-nav">
                                <li class="light-blue">
                                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                                <img class="nav-user-photo" src="<?php echo $theme_url; ?>/assets/avatars/<?php echo $user_photo; ?>" alt="<?php echo yii::app()->user->name; ?> Photo" />
                                                <span class="user-info">
                                                        <small><?php echo Yii::t('vcos','欢迎您');?>,</small>
                                                        <?php echo yii::app()->user->name; ?>
                                                </span>

                                                <i class="icon-caret-down"></i>
                                        </a>

                                        <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                                <li>
                                                        <a href="<?php echo Yii::app()->createUrl('site/logout');?>">
                                                                <i class="icon-off"></i>
                                                                <?php echo Yii::t('vcos','注销');?>
                                                        </a>
                                                </li>
                                                <li>
                                                        <a href="<?php echo Yii::app()->createUrl('auth/password_edit');?>">
                                                                <i class="icon-off"></i>
                                                                <?php echo Yii::t('vcos','修改密码');?>
                                                        </a>
                                                </li>
                                        </ul>
                                </li>
                        </ul><!-- /.ace-nav -->
                </div><!-- /.navbar-header -->
        </div><!-- /.container -->
</div>