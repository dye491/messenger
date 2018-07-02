<?php
/* @var $this yii\web\View */

/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div style="width: 125px;height: 125px; background-color:<?= $model->getBgColor() ?>;padding-top: 40px;text-align: center;border-radius: 50%;margin-bottom: 50px">
    <?= Html::a($model->username, ['/profile/view', 'id' => $model->id]) ?><br>
    <?= $model->online ? 'online' : 'offline' ?><br>
    <?php if (!Yii::$app->user->isGuest): ?>
        <?php if (
            ($user = \common\models\User::findIdentity(Yii::$app->user->id))
            && $user->hasContactWith($model->id)): ?>
            <?= Html::a('Write', ['/message/dialog', 'contact_id' => $model->id]) ?>
        <?php else: ?>
            <?= Html::a('Add to contacts', ['/profile/add', 'id' => $model->id]) ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
