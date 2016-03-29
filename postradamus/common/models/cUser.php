<?php
namespace common\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $paypal_email
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property integer $plan_id
 * @property string $subscription_end_date
 * @property string $paypal_subscription_id
 * @property string $jvzoo_pre_key
 * @property integer $role
 * @property integer $status
 * @property integer $complimentary
 * @property integer $unsubscribed
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class cUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_USER = 10;

    const PLAN_BASIC = 1;
    const PLAN_ADVANCED = 2;
    const PLAN_UNLIMITED = 3;
    const PLAN_UNLIMITED_YEARLY = 4;

    private $_user = [];
    private $_user_setting = [];
    private $_user_facebook_connection = [];
    private $_user_pinterest_connection = [];
    private $_user_wordpress_connection = [];
    private $_user_amazon_connection = [];
    private $_identity;
    public $jvzoo_recurring_payment;

    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             ['status', 'default', 'value' => self::STATUS_ACTIVE],
             ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

             ['role', 'default', 'value' => self::ROLE_USER],
             ['role', 'in', 'range' => [self::ROLE_USER]],
             [['plan_id', 'subscription_end_date', 'complimentary', 'unsubscribed', 'paypal_subscription_id', 'paypal_email', 'first_name', 'parent_id', 'last_name', 'fb_user_name', 'jvzoo_pre_key'], 'safe']
         ];
     }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function getPlan()
    {
        return $this->hasOne(cPlan::className(), ['plan_id' => 'plan_id']);
    }

    public function getStatusName()
    {
        if($this->status == self::STATUS_DELETED)
        {
            return "De-Activated";
        }
        if($this->status == self::STATUS_ACTIVE)
        {
            return "Activated";
        }
    }

    public function getEndingDate()
    {
        $order = new \common\components\Order;
        if($this->getJvzooRecurringPayment() != null)
        {
            return $order->getEndingDate($this->getJvzooRecurringPayment());
        }
        return false;
    }

    public function getJvzooRecurringPayment()
    {
        if(empty($this->jvzoo_recurring_payment))
        {
            $order = new \common\components\Order;
            $jvzoo = new \common\components\JvzooRest;
            $this->jvzoo_recurring_payment = json_decode($jvzoo->getRecurringPayment('PA-' . $order->getLastTransactionReceiptNo($this->id)));
        }
        return $this->jvzoo_recurring_payment;
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function getField($field)
    {
        if(!$this->_identity)
        {
            $this->_identity = $this->findIdentity($this->id);
        }
        $user = $this->_identity;
        if(is_object($user))
        {
            $this->_user[$this->id] = $user;
            return $user->$field;
        }
        return false;
    }

    public function getSetting($field)
    {
        if(!isset($this->_user_setting[$this->id]))
        {
            $setting = cSetting::find()->andWhere(['user_id' => $this->id])->one();
            $this->_user_setting[$this->id]= $setting;
        }
        return $this->_user_setting[$this->id]->$field;
    }

    public function getPinterestConnection($field, $campaign_id = 0)
    {
        if(!isset($this->_user_pinterest_connection[$this->id . $campaign_id]))
        {
            if($this->parent_id != 0)
            {
                $id = $this->parent_id;
            }
            else
            {
                $id = $this->id;
            }
            $setting = cConnectionPinterest::find()->where(['user_id' => $id, 'campaign_id' => $campaign_id])->one();
            if(empty($setting) || $setting->username == '')
                $setting = cConnectionPinterest::find()->where(['user_id' => $id, 'campaign_id' => 0])->one();

            $this->_user_pinterest_connection[$this->id . $campaign_id] = $setting;
        }
        return $this->_user_pinterest_connection[$this->id . $campaign_id]->$field;
    }

    public function getWordpressConnection($field, $campaign_id = 0)
    {
        if(!isset($this->_user_wordpress_connection[$this->id . $campaign_id]))
        {
            if($this->parent_id != 0)
            {
                $id = $this->parent_id;
            }
            else
            {
                $id = $this->id;
            }
            $setting = cConnectionWordpress::find()->where(['user_id' => $id, 'campaign_id' => $campaign_id])->one();
            if(empty($setting) || $setting->username == '')
                $setting = cConnectionWordpress::find()->where(['user_id' => $id, 'campaign_id' => 0])->one();

            $this->_user_wordpress_connection[$this->id . $campaign_id] = $setting;
        }
        return $this->_user_wordpress_connection[$this->id . $campaign_id]->$field;
    }

    public function getFacebookConnection($field)
    {
        if(!isset($this->_user_facebook_connection[$this->id]))
        {
            if($this->parent_id != 0)
            {
                $id = $this->parent_id;
            }
            else
            {
                $id = $this->id;
            }
            $setting = cConnectionFacebook::find()->andWhere(['user_id' => $id])->one();

            $this->_user_facebook_connection[$this->id] = $setting;
        }
        return $this->_user_facebook_connection[$this->id]->$field;
    }

    public function getAmazonConnection($field, $country)
    {
        if(!isset($this->_user_amazon_connection[$this->id]))
        {
            if($this->parent_id != 0)
            {
                $id = $this->parent_id;
            }
            else
            {
                $id = $this->id;
            }
            $setting = cConnectionAmazon::find()->andWhere(['user_id' => $id, 'country' => $country, 'campaign_id' => (int)Yii::$app->session->get('campaign_id')])->one();
            if(empty($setting))
                $setting = cConnectionAmazon::find()->andWhere(['user_id' => $id, 'country' => $country, 'campaign_id' => 0])->one();
            $this->_user_amazon_connection[$this->id] = $setting;
        }
        return $this->_user_amazon_connection[$this->id][$field];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
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
        $this->auth_key = Yii::$app->security->generateRandomKey();
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
}
