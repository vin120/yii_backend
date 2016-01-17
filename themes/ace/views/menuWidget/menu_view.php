<?php
$theme_url = Yii::app()->theme->baseUrl;
$open_index = 0;
$open_index2 = 0;
foreach ($permissions as $row)
{
    foreach ($row['child'] as $item)
    {
        if(!isset($item['child']))
        {
            if($item['method_name'] == $menu_type)
            {
                $open_index = $row['menu_id'];
            }
        }
        else
        {
            $open_index = $row['menu_id'];
            foreach ($item['child'] as $val)
            {
                if($val['method_name'] == $menu_type)
                {
                    $open_index2 = $val['parent_menu_id'];
                }
            }
        }
    }
}
?>
<div class="sidebar" id="sidebar">
    <script type="text/javascript">
        try 
        {
            ace.settings.check('sidebar', 'fixed')
        } 
        catch (e) 
        {
        }
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="icon-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="icon-pencil"></i>
            </button>

            <button class="btn btn-warning">
                <i class="icon-group"></i>
            </button>

            <button class="btn btn-danger">
                <i class="icon-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- #sidebar-shortcuts -->

    <ul class="nav nav-list">
        <?php foreach ($permissions as $item){?>
            <?php if(in_array($item['menu_id'],$auth)|| $auth[0] ==0){ ?>
            <li <?php echo ($item['menu_id'] == $open_index) ? ' class="active open"' : ''; ?>>
                <a href="" class="dropdown-toggle">
                    <i class="icon-<?php echo $item['icon']?>"></i>
                    <span class="menu-text"> <?php echo yii::t('vcos', $item['role_name'])?> </span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <?php foreach($item['child'] as $res){ ?>
                        <?php if(!isset($res['child'])){?>
                            <?php if(in_array($res['menu_id'],$auth) || $auth[0] == '0'){ ?>
                            <li<?php echo ($res['method_name'] == $menu_type) ? ' class="active"' : ''; ?>>
                                <a href="<?php echo Yii::app()->createUrl($res['controller_name'].'/'.$res['method_name']); ?>">
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo yii::t('vcos', $res['role_name'])?>
                                </a>
                            </li>
                            <?php }?>
                        <?php }  else { ?>
                            <?php if(in_array($res['menu_id'],$auth) || $auth[0] == '0'){ ?>
                                <li <?php echo ($res['menu_id'] == $open_index2) ? ' class="active open"' : ''; ?>>
                                    <a href="" class="dropdown-toggle">
                                        <i class="icon-double-angle-right"></i>
                                        <b class="arrow icon-angle-down"></b>
                                        <?php echo yii::t('vcos', $res['role_name'])?>
                                    </a>
                                    <ul class="submenu">
                                        <?php foreach($res['child'] as $row){ ?>
                                        <?php if(in_array($row['menu_id'],$auth) || $auth[0] == '0'){ ?>
                                        <li <?php echo ($row['method_name'] == $menu_type) ? ' class="active"' : ''; ?> >
                                            <a href="<?php echo Yii::app()->createUrl($row['controller_name'].'/'.$row['method_name']); ?>">
                                                <i class="icon-leaf"></i>
                                                <?php echo yii::t('vcos', $row['role_name'])?>
                                            </a>
                                        </li>
                                        <?php }?>
                                        <?php }?>
                                    </ul>
                                </li>
                            <?php }?> 
                        <?php }?>             
                    <?php } ?>
                </ul>
            </li>
            <?php }?>
        <?php }?>
    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try 
        {
            ace.settings.check('sidebar', 'collapsed')
        }
        catch (e)
        {
        }
    </script>
</div>
