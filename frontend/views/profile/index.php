<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'beforeItem' => function ($model, $key, $index) {
            if ($index % 12 == 0) {
                return '<div class="row">';
            }
        },
        'afterItem' => function ($model, $key, $index, $widget) {
            if ($index % 12 == 11 || ($widget->dataProvider->getCount() - 1) == $index) {
                return '</div>';
            }
        },
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-lg-2 col-md-3 col-sm-6'],
        'itemView' => /*function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        }*/
            '_item',
    ]) ?>
    <?php Pjax::end(); ?>
</div>
