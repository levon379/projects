<?php
namespace backend\models;

use common\models\cUser;
use yii\base\Model;
use Yii;

/**
 * User form
 */
class UserForm extends Model
{
    public $email;
    public $password;
    public $parent_id;
    public $plan_id;
    public $paypal_email;
    public $paypal_subscription_id;
    public $first_name;
    public $last_name;
    public $isNewRecord = true;

    const PLAN_BASIC = 0;
    const PLAN_MIDDLE = 1;
    const PLAN_UNLIMITED = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id', 'paypal_email', 'paypal_subscription_id', 'first_name', 'last_name'], 'safe'],

            ['parent_id', 'hasNoMoreThan', 'params' => ['max' => Yii::$app->postradamus->getPlanDetails(Yii::$app->user->identity->getField('plan_id'))['users']]],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\cUser', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function hasNoMoreThan($attribute, $params)
    {
        $value = $this->$attribute;
        $count_users = cUser::find()->where(['parent_id' => $value])->count();
        if ($count_users >= $params['max']) {
            $this->addError($attribute, 'You cannot create more than ' . $params['max'] . ' users.');
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new cUser();
            $user->username = $this->email;
            $user->email = $this->email;
            $user->plan_id = Yii::$app->user->identity->getField('plan_id');
            $user->parent_id = Yii::$app->user->id;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if($user->validate())
            {
                $user->save();
            }
            else
            {
                echo "<pre>";
                print_r($user->getErrors());
                die();
            }
            return $user;
        } else {
            echo "<pre>";
            print_r($this->getErrors());
            die();
        }

        return null;
    }

    public function createList()
    {

    }

    public function createPostTypes()
    {

    }

    public function setSettings()
    {

    }

}
