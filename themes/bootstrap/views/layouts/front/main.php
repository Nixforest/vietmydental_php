<?php
Yii::app()->clientscript
        
//  ->registerCssFile( Yii::app()->theme->baseUrl . '/css/form.css' )
  ->registerCssFile( Yii::app()->theme->baseUrl . '/css/plugin.css' )
  ->registerCssFile( Yii::app()->theme->baseUrl . '/css/main.css' )
//  ->registerCssFile( Yii::app()->theme->baseUrl . '/css/jquery-ui.css' )
  ->registerCoreScript( 'jquery' )
  ->registerCoreScript( 'jquery.ui' )
//  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery.min.js', CClientScript::POS_END )
//  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery-1.11.1.min.js', CClientScript::POS_END )
//  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery-ui.min.js', CClientScript::POS_END )
//  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery.blockUI.js', CClientScript::POS_END )
//  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/jquery-3.2.1.min.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/plugin.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/main.js', CClientScript::POS_END )
  ->registerScriptFile( Yii::app()->theme->baseUrl . '/js/common.js', CClientScript::POS_END )
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
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <link href="apple-touch-icon.png" rel="apple-touch-icon" /> 
        <link href="favicon.ico" rel="icon" /> 
      
        <title>Immortal Technology LTD.,CO</title>        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" />        
        <style>
        body {
           padding-top: 0px;
        }
        </style>
<!--        <link href="css/plugin.css" rel="stylesheet" />
        <link href="css/main.css" rel="stylesheet" />      -->
      
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body>
    
        <div class="page">        	
            <header class="header">
				<div class="container">
<!--					<div class="box-login">
						<a href="#">Đăng Nhập</a>
					</div>-->
                                    <div class="box-login">
                                        <a href="<?php echo Yii::app()->createAbsoluteUrl(''); ?>"><?php echo CHtml::encode(Settings::getWebsiteName()); ?></a>
                                    </div>
				</div>
			</header>
			<div class="mainpage">
				<div class="container">
					<a href="#" class="btn-nav">Menu</a>
                        <div class="mb-tab">
					<div class="boxmenu"> 
						<?php
                                                $menu = new AdminMenuManager();
                                                echo $menu->createFrontEndMenu();
                                                $log = Yii::app()->createAbsoluteUrl('/site/logout');
//                                                $style = 'display: none';
                                                $label = DomainConst::CONTENT00168;
                                                $labelDetail = DomainConst::CONTENT00169;
                                                if (Yii::app()->user->isGuest) {
                                                    $log = Yii::app()->createAbsoluteUrl('/site/login');
//                                                    $style = '';
                                                    $label = DomainConst::CONTENT00165;
                                                    $labelDetail = DomainConst::CONTENT00166;
                                                }
                                                ?>
                                                
                                                <?php if (Yii::app()->user->isGuest): ?>
                                                <?php else: ?>
                                                    <div class="item-menu">
							<a href="<?php echo Yii::app()->createAbsoluteUrl('/admin/default/index'); ?>"></a>
							<span class="ico-menu ico-6"></span>
							<div class="info-menu">
								<h4>Tài khoản<?php echo ' (' . Yii::app()->user->name .')' ?></h4>
								<p>
                                                                    <?php
                                                                    if (isset(Yii::app()->user->role_name)) {
                                                                        $mRole = Roles::getRoleByName(Yii::app()->user->role_name);
                                                                        if ($mRole) {
                                                                            echo $mRole->role_short_name;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </p>
							</div>
                                                    </div>
						<?php endif; // end if (Yii::app()->user->isGuest) ?>
                                            
						<div class="item-menu">
							<a href="<?php echo $log; ?>"></a>
							<span class="ico-menu ico-7"></span>
							<div class="info-menu">
                                                            <h4><?php echo $label; ?></h4>
                                                            <p><?php echo $labelDetail; ?></p>
							</div>
						</div>
					</div>
					</div>
					<div class="cont">
            <div class="container-fluid">
                <?php echo $content ?>
            </div><!--/.fluid-container-->
        </div>
				</div>
			</div>
        </div><!-- //page -->
      <footer class="footer">
		  <div class="container">
			  Immortal Technology LTD.,CO
		  </div>
		</footer>
      
<!--        <script src="js/jquery.min.js"></script>
        <script src="js/plugin.js"></script>
        <script src="js/main.js"></script>-->
        
    </body>
</html>
