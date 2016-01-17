<?php
$theme_url = Yii::app()->theme->baseUrl;
$page_tag = $this->pageTag;

switch ($page_tag)
{
    case ('index' == $page_tag || 'admin' == $page_tag || 'cruise' == $page_tag):
?>
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/jquery-ui-1.10.3.full.min.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/datepicker.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ui.jqgrid.css" />
<?php
        break;
    case 'admin123':
?>
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/jquery-ui-1.10.3.full.min.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/datepicker.css" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/assets/css/ui.jqgrid.css" />
<?php
        break;
    default:
        break;
}
?>


