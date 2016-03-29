<?php
namespace frontend\models;

use common\models\cUser;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $plan_id = 1;
    public $paypal_email;
    public $paypal_subscription_id;
    public $first_name;
    public $last_name;
    public $email_user = 1;
    public $complimentary = 1;

    const PLAN_BASIC = 0;
    const PLAN_MIDDLE = 1;
    const PLAN_UNLIMITED = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\cUser', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['plan_id', 'paypal_email', 'paypal_subscription_id', 'first_name', 'last_name'], 'safe'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\cUser', 'message' => 'This email address has already been taken.'],

            ['email_user', 'safe'],

            ['password', 'string', 'min' => 6],

            ['plan_id', 'required'],
        ];
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
            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->paypal_email = $this->paypal_email;
            $user->email = $this->email;
            $user->plan_id = $this->plan_id;
            if(trim($this->password) == '')
            {
                $this->password = $this->generatePassword();
            }
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            return $user;
        }

        return null;
    }

    public static function generatePassword()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = "";

        if (isset($_POST['length'])){
            // if you want a form like above
            if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
                $chars .= $alpha;

            if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
                $chars .= $alpha_upper;

            if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
                $chars .= $numeric;

            if (isset($_POST['special']) && $_POST['special'] == 'on')
                $chars .= $special;

            $length = $_POST['length'];
        } else {
            // default [a-zA-Z0-9]{9}
            $chars = $alpha . $alpha_upper . $numeric;
            $length = 9;
        }

        $len = strlen($chars);
        $pw = '';

        for ($i=0;$i<$length;$i++)
            $pw .= substr($chars, rand(0, $len-1), 1);

// the finished password
        $pw = str_shuffle($pw);
        return $pw;
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
