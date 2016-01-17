<!DOCTYPE html>
<html>
    <head>
        <?php
            $theme_url = Yii::app()->theme->baseUrl;
        ?>
        <meta charset="utf-8" />
        <title><?php echo Yii::t('vcos', '毕升邮轮管理系统'); ?></title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- basic styles -->

        <link href="<?php echo $theme_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

        <!-- fonts -->

        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-fonts.css" />

        <!-- ace styles -->

        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-rtl.min.css" />
        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo $theme_url; ?>/assets/js/html5shiv.js"></script>
        <script src="<?php echo $theme_url; ?>/assets/js/respond.min.js"></script>
        <![endif]-->
        <style>
            .lang *{display: block; height: 100%; line-height: 100%; float: right}
        </style>
    </head>
    <body class="login-layout" style="background-size:cover;background:url('<?php echo $theme_url; ?>/assets/myimages/skin/login_background_1.jpg') repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)">
        <div class="main-container" style="margin-top:25px;">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h2>
                                    <span class="black"><?php echo Yii::t('vcos', '毕升邮轮管理系统'); ?></span>
                                </h2>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="lang">
                                                <a href="<?php echo Yii::app()->createUrl('login/login', array('lang'=>'en')); ?>">En</a>
                                                    <label>&nbsp;|&nbsp;</label>
                                                <a href="<?php echo Yii::app()->createUrl('login/login', array('lang'=>'zh_cn')); ?>">中文</a>
                                            </div>
                                            <h4 class="header blue lighter bigger" style="margin-top: 9%">
                                                <i class="icon-coffee blue"></i>
                                                <?php echo Yii::t('login', '请输入你的用户名密码'); ?>
                                            </h4>
                                            <?php
                                                if (isset($login_state))
                                                {
                                                    echo '<p for="login_error" class="login-error red">' . Yii::t('login', '用户名或密码错误,请到前台激活修改!') . '</p>';
                                                }
                                            ?>                                                                              
                                            <div class="form" id="validation-form">
                                                <?php
                                                    $form = $this->beginWidget('CActiveForm', array(
                                                        'id' => 'login-form',
                                                        //'enableClientValidation' => true,
                                                        'clientOptions' => array(
                                                            'validateOnSubmit' => true,
                                                        ),
                                                    ));
                                                ?>
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" name="username" class="form-control" placeholder="<?php echo $model->getAttributeLabel('username'); ?>" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" name="password" class="form-control" placeholder="<?php echo $model->getAttributeLabel('password'); ?>" />
                                                                <i class="icon-lock"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" name="rememberMe" class="ace" />
                                                            <span class="lbl"><?php echo $model->getAttributeLabel('rememberMe'); ?></span>
                                                        </label>

                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="icon-key"></i>
                                                            <?php echo Yii::t('login', '登录'); ?>
                                                        </button>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                                <?php $this->endWidget(); ?>
                                            </div>

                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /login-box -->
                            </div><!-- /position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='<?php echo $theme_url; ?>/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <!-- page specific plugin scripts -->

        <script src="<?php echo $theme_url; ?>/assets/js/jquery.validate.min.js"></script>


        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            jQuery(function ($) {

                $('#login-form').validate({
                    errorElement: 'div',
                    errorClass: 'help-block',
                    focusInvalid: false,
                    rules: {
                        username: {
                            required: true
                        },
                        password: {
                            required: true,
                            minlength: 5
                        }
                    },
                    messages: {
                        username: {
                            required: "<?php echo Yii::t('login', '用户名不能为空!'); ?>"
                        },
                        password: {
                            required: "<?php echo Yii::t('login', '密码不能为空!'); ?>",
                            minlength: "<?php echo Yii::t('login', '密码不能小于5位数!'); ?>"
                        }
                    },
                    highlight: function (e) {
                        $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                    },
                    success: function (e) {
                        $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
                        $(e).remove();
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element.parent());
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            })
        </script>
    </body>
</html>
