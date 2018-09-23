<div>
    <h2>Bình luận</h2>
    <hr style="margin: 5px 0;">
    <?php 
    $aParentCmt = $model->getArrayComments();
    if(!empty($aParentCmt)):
        foreach ($aParentCmt as $prCmt): ?>
        <div class="cm-block">
            <div class="parent-cm">
                <img src="https://cdn3.iconfinder.com/data/icons/faticons/32/user-01-512.png" class="cm-avatar">
                <div class="cm-ctn">
                    <span class="cm-name"><?php echo Comments::getInfoUserById($prCmt->created_by); ?></span>
                    <span class="cm-text"><?php echo $prCmt->content; ?></span>
                </div>
                <div class="like-block">
                    <span class="like-btn" data-id="<?php echo $prCmt->id; ?>">Like</span><span> - </span>
                    <span class="cm-btn rep-cm" data-id="<?php echo $prCmt->id; ?>">Comment</span><span> - </span>
                    <span class="time-text">40 min</span>
                </div>
            </div>
        <?php
            $aChildCmt = $prCmt->getArrayComments();
            if(!empty($aChildCmt)): ?>
                <div class="child-cm-container">
                <?php foreach ($aChildCmt as $chlCmt): ?>
                    <img src="https://cdn3.iconfinder.com/data/icons/faticons/32/user-01-512.png" class="cm-avatar">
                    <div class="cm-ctn">
                        <span class="cm-name"><?php echo Comments::getInfoUserById($chlCmt->created_by); ?></span> 
                        <span class="cm-text"><?php echo $chlCmt->content; ?></span>
                    </div>
                    <div class="like-block">
                        <span class="like-btn">Like</span><span> - </span>
                        <span class="cm-btn">Comment</span><span> - </span>
                        <span class="time-text">40 min</span>
                    </div>
                <?php endforeach; ?>
                    <div class="reply-child-cm rep-cmt">
                        <img src="https://cdn3.iconfinder.com/data/icons/faticons/32/user-01-512.png" class="cm-avatar">
                        <input type="text" placeholder="Viết phản hồi..." class="input-cm">
                        <span class="glyphicon glyphicon-send icon-send"
                              data-type="<?php echo Comments::TYPE_CHILD; ?>" 
                              data-idcmt="<?php echo $prCmt->id; ?>"></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach;
    endif; ?>
    <div class="reply-parent-cm rep-cmt">
        <img src="https://cdn3.iconfinder.com/data/icons/faticons/32/user-01-512.png" class="cm-avatar">
        <input type="text" placeholder="Viết bình luận..." class="input-cm">
        <span class="glyphicon glyphicon-send icon-send" 
              data-type="<?php echo Comments::TYPE_NEWS; ?>"
              data-idcmt="<?php echo $model->id; ?>"></span>
    </div>
</div>