<?php
Yii::app()->clientscript
  ->registerCoreScript( 'jquery' )
// use it when you need it!
/*
  ->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
  ->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
  ->registerCoreScript( 'jquery' )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-transition.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-alert.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-dropdown.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-scrollspy.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tab.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tooltip.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-popover.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-button.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-collapse.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-carousel.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-typeahead.js', CClientScript::POS_END )
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="language" content="en" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Le styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/back_end.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" />        
        <!--<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.min.js"></script>-->     
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" type="image/ico" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicons.png" />
        <style>
            .containerX {
                overflow: hidden;
                /*background-color: #333;*/
                background-color: #00BAC2;
                font-family: Arial;
            }

            .containerX a {
                float: left;
                font-size: 16px;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            .dropdownX {
                float: left;
                overflow: hidden;
            }

            .dropdownX .dropbtnX {
                font-size: 16px;    
                border: none;
                outline: none;
                color: white;
                padding: 14px 16px;
                background-color: inherit;
            }

            .containerX a:hover, .dropdownX:hover .dropbtnX {
                background-color: red;
            }

            .dropdown-contentX {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-contentX a {
                float: none;
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                text-align: left;
            }

            .dropdown-contentX a:hover {
                background-color: #ddd;
            }

            .dropdownX:hover .dropdown-contentX {
                display: block;
            }
        </style>
        <!--<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>-->
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/common.js"></script>
    </head>

    <body>
        </div>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
<!--                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>"><?php echo Yii::app()->name ?></a>-->

                    <div class="containerX">
                        <div class="dropdownX" style="line-height: 18px;">
                            <a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>"><?php echo Settings::getWebsiteName() ?></a>
                        </div>
                        <?php
                        $menu = new AdminMenuManager();
                        echo $menu->createMenu();
                        ?>
<!--                        <a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>">Home</a>
                        <a href="#news">News</a>
                        <div class="dropdownX">
                            <button class="dropbtnX">Quản trị</button>
                            <div class="dropdown-contentX">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/applications') ?>">Quản lý ứng dụng</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/controllers') ?>">Quản lý danh mục</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/controllersActions') ?>">Quản lý các action của danh mục</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/users') ?>">Quản lý nhân sự</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/roles') ?>">Quản lý phân quyền</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/actionsRoles') ?>">Quản lý quyền của nhóm người dùng</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/actionsUsers') ?>">Quản lý quyền của từng người dùng</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/menus') ?>">Quản lý danh sách Menu</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/settings') ?>">Quản lý tham số hệ thống</a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/modules') ?>">Quản lý các module</a>
                            </div>
                        </div> -->
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('/site/login') ?>"
                           style="<?php
                           if (!Yii::app()->user->isGuest) {
                               echo 'display: none';
                           }
                           ?>">
                           <?php echo DomainConst::CONTENT00068; ?>
                        </a>
                        <?php if (Yii::app()->user->isGuest): ?>
                        <?php else: ?>
                        <div class="dropdownX">
                            <button class="dropbtnX">Tài khoản<?php echo ' (' . Yii::app()->user->name .')' ?></button>
                            <div class="dropdown-contentX">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/users/view', array('id' => Yii::app()->user->id)); ?>">
                                    <?php echo DomainConst::CONTENT00070; ?>
                                </a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/users/changePassword') ?>">
                                     <?php echo DomainConst::CONTENT00071; ?>
                                </a>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl('/site/logout') ?>"><?php echo DomainConst::CONTENT00069; ?></a>
                            </div>
                        </div>
                        <?php endif; // end if (Yii::app()->user->isGuest) ?>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
                        <?php
//                        $menu = new AdminMenuManager();
//                        echo $menu->createMenu();
                        ?>
        <div class="cont">
            <div class="container-fluid">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                        'homeLink' => false,
                        'tagName' => 'ul',
                        'separator' => '',
                        'activeLinkTemplate' => '<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
                        'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
                        'htmlOptions' => array('class' => 'breadcrumb')
                    ));
                    ?>
                    <!-- breadcrumbs -->
                <?php endif ?>
                <?php echo $content ?>


            </div><!--/.fluid-container-->
        </div>

        <div class="extra">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h4>Heading 1</h4>
                        <ul>
                            <li><a href="#">Subheading 1.1</a></li>
                            <li><a href="#">Subheading 1.2</a></li>
                            <li><a href="#">Subheading 1.3</a></li>
                            <li><a href="#">Subheading 1.4</a></li>
                        </ul>
                    </div> <!-- /span3 -->

                    <div class="col-md-3">
                        <h4>Heading 2</h4>
                        <ul>
                            <li><a href="#">Subheading 2.1</a></li>
                            <li><a href="#">Subheading 2.2</a></li>
                            <li><a href="#">Subheading 2.3</a></li>
                            <li><a href="#">Subheading 2.4</a></li>
                        </ul>
                    </div> <!-- /span3 -->

                    <div class="col-md-3">
                        <h4>Heading 3</h4>	
                        <ul>
                            <li><a href="#">Subheading 3.1</a></li>
                            <li><a href="#">Subheading 3.2</a></li>
                            <li><a href="#">Subheading 3.3</a></li>
                            <li><a href="#">Subheading 3.4</a></li>
                        </ul>
                    </div> <!-- /span3 -->

                    <div class="col-md-3">
                        <h4>Heading 4</h4>
                        <ul>
                            <li><a href="#">Subheading 4.1</a></li>
                            <li><a href="#">Subheading 4.2</a></li>
                            <li><a href="#">Subheading 4.3</a></li>
                            <li><a href="#">Subheading 4.4</a></li>
                        </ul>
                    </div> <!-- /span3 -->
                </div> <!-- /row -->
            </div> <!-- /container -->
        </div>

        <div class="footer">
            <div class="container">
                <div class="row">
                    <div id="footer-copyright" class="col-md-6">
                        About us | Contact us | Terms & Conditions
                    </div> <!-- /span6 -->
                    <div id="footer-terms" class="col-md-6">
                        © 2017 <a href="http://www.immortal.vn/" target="_blank">Immortal.vn</a>
                    </div> <!-- /.span6 -->
                </div> <!-- /row -->
            </div> <!-- /container -->
        </div>
    </body>
</html>
<?php Yii::app()->bootstrap->register(); ?>
