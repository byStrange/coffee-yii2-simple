<?php

namespace frontend\controllers;

use common\components\Utils;
use common\models\Blog;
use common\models\Cart;
use common\models\Coffee;
use common\models\Comment;
use common\models\Item;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\NewsletterSubscriber;
use common\models\Order;
use common\models\Product;
use common\models\SiteInfo;
use common\models\Sponsor;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'only' => ['logout', 'signup'],
        'rules' => [
          [
            'actions' => ['signup'],
            'allow' => true,
            'roles' => ['?'],
          ],
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => \yii\web\ErrorAction::class,
      ],
      'captcha' => [
        'class' => \yii\captcha\CaptchaAction::class,
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  public function actionCart()
  {
    $cart = Cart::getOrCreateCurrentInstance();
    $items = $cart->items;
    return $this->renderPartial('_cart_modal', ['items' => $items, 'cart' => $cart]);
  }

  public function actionRemoveItem($id)
  {
    $item = Item::findOne($id);
    if (!$item) {
    }
    $item->delete();
    $cart = Cart::getOrCreateCurrentInstance();
    return $this->renderPartial('_cart_modal', ['items' => $cart->items, 'cart' => $cart]);
  }

  public function actionCheckout()
  {
    $model = new Order();
    if ($this->request->isPost && $model->load($this->request->post())) {
      $cart = Cart::getOrCreateCurrentInstance();
      $items = array_map(function ($item) {
        return $item->id;
      }, $cart->items);

      $model->user_id = 1;

      if ($model->save()) {
        $model->save();

        Item::updateAll(['order_id' => $model->id, 'cart_id' => null], ['id' => $items]);
        return $this->goHome();
      }
    }

    return $this->renderPartial('_checkout_modal', ['model' => $model]);
  }

  public function actionAddToCart($id, $type)
  {
    $cart = Cart::getOrCreateCurrentInstance();
    $type = $type == 'coffee' ? 'coffee' : 'product';
    $object = null;

    if ($type == 'product') {
      $object = Product::findOne($id);
    } else if ($type == 'coffee') {
      $object = Coffee::findOne($id);
    }

    if (!$object) {
      throw new NotFoundHttpException('Object not found');
    }

    $item = new Item(['type' => $type, 'cart_id' => $cart->id, 'object_id' => $id]);
    $item->save();

    return 'ok';
  }

  /**
   * Displays homepage.
   *
   * @return mixed
   */
  public function actionIndex()
  {
    $sponsors = Sponsor::find()->all();
    $blogs = Blog::find()->all();
    $siteInfo = SiteInfo::getOne();
    $newsLetterModel = new NewsletterSubscriber();
    if ($this->request->isPost && $newsLetterModel->load(Yii::$app->request->post()) && $newsLetterModel->save()) {
      return $this->goHome();
    }
    /*Utils::printAsError(Yii::$app->language);*/

    return $this->render('index', [
      'sponsors' => $sponsors,
      'blogs' => $blogs,
      'siteInfo' => $siteInfo,
      'newsLetterModel' => $newsLetterModel
    ]);
  }

  /**
   * Logs in a user.
   *
   * @return mixed
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    $model->password = '';

    return $this->render('login', [
      'model' => $model,
    ]);
  }

  /**
   * Logs out the current user.
   *
   * @return mixed
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();

    return $this->goHome();
  }

  public function actionBlog($slug)
  {
    $blog = Blog::findOne(['slug' => $slug]);
    $commentModel = new Comment();

    if (!$blog) {
      return new NotFoundHttpException('blog not found');
    }

    if ($this->request->isGet) {
      $blog->views += 1;
      $blog->save();
    }

    if ($this->request->isPost && $commentModel->load($this->request->post())) {
      $commentModel->blog_id = $blog->id;
      $commentModel->user_id = Yii::$app->user->id;

      if ($commentModel->save()) {
        return $this->renderPartial('blog', ['blog' => $blog, 'commentModel' => $commentModel]);
      }
    }

    return $this->renderPartial('blog', ['blog' => $blog, 'commentModel' => $commentModel]);
  }

  public function actionLanguage()
  {
    $language = Yii::$app->request->post('language');


    Yii::$app->language = $language;

    $languageCookie = new Cookie([
      'name' => 'language',
      'value' => $language,
      'expire' => time() + 60 * 60 * 24 * 30,
    ]);


    Yii::$app->response->cookies->add($languageCookie);

    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
  }

  /**
   * Signs user up.
   *
   * @return mixed
   */
  public function actionSignup()
  {
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post()) && $model->signup()) {
      Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
      return $this->redirect(['/site/login']);
    }

    return $this->render('signup', [
      'model' => $model,
    ]);
  }

  /**
   * Requests password reset.
   *
   * @return mixed
   */
  public function actionRequestPasswordReset()
  {
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

        return $this->goHome();
      }

      Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
    }

    return $this->render('requestPasswordResetToken', [
      'model' => $model,
    ]);
  }

  /**
   * Resets password.
   *
   * @param string $token
   * @return mixed
   * @throws BadRequestHttpException
   */
  public function actionResetPassword($token)
  {
    try {
      $model = new ResetPasswordForm($token);
    } catch (InvalidArgumentException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
      Yii::$app->session->setFlash('success', 'New password saved.');

      return $this->goHome();
    }

    return $this->render('resetPassword', [
      'model' => $model,
    ]);
  }

  /**
   * Verify email address
   *
   * @param string $token
   * @throws BadRequestHttpException
   * @return yii\web\Response
   */
  public function actionVerifyEmail($token)
  {
    try {
      $model = new VerifyEmailForm($token);
    } catch (InvalidArgumentException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }
    if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
      Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
      return $this->goHome();
    }

    Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
    return $this->goHome();
  }

  /**
   * Resend verification email
   *
   * @return mixed
   */
  public function actionResendVerificationEmail()
  {
    $model = new ResendVerificationEmailForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
        return $this->goHome();
      }
      Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
    }

    return $this->render('resendVerificationEmail', [
      'model' => $model
    ]);
  }
}
