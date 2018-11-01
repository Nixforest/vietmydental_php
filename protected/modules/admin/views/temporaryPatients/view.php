<?php
/* @var $this TemporaryPatientsController */
/* @var $model TemporaryPatients */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->getName(); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'phone',
        'content',
        array(
            'name' => 'book_date',
            'value' => $model->getBookDate(),
        ),
        array(
            'name' => DomainConst::CONTENT00276,
            'value' => $model->getSocialNetworkInfo(),
            'type'=>'html',
            'htmlOptions' => array('style' => 'width:200px;'),
        ),
        array(
            'name' => 'customer_id',
            'value' => $model->getCustomer(),
        ),
        array(
            'name' => 'source_id',
            'value' => $model->getSourceInfo(),
        ),
        array(
            'name' => 'receptionist_id',
            'value' => $model->getReceptionist(),
        ),
        array(
            'name' => 'status',
            'value' => $model->getStatus(),
        ),
        'created_date',
        array(
            'name' => 'created_by',
            'value' => $model->getCreatedBy(),
        ),
    ),
));
?>
