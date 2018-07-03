<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title . ' (' . ($model->online ? Yii::t('app_user','online') : Yii::t('app_user','offline')) . ')') ?></h1>

    <div class="row h4">
        <div class="col-sm-2">
            <?= Yii::t('app_user', 'About') ?>
        </div>
        <div class="col-sm-10">
            <?= Html::encode($model->about) ?>
        </div>
    </div>
    <div class="row h4">
        <div class="col-sm-2">
            <?= Yii::t('app_user', 'Created at') ?>
        </div>
        <div class="col-sm-10">
            <?= date('d.m.Y', $model->created_at) ?>
        </div>
    </div>
    <div class="row h4">
        <div class="col-sm-2">
            <?= Yii::t('app_user', 'Updated at') ?>
        </div>
        <div class="col-sm-10">
            <?= date('d.m.Y H:i:s', $model->updated_at) ?>
        </div>
    </div>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $model->id): ?>
        <div class="row h4">
            <div class="col-sm-2">
                <?= Yii::t('app_user', 'Unread messages') ?>
            </div>
            <div class="col-sm-10">
                <?= Html::a(Html::tag('span', $model->getNewMessageCount(), ['class' => 'badge']), ['/message']) ?>
            </div>
        </div>
        <p>
            <?= Html::a(Yii::t('app_user', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app_user', 'Change password'), ['change-password', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        </p>

    <?php endif; ?>

</div>
