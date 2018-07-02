<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\Message */
/* @var $contactName string */

$this->title = Yii::t('app_message', 'Dialog with ') . $contactName;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <? $form = ActiveForm::begin(['options' => ['data-pjax' => 1]]) ?>
    <?= $form->field($model, 'text', [
        'inputOptions' => [
            'class' => 'form-control',
            'placeholder' => Yii::t('app_message', 'Your text here'),
        ],
    ])->label(false) ?>
    <?php ActiveForm::end() ?>

    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_item',
    ]) ?>
    <?php Pjax::end(); ?>
</div>
