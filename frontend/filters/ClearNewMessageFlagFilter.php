<?php

namespace frontend\filters;

use common\models\Message;
use yii\base\ActionFilter;
use yii\data\ActiveDataProvider;

/**
 * Class ClearNewMessageFlagFilter
 * @package frontend\filters
 */
class ClearNewMessageFlagFilter extends ActionFilter
{
    /**
     * @var $dataProvider ActiveDataProvider
     */
    public $dataProvider;

    /**
     * ClearNewMessageFlagFilter constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->dataProvider = \Yii::createObject($this->dataProvider);
    }

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        /**
         * @var $model Message
         */
        foreach ($this->dataProvider->models as $model) {
            if ($model->new && $model->to == \Yii::$app->user->id) {
                $model->new = false;
                $model->save();
            }
        }

        return parent::afterAction($action, $result);
    }
}