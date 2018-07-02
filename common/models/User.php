<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $about user's status
 * @property boolean $online user's online flag
 *
 * @property Message[] $inbox
 * @property Message[] $sent
 * @property User[] $contacts
 * @property User[] $inverseContacts
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app_user', 'Name'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Returns a relational query for messages sent to this user
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInbox()
    {
        return $this->hasMany(Message::class, ['to' => 'id']);
    }

    /**
     * Returns a relational query for messages sent from this user
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSent()
    {
        return $this->hasMany(Message::class, ['from' => 'id']);
    }

    /**
     * @return string
     */
    public function getBgColor()
    {
        $angle = 15 * ($this->id % 12);
        return "hsl($angle,70%,50%)";
    }

    /**
     * Returns a relational query for user's contacts
     *
     * @return ActiveQueryInterface
     */
    public function getContacts()
    {
        return $this->hasMany(User::className(), ['id' => 'contact_id'])->viaTable('contact', ['user_id' => 'id']);
    }

    /**
     * Returns a relational query for users who has this user in their contacts
     *
     * @return ActiveQueryInterface
     */
    public function getInverseContacts()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('contact', ['contact_id' => 'id']);
    }

    /**
     * Returns true if user with given id has contact with this user (direct or reverse)
     *
     * @param $id
     * @return bool
     */
    public function hasContactWith($id)
    {
        $result = $this->getContacts()->where(['id' => $id])->exists();

        if ($result) return true;

        $result = $this->getInverseContacts()->where(['id' => $id])->exists();

        if ($result) return true;

        return false;
    }

    /**
     * Sets online status of the user
     *
     * @param bool $state
     */
    public function setOnline($state = true)
    {
        $this->online = $state;
        $this->save();
    }

    /**
     * @param null $user_id
     * @return int|string
     */
    public function getNewMessageCount($user_id = null)
    {
        $query = Message::find()->where([
            'to' => $this->id,
            'new' => true,
        ]);

        if ($user_id) {
            $query->andWhere(['from' => $user_id]);
        }

        return $query->count();
    }
}
