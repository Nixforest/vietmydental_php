<?php
/* @var $this UsersController */
/* @var $model Users */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->getFullName(); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'username',
        array(
            'name' => DomainConst::CONTENT00276,
            'value' => $model->getSocialNetworkInfo(),
            'type' => 'html',
            'htmlOptions' => array('style' => 'width:200px;'),
        ),
        array(
            'name' => 'password_hash',
            'type' => 'raw',
            'value' => CHtml::link('Đặt lại mật khẩu', Yii::app()->createAbsoluteUrl('admin/users/resetPassword', array('user_id' => $model->id))),
        ),
        'first_name',
        array(
            'name'  => 'birthday',
            'value' => $model->getBirthday(),
        ),
        array(
            'name' => 'gender',
            'value' => $model->getGender(),
        ),
        'phone',
        array(
            'name' => 'identity_number',
            'type'  => 'html',
            'value' => $model->getIdentityInfo(),
        ),
        'address',
        array(
            'name'  => 'date_in',
            'value' => $model->getDateIn(),
        ),
        'code_account',
        array(
            'name' => 'agent',
            'value' => $model->getAgents(),
            'type' => 'html',
        ),
        array(
            'name' => 'role_id',
            'value' => $model->getRoleName(),
        ),
        array(
            'name' => 'department_id',
            'value' => $model->getDepartment(),
        ),
        'ip_address',
        array(
            'name' => 'status',
            'type' => 'Status',
        ),
        array(
            'name' => 'created_by',
            'value' => $model->getCreatedBy(),
        ),
        'created_date',
    ),
));
?>
<?php if (isset($model->rImgAvatarFile)): ?>
<a rel="group1" class="gallery" href="<?php echo ImageHandler::bindImageByModel($model->rImgAvatarFile, '', '', array('size' => 'size1024x900')); ?>"> 
    <img width="100" height="70" src="<?php echo ImageHandler::bindImageByModel($model->rImgAvatarFile, '', '', array('size' => 'size128x96')); ?>">
</a>
<?php endif; ?>