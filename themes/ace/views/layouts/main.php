<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
       
        <?php
            $theme_url = Yii::app()->theme->baseUrl;
            
        ?>
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- basic styles -->

        <link href="<?php echo $theme_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/font-awesome-ie7.min.css" />
        <![endif]-->
        
        <!-- page specific plugin styles -->
        <?php
                include_once 'my_cssfile.php';
        ?>        
        
        <!-- fonts -->

        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-fonts.css" />

        <!-- ace styles -->

        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-skins.min.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->
        
        <!-- ace settings handler -->

        <script src="<?php echo $theme_url; ?>/assets/js/ace-extra.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo $theme_url; ?>/assets/js/html5shiv.js"></script>
        <script src="<?php echo $theme_url; ?>/assets/js/respond.min.js"></script>
        <![endif]-->
    
        
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        

    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>