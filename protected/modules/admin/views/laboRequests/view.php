<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

$this->createMenu('', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => DomainConst::CONTENT00135,
            'value' => $model->getCustomerName() . " - " . $model->getCustomerRecordNumber(),
        ),
        array(
            'name' => DomainConst::CONTENT00199,
            'value' => $model->getAgentName(),
        ),
        array(
            'name'    => DomainConst::CONTENT00143,
            'value'     => $model->getDoctorName(),
        ),
        array(
            'name' => DomainConst::CONTENT00146,
            'type'      => 'html',
            'value' => $model->getTreatmentInfo(),
        ),
        array(
            'name' => 'service_id',
            'value' => $model->getService(),
        ),
        'date_request',
        array(
            'name'      => 'date_receive',
            'header'    => DomainConst::CONTENT00436,
            'value'     => $model->getReceiveTime(),
        ),
        'date_test',
        'description',
        array(
            'name' => 'price',
            'value' => $model->getPrice(),
        ),
        array(
            'name' => 'status',
            'value'  => $model->getStatus(),
        ),
        'created_date',
        array(
            'name' => DomainConst::CONTENT00054,
            'value' => $model->getCreatedBy(),
        ),
    ),
));
?>
