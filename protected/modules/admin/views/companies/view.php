<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'open_date',
        'tax_code',
        'address',
        array(
            'name' => 'director',
            'value' => $model->getDirector(),
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
<h2><?php echo DomainConst::CONTENT00574; ?></h2>
<div class="x_content">
    <div class="tree">
        <?php echo $model->getHtmlTreeData(); ?>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.tree li:has(ul)').addClass('parent_li');
        $('.tree li.parent_li > span > i.node').on('click', function (e) {
            var children = $(this).closest('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).addClass('fa-plus-square').removeClass('fa-minus-square');
            } else {
                children.show('fast');
                $(this).addClass('fa-minus-square').removeClass('fa-plus-square');
            }
            e.stopPropagation();
        });
    });
</script>
<!-- Adding end -->
<!-- Adding start by ThangTGM 18112018 -->
<style type="text/css">
    .tree {
        min-height:20px;
        padding:19px;
        margin-bottom:20px;
        background-color:#fbfbfb;
        /*border:1px solid #999;*/
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        /*border-radius:4px;*/
        -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
    }
    .tree li {
        list-style-type:none;
        margin:0;
        padding:10px 5px 0 5px;
        position:relative
    }
    .tree li::before, .tree li::after {
        content:'';
        left:-20px;
        position:absolute;
        right:auto
    }
    .tree li::before {
        border-left:1px solid #999;
        bottom:50px;
        height:100%;
        top:0;
        width:1px
    }
    .tree li::after {
        border-top:1px solid #999;
        height:20px;
        top:25px;
        width:25px
    }
    .tree li span {
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border:1px solid #999;
        border-radius:5px;
        display:inline-block;
        padding:3px 8px;
        text-decoration:none
    }
    .tree li > span {
        cursor:pointer
    }
    .tree>ul>li::before, .tree>ul>li::after {
        border:0
    }
    .tree li:last-child::before {
        height:30px
    }
    .tree li >span:hover {
        background:#eee;
        border:1px solid #94a0b4;
        color:#000
    }

    .fa-minus-square:before {
        content: "\f146";
    }

    .fa-plus-square:before {
        content: "\f0fe";
    }

    *, *:before, *:after {
        box-sizing: border-box;
    }
</style>
<!-- Adding start by ThangTGM 18112018 -->