<?php

namespace frontend\models;

use yii\base\Model;
use Yii;

class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $oldPasswordHash;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldPassword', 'password', 'password_repeat'], 'required'],
            ['oldPassword', 'validatePassword'],
            ['oldPasswordHash', 'safe'],
            ['password', 'string', 'min' => '6'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Validates old password against his hash
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (!Yii::$app->security->validatePassword($this->$attribute, $this->oldPasswordHash)) {
            $this->addError($attribute, Yii::t('app_user', 'wrong password'));
        }
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => Yii::t('app_user', 'Old password'),
            'password' => Yii::t('app_user', 'New password'),
            'password_repeat' => Yii::t('app_user', 'Repeat password'),
        ];
    }
}