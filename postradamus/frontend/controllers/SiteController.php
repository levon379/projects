<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionEmailOneTime()
    {
        $email_users = \common\models\cUser::find()->where(['unsubscribed' => 0, 'parent_id' => 0, 'status' => 0])->andWhere('created_at < UNIX_TIMESTAMP() - (86400 * 60)')->all();
        foreach($email_users as $user)
        {
            if($user->email)
            {
                $email = $user->email;
                $first_name = explode(" ", $user->first_name);
                $first_name = ucwords($first_name[0]);
                $id = md5($user->id);
                if(trim($first_name) != '' && trim($first_name) != 'The')
                {
                    $to = "$first_name <$email>";
                }
                else
                {
                    $first_name = 'there';
                    $to = $email;
                }
                $from = "FROM: Postradamus <info@1s0s.com>";
                $subject = "Come back to Postradamus";
                $body = "Hi $first_name,

We miss you at Postradamus and would like to invite you back to see all the great new additions we've made lately with another 15 day trial for $1, plus a special discount code good for a massive 25% off every month. Just use discount code \"BACKTOPD\" on the checkout page.

Just a few of the additions we've made include access to finding content from some great new places (these include Facebook, Twitter, Pinterest, Instagram, Youtube, Amazon, Reddit, Tumblr, Imgur, webpages and RSS/Atom feeds). You now also have the ability to export your lists directly to your Pinterest boards and Wordpress blogs as well as your Facebook pages. We'd love for you to come and check us out again. Let Postradamus help you massively boost your social media engagement and fan base.

You can re-activate your account today, just visit http://postradam.us/ - Choose which plan is best for you and don't forget to enter discount code \"BACKTOPD\" on the checkout page for your special discount of 25% off every month. This discount is only good for 10 days from this email though so don't wait too long.

The Postradamus Team
Nate Sanden
Jeffrey Strain

---

UNSUBSCRIBE
http://1s0s.com/postradamus/site/unsubscribe/?id=$id";
                mail($to, $subject, $body, $from);
                //echo "From: " . htmlentities($from) . "<br />";
                //echo "To: " . htmlentities($to) . "<br />";
                //echo "Subject: " . $subject . "<br />";
                //echo "Body: " . nl2br($body) . "<br /><br />";
            }
        }
    }

    public function actionUnsubscribe($id)
    {
        $user = \common\models\cUser::find()->where('MD5(id) = "' . $id . '"')->one();
        $user->unsubscribed = 1;
        $user->save(false);
        echo $this->render('unsubscribe');
    }

    public function actionSpecial()
    {
        echo $this->render('special');
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionBetaTester()
    {
        echo $this->render('fbpostbot');
    }

    public function actionThanksJvzoo()
    {
        function jvzValid()
        {
            $key='hUp43xMa';
            $rcpt=$_REQUEST['cbreceipt'];
            $time=$_REQUEST['time'];
            $item=$_REQUEST['item'];
            $cbpop=$_REQUEST['cbpop'];

            $xxpop=sha1("$key|$rcpt|$time|$item");
            $xxpop=strtoupper(substr($xxpop,0,8));

            if($cbpop==$xxpop)
            {
                //create an account if need be
                $this->render('thankyou_jvzoo');
            }
            else
                echo "It looks like your receipt is not valid. Please email support at <a href='mailto:info@1s0s.com'>info@1s0s.com</a>";
        }
    }

    public function actionThanks()
    {
        return $this->render('thankyou');
    }

    public function actionIndex()
    {
        header("Location: http://postradam.us", false, 301);
        return $this->render('index');
    }

    public function actionOrder()
    {
        return $this->render('order');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSale()
    {
        return $this->renderPartial('sale');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $this->redirect('http://1s0s.com/app/');
                }
            }
        }

        if(Yii::$app->user->id == 1)
        {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            $this->redirect('http://1s0s.com/app/');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionJvzooIpn()
    {
        mail('natesanden@gmail.com', 'jvzoo ipn ran', serialize($_POST));

        if(!isset($_POST['ctransaction']))
            die('unathorized access.');

        function jvzipnVerification() {
            $secretKey = "hUp43xMa";
            $pop = "";
            $ipnFields = array();
            foreach ($_POST AS $key => $value) {
                if ($key == "cverify") {
                    continue;
                }
                $ipnFields[] = $key;
            }
            sort($ipnFields);
            foreach ($ipnFields as $field) {
                // if Magic Quotes are enabled $_POST[$field] will need to be
                // un-escaped before being appended to $pop
                $pop = $pop . $_POST[$field] . "|";
            }
            $pop = $pop . $secretKey;
            $calcedVerify = sha1(mb_convert_encoding($pop, "UTF-8"));
            $calcedVerify = strtoupper(substr($calcedVerify,0,8));
            return $calcedVerify == $_POST["cverify"];
        }

        if(jvzipnVerification() == 1)
        {
            mail('natesanden@gmail.com', 'jvzoo ipn verified', 'jvzoo ipn verified');

            if($_POST['ctransaction'] == 'SALE')
            {
                try {
                    //create an account
                    $model = new SignupForm();
                    //get our custom field
                    //$custom = unserialize($_POST['custom']); //should contain at least $custom['plan_id']
                    //$email = (isset($custom['email']) ? $custom['email'] : $_POST['payer_email']);
                    $email = $_POST['ccustemail'];
                    $model->username = $email; //email is entered through our lead page
                    $model->password = $this->generatePassword(); //paypal generated
                    $model->email = $email; //email is entered through our lead page
                    $model->paypal_email = $email;
                    $model->first_name = (isset($_POST['ccustname']) ? $_POST['ccustname'] : '');
                    $model->paypal_subscription_id = $_POST['ctransreceipt'];
                    if($_POST['cproditem'] == '108697')
                    {
                        $model->plan_id = 1;
                    }
                    if($_POST['cproditem'] == '110257')
                    {
                        $model->plan_id = 2;
                    }
                    if($_POST['cproditem'] == '110259')
                    {
                        $model->plan_id = 3;
                    }
                    $newuser = $model->signup();
                    if(isset($newuser) && !empty($newuser))
                    {
                        //mail it
                        $subject = 'New User Created';
                        $to = 'natesanden@gmail.com,jeffrey@savingadvice.com';    //  your email
                        $body =  "A user (".$model->username.") was automatically created\n";
                        $body .= "from paypal: ".$_POST['payer_email']." on ".date('m/d/Y');
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");

                        //email customer his account details
                        $subject = 'Thank you for your order';
                        $to = $email;
                        $body = $this->renderPartial('_email_thank_you_for_ordering', ['model' => $model]);
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    }
                    else
                    {
                        //mail it
                        $subject = 'New User Could NOT Be Created';
                        $to = 'natesanden@gmail.com';    //  your email
                        $body =  "We tried to create this user but...\n";
                        //$body .= serialize($newuser->getErrors());
                        mail($to, $subject, $body, "FROM: Postradamus <info@1s0s.com>");
                    }
                } catch(\Exception $e) {
                    //hoping to catch db error here
                    mail('natesanden@gmail.com', 'Exception during subscr_signup - ', $e->getMessage(), "FROM: Postradamus <info@1s0s.com>");
                }

            }

        } else {

            mail('natesanden@gmail.com', 'jvzoo ipn not verified', 'jvzoo ipn not verified');
        }

    }

}
