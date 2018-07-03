<?php
/* @var $this yii\web\View */

/* @var $model common\models\User */

use yii\helpers\Html;
use frontend\helpers\ColorHelper;

?>
<div style="width: 125px;height: 125px; background-color:<?= ColorHelper::color($model->id) ?>;padding-top: 32px;text-align: center;border-radius: 50%;margin-bottom: 50px">
    <?= Html::a($model->username, ['/profile/view', 'id' => $model->id]) ?><br>
    <?= $model->online ? Yii::t('app_user', 'online') : Yii::t('app_user', 'offline') ?><br>
    <?php if (!Yii::$app->user->isGuest): ?>
        <?php if (
            ($user = \common\models\User::findIdentity(Yii::$app->user->id))
            && $user->hasContactWith($model->id)): ?>
            <?= Yii::t('app_user', 'In your contacts') . ' ' . Html::a(Yii::t('app_message', 'Write'), ['/message/dialog', 'contact_id' => $model->id]) ?>
        <?php else: ?>
            <?= Html::a(Yii::t('app_user', 'Add to contacts'), ['/profile/add', 'id' => $model->id]) ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
