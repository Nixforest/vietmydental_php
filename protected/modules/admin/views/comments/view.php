<?php
/* @var $this CommentsController */
/* @var $model Comments */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'content',
        array(
            'name'  => 'relate_id',
            'type'  => 'html',
            'value' => $model->getRelateInfo(),
        ),
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'status',
            'type' => 'Status',
            'visible' => CommonProcess::isUserAdmin(),
        ),
        array(
            'name'  => 'created_by',
            'value' => isset($model->rCreatedBy) ? $model->rCreatedBy->getFullName() : '',
        ),
        'created_date',
    ),
));
?>
<?php echo 'Có ' . count($model->getArrayComments()) . ' bình luận con.'; ?>