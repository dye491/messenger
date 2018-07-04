<?php

namespace frontend\filters;

use common\models\User;
use yii\filters\AccessRule;

class ContactAccessRule extends AccessRule
{
    public $allow = true;

    /**
     * @param \yii\base\Action $action
     * @param false|\yii\web\User $user
     * @param \yii\web\Request $request
     * @return bool|null
     */
    public function allows($action, $user, $request)
    {
        $contact_id = $request->queryParams['contact_id'];
        $model = User::findOne($user->id);

        return parent::allows($action, $user, $request) && $model->hasContactWith($contact_id);
    }


}