<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app_user', 'Change password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-password">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="change-password-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'oldPassword')->passwordInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app_user', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

