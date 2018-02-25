<?php
Yii::app()->clientscript
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
        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Le styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
        <!-- Le fav and touch icons -->
<style>
.containerX {
    overflow: hidden;
    background-color: #333;
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
    </head>

    <body>
        <div class="containerX">
  <a href="#home">Home</a>
  <a href="#news">News</a>
  <div class="dropdownX">
    <button class="dropbtnX">Dropdown</button>
    <div class="dropdown-contentX">
      <a href="#">Link 1</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
  </div> 
  <a href="#news">Link</a>
</div>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#"><?php echo Yii::app()->name ?></a>
                    <div class="navbar-collapse">
                        <?php
//                        $this->widget('zii.widgets.CMenu', array(
//                            'htmlOptions' => array('class' => 'nav'),
//                            'activeCssClass' => 'active',
//                            'items' => array(
//                                array('label' => 'Home', 'url' => array('/site/index')),
//                                array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
//                                array('label' => 'Contact', 'url' => array('/site/contact')),
//                                array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
//                                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
////                                array(
////                                    'label' => 'Quản trị',
////                                    'url' => '#',
////                                    'visible' => (Yii::app()->user->name == 'nguyenpt'),
////                                    'htmlOptions' => array('class' => 'nav'),
////                                    'activeCssClass' => 'active',
////                                    'items' => array(
////                                        array(
////                                            'label' => 'Quản trị ứng dụng',
////                                            'url' => array('admin/applications'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý danh mục',
////                                            'url' => array('admin/controllers'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                        array(
////                                            'label' => 'Quản lý nhân sự',
////                                            'url' => array('admin/users'),
////                                        ),
////                                    ),
////                                ),
//                            ),
//                        ));
//                         $this->widget('zii.widgets.CMenu', array(
//                            'items'=>array(
//                                array('label'=>'Home',   'url'=>array('site/index')),
//                                array('label'=>'Products', 'url'=>array('product/index'), 'items'=>array(
//                                    array('label'=>'New Arrivals', 'url'=>array('product/new')),
//                                    array('label'=>'Most Popular', 'url'=>array('product/index')),
//                                    array('label'=>'Another', 'url'=>array('product/index'), 'items'=>array(
//                                        array('label'=>'Level 3 One', 'url'=>array('product/new')),
//                                        array('label'=>'Level 3 Two', 'url'=>array('product/index')),
//                                        array('label'=>'Level 3 Three', 'url'=>array('product/index'), 'items'=>array(
//                                            array('label'=>'Level 4 One', 'url'=>array('product/new')),
//                                            array('label'=>'Level 4 Two', 'url'=>array('product/index')),
//                                        )),
//                                    )),
//                                )),
//                                array('label'=>'Login', 'url'=>array('site/login')),
//                            ),
//                        ));
                        $this->widget('zii.widgets.CMenu', array(
                'items'=>array(
                    // Important: you need to specify url as 'controller/action',
                    // not just as 'controller' even if default action is used.
                    array('label'=>'Home', 'url'=>array('site/index')),
                    // 'Products' menu item will be selected no matter which tag parameter value is since it's not specified.
                    array(
                            'label'=>'Products <span class="caret"></span>',
                            'url'=>array('#'),
                            'linkOptions'=> array(
                            'class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown',
                        ),
                        'items'=>array(
                                array('label'=>'New Arrivals', 'url'=>array('product/new', 'tag'=>'new')),
                                array('label'=>'Most Popular', 'url'=>array('product/index', 'tag'=>'popular'))
                        ),
                        'itemOptions'=>array('class'=>'dropdown')),

                    array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
                )
                ,'htmlOptions'=>array('class'=>'nav navbar-nav')
                ,'submenuHtmlOptions'=>array('class'=>'dropdown-menu')
                ,'encodeLabel'=>false
                ,'activeCssClass' => 'active'

            )
        );
                        ?>
                    <?php
//                        $menu = new AdminMenuManager();
//                        echo $menu->createMenu();
                    ?>

                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
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
                        © 2017 <a href="http://immortal.vn" target="_blank">Immortal.vn</a>
                    </div> <!-- /.span6 -->
                </div> <!-- /row -->
            </div> <!-- /container -->
        </div>
    </body>
</html>
