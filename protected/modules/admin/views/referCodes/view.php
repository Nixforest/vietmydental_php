<?php
/* @var $this ReferCodesController */
/* @var $model ReferCodes */

$this->createMenu('view', $model);
?>
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php
$url = $model->generateURL();
CommonProcess::echoTest('URL: ', $url);
CommonProcess::echoTest('Code: ', $model->code);
if (!empty($url)) {
    $this->widget('application.extensions.qrcode.QRCodeGenerator', array(
        'data'                  => $url,
        'subfolderVar'          => false,
        'matrixPointSize'       => 5,
        'displayImage'          => true, // default to true, if set to false display a URL path
        'errorCorrectionLevel'  => 'L', // available parameter is L,M,Q,H
        'matrixPointSize'       => 4, // 1 to 10 only
//        'filePath'              => DirectoryHandler::getRootPath() . '/uploads',
        'filename'              => $model->code . '.png',
    ));
}
?>
<!--<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $model->generateURL(); ?>&choe=UTF-8" title="Link to Google.com" />-->
