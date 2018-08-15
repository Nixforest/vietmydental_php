<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	$this->controllerDescription=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List Users', 'url'=>array('index')),
//	array('label'=>'Create Users', 'url'=>array('create')),
//	array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Users', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Users #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'username',
//		'email',
                array(
                    'name' => DomainConst::CONTENT00276,
                    'value' => $model->getSocialNetworkInfo(),
                    'type'=>'html',
                    'htmlOptions' => array('style' => 'width:200px;'),
                ),
//		'password_hash',
                array(
                    'name'=>'password_hash',
                    'type'=>'raw',
                    'value'=>CHtml::link('Đặt lại mật khẩu', Yii::app()->createAbsoluteUrl('admin/users/resetPassword', array('user_id' => $model->id))),
                ),
//                array(
//                    'name' => 'img_avatar',
//                    'type' => 'html',
//                    'value' => CHtml::image($model->getImageAvatarUrl(), "", array("style"=>"width:250px;height:250px;")),
//                ),
//		'temp_password',
		'last_name',
		'first_name',
                'birthday',
                array(
                    'name' => 'identity_number',
                    'value' => $model->getIdentityInfo(),
                ),
                'date_in',
		'code_account',
//                array(
//                    'name'=>'img_avatar',
//                    'type'=>'html',
//                    'value'=>(!empty($model->img_avatar))?CHtml::image($model->getImageAvatarPath(),"",array("style"=>"width:25px;height:25px;")):"no image",
//                ),
                array(
                    'name' => 'agent',
                    'value' => $model->getAgentName(),
                ),
		'address',
//		'address_vi',
//		'house_numbers',
//		'province_id',
//		'district_id',
//		'ward_id',
//		'street_id',
//		'login_attemp',
		'created_date',
//		'last_logged_in',
		'ip_address',
//		'role_id',
		array(
                   'name'=>'role_id',
                   'value'=>$model->rRole->role_short_name,
                ),
//		'application_id',
//		'status',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                ),
		'gender',
		'phone',
//		'verify_code',
//		'slug',
//		'address_temp',
		'created_by',
	),
)); ?>
<a rel="group1" class="gallery" href="<?php echo ImageHandler::bindImageByModel($model->rImgAvatarFile,'','',array('size'=>'size1024x900'));?>"> 
    <img width="100" height="70" src="<?php echo ImageHandler::bindImageByModel($model->rImgAvatarFile,'','',array('size'=>'size128x96'));?>">
</a>