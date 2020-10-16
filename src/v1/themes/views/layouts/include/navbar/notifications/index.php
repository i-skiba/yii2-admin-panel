<?php
    use yii\helpers\Url;
    use yii\widgets\ListView;
    
//    $dataProvider = Yii::$app->adminNotificationService->getNavbarDataProvider();
//    $count = $dataProvider->getTotalCount();
?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-bubbles4"></i>
            <span class="visible-xs-inline-block position-right">
                <?= Yii::t('common', 'Оповещения');?>
            </span>
            <?php if($count > 0) :?>
                <span class="badge bg-danger-400">
                    <?= $count;?>
                </span>
            <?php endif;?>
    </a>
    <?php if($count > 0) :?>
        <div class="dropdown-menu dropdown-content width-350">
            <div class="dropdown-content-heading">
                    <?= Yii::t('common', 'Оповещения');?>
            </div>
<!--            --><?//= ListView::widget([
//                    'dataProvider' => $dataProvider,
//                    'itemView' => '_view',
//                    'layout' => '{items}',
//                    'options' => [
//                        'tag' => 'ul',
//                        'class' => 'media-list dropdown-content-body'
//                    ],
//                    'itemOptions' => [
//                        'tag' => 'li',
//                        'class' => 'media'
//                    ]
//                ]);
//            ?>
            <div class="dropdown-content-footer">
                    <a href="<?= Url::to(['/notice/admin-notification/index']);?>" data-popup="tooltip" title="<?= Yii::t('common', 'Все оповещения');?>">
                        <i class="icon-menu display-block"></i>
                    </a>
            </div>
        </div>
    <?php endif;?>
</li>
<script>
    $(document).ready(function() {
        //TODO перенести в виджет (если будет формление в виджет) или в общий файл
        //смена статуса оповещения
        $('.admin-notice-read').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var readUrl = $(this).attr('data-read-url');
            $.ajax({
                type : 'POST',
                url : readUrl,
                success : function () {
                    location.href = url;
                }
            });
            
            return false;
        })
    })
</script>