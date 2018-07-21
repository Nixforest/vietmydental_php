<?php
/**
 * @this Newscontroller
 * @model model news
 */
echo !empty($model) ? $model->getField('content') : '';