<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Message */
/* @var $key integer */

/* @var $index integer */

use yii\helpers\Html;

$sent = $model->sender->id == Yii::$app->user->id;
if (!$sent && $model->new) {
    $model->new = false;
    $model->save();
}
?>
<div class="panel<?= $sent ? ' panel-success' : ' panel-default' ?>"
     style="<?= $sent ? 'margin-left' : 'margin-right' ?>: 50px;">
    <div class="panel-heading">
        <?= 'Отправлено ' . date('D H:i:s', $model->created_at) . ', ' . ($sent ? 'Вы ' : $model->sender->username) . ':' ?>
    </div>
    <div class="panel-body">
        <?= Html::encode($model->text) ?>
    </div>
</div>