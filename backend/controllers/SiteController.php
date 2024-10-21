<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;

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
        'rules' => [
          [
            'actions' => ['login', 'error', 'language'],
            'allow' => true,
          ],
          [
            'actions' => ['logout', 'index'],
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
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    return $this->render('index');
  }

  /**
   * Login action.
   *
   * @return string|Response
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $this->layout = 'blank';

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    $model->password = '';

    return $this->render('login', [
      'model' => $model,
    ]);
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
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();

    return $this->goHome();
  }
}
