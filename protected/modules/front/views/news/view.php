<?php
/**
 * @this Newscontroller
 * @model model news
 */
?>
<?php if (!empty($model)) : ?>
    <?php
    $category = '';
    if (isset($model->rCategory)) {
        $isFirst = true;
        foreach (array_reverse($model->rCategory->getChain()) as $mCategory) {
            $category .= '<a href="' . $mCategory->getFrontEndUrl() . '">' . ($isFirst ? '|' : '->') . $mCategory->name . '</a>';
            $isFirst = false;
        }
        
    }
    echo $category;
    ?>
    <h1><?php echo $model->description; ?></h1>
    <div><b><?php echo $model->getCreatedBy(); ?></b> tạo lúc <i><?php echo $model->created_date; ?></i><br/></div>
    <?php echo !empty($model) ? $model->getField('content') : ''; ?>
    
<?php endif; ?>
    
<!--++ BUG0093-IMT (DuongNV 20180924) comment in news-->
<?php 
    $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
    if(empty($userId)){
        $url = Yii::app()->createAbsoluteUrl("site/login");
        echo '<a href="'.$url.'">Đăng nhập</a> để bình luận.';
    } else {
        include "comment.php";
    }
?>

    
<script>
    $(function(){
        bindComment();
        bindLike();
    });
    function bindComment(){
        $(document).on('keyup', '.rep-cmt .input-cm', function(event){
            if(event.keyCode == 13){
                doComment($(this).siblings('.icon-send'));
            }
        });
        $(document).on('click', '.rep-cmt .icon-send', function(){
            doComment($(this));
        });
        bindClickComment();
    }
    function doComment(elmThis){
        var content = elmThis.siblings('.input-cm').val();
        if(content == ''){
            return false;
        }
        var type    = elmThis.data('type');
        var idCmt   = elmThis.data('idcmt');
        var elm     = elmThis.closest('.rep-cmt');
        elmThis.siblings('.input-cm').val("");
        $.ajax({
            'url': '<?php echo Yii::app()->createAbsoluteUrl('front/news/view', array('id'=>$model->id));?>',
            'data': {
                type, idCmt, content
            },
            'success':function(data){
                elm.before(data);
            }
        });
    }
    function bindClickComment(){
        $(document).on('click', '.cm-btn', function(){
            if($(this).hasClass('rep-cm')){
                var prCm   = $(this).closest('.cm-block');
                var childCm = prCm.find('.child-cm-container');
                var id = $(this).data('id');
                if(childCm.length == 0){
                    var inputRep = '<div class="child-cm-container"> '+
                                        '<div class="reply-child-cm rep-cmt"> '+
                                            '<img src="https://cdn3.iconfinder.com/data/icons/faticons/32/user-01-512.png" class="cm-avatar"> '+
                                            '<input type="text" placeholder="Viết phản hồi..." class="input-cm"> '+
                                            '<span class="glyphicon glyphicon-send icon-send"'+
                                                  'data-type="<?php echo Comments::TYPE_CHILD; ?>" '+
                                                  'data-idcmt="' + id + '"></span>'+
                                        '</div>'+
                                    '</div>';
                    prCm.append(inputRep);
                    prCm.find('.input-cm').focus();
                } else {
                    childCm.find('.reply-child-cm.rep-cmt .input-cm').focus();
                }
            } else {
                $(this).closest('.child-cm-container').find('.reply-child-cm.rep-cmt .input-cm').focus();
            }
        });
    }
    function bindLike(){
        $(document).on('click', '.cm-block .like-btn', function(){
            alert('Chức năng đang hoàn thiện, vui lòng thử lại sau!');
        });
    }
</script>
<!---- BUG0093-IMT (DuongNV 20180924) comment in news-->