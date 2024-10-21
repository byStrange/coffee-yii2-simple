<?php

namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;
use yii\web\Response;

class RedirectBehavior extends Behavior
{
  public $actions = [];
  public function events()
  {
    return [
      Controller::EVENT_AFTER_ACTION => 'afterAction',
    ];
  }


  public function afterAction($event)
  {
    $redirectUrl = Yii::$app->request->get('redirect_url');
    if ($redirectUrl) {
      $response = Yii::$app->response;
      $response->redirect($redirectUrl)->send();
      var_dump($response);
      Yii::$app->end();
    }
  }
}
