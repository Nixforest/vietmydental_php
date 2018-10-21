<?php
/*
 * CSS selectors are used to "find" (or select) HTML elements based on their element name, id, class, attribute, and more.
 * <abc>                => selector = abc
 * <abc id="def">       => selector = #def
 * <abc class="ghi">    => selector = .ghi
 * <p class="center">   => selector = p.center
 * Example:
 * h1, h2, p {
 *    text-align: center;
 *    color: red;
 * }
 * CSS background properties:
 *  background-color
 *  background-image
 *  background-repeat
 *  background-attachment
 *  background-position
 * Shorthand:
 *  top right bottom left
 *  top right-left bottom
 *  top-bottom right-left
 * Position:
 *  static
 *  relative
 *  fixed
 *  absolute
 *  sticky
 */
?>
<h1>CSS testing</h1>
<h1 style="font-size:10vw;">Responsive Text</h1>

<p style="font-size:5vw;">Resize the browser window to see how the text size scales.</p>

<p style="font-size:5vw;">Use the "vw" unit when sizing the text. 10vw will set the size to 10% of the viewport width.</p>

<p>Viewport is the browser window size. 1vw = 1% of viewport width. If the viewport is 50cm wide, 1vw is 0.5cm.</p>
<div id="box-model">
    This text is the actual content of the box. We have added a 25px padding, 25px margin and a 25px green border. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</div>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'settings-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
    <h2>This is a normal message</h2>

    <?php $this->endWidget(); ?>
    <h1 style="background-color: DodgerBlue; color: white;">This is a heading</h1>
    <h2 style="background-color:rgb(255, 99, 71);">This is a smaller heading</h2>
    <p style="background-color:hsla(9, 100%, 64%, 0.5);">This is a paragraph.</p>
    <p>This is another paragraph.</p>
    <p id="para1">This is a paragraph.</p>
    <p class="colortext" style="border:2px solid Violet;">This is another paragraph.</p>
    <p class="colortext">This is also a paragraph.</p>
</div><!-- form -->
<div class="ex1">This div is 300px wide.</div>
<br>

<div class="ex2">The width of this div remains at 300px, in spite of the 50px of total left and right padding, because of the box-sizing: border-box property.
</div>


<div id="height-width">
    <h2>Set the height and width of an element</h2>
    <p>This div element has a height of 200px and a width of 50%:</p>
</div>


<div id="max-width">
    <h2>Set the max-width of an element</h2>
    <p>This div element has a height of 100px and a max-width of 500px:</p>
</div>

<p>Resize the browser window to see the effect.</p>
<style>
</style>
<?php Yii::app()->clientscript->registerCssFile(Yii::app()->theme->baseUrl . '/css/test.css'); ?>