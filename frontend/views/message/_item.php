<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Message */
/* @var $key integer */

/* @var $index integer */

use yii\helpers\Html;

$sent = $model->sender->id == Yii::$app->user->id;
?>
<div class="panel<?= $sent ? ' panel-success' : ' panel-default' ?>">
    <div class="panel-heading">
        <?= 'Отправлено ' . date('D H:i:s', $model->created_at) . ', ' . ($sent ? 'Вы ' : $model->sender->username) . ':' ?>
    </div>
    <div class="panel-body">
        <?= Html::encode($model->text) ?>
    </div>
    <!--<div class="panel-footer">
        <?/*= 'Отправлено ' . date('D H:i:s', $model->created_at) */?>
    </div>-->
</div>