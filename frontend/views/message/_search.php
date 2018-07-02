<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-search">

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->controller->action->id,
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'text', [
        'inputOptions' => [
            'placeholder' => Yii::t('app_message','Search'),
            'class' => 'form-control'],
    ])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
