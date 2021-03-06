<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'username', ['inputOptions' => [
        'placeholder' => Yii::t('app_user','Search'),
        'class' => 'form-control',
    ]]) ?>

    <?= $form->field($model, 'online')->checkbox([
        'uncheck' => '',
        'label' => Yii::t('app_user','Online only'),
        'onchange' => 'submit()',
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
