<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $attr string */

$this->title = $attr == 'from' ? Yii::t('app_message', 'Inbox') : Yii::t('app_message', 'Sent');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['linkSelector' => false]); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--    <p>-->
    <!--        --><? //= Html::a(Yii::t('app_message', 'Create Message'), ['create'], ['class' => 'btn btn-success']) ?>
    <!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '5%']],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('D H:i', $model->created_at);
                },
                'options' => ['width' => '20%'],
            ],
            [
                'attribute' => $attr,
                'content' => $attr == 'from' ? function ($model) {
                    return Html::a($model->sender->username, ['/message/dialog', 'contact_id' => $model->sender->id]);
                } : function ($model) {
                    return Html::a($model->recipient->username, ['/message/dialog', 'contact_id' => $model->recipient->id]);
                },
                'options' => ['width' => '20%'],
            ],
            'text:ntext',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
