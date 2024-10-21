<?php

namespace backend\controllers;

use common\components\RedirectBehavior;
use common\components\Utils;
use common\models\TextTranslation;
use common\models\search\TextTranslationSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TextTranslationController implements the CRUD actions for TextTranslation model.
 */
class TextTranslationController extends Controller
{
  /**
   * @inheritDoc
   */
  public function behaviors()
  {
    return array_merge(
      parent::behaviors(),
      [
        'verbs' => [
          'class' => VerbFilter::className(),
          'actions' => [
            'delete' => ['POST'],
          ],
        ],
        'redirect' => [
          'class' => RedirectBehavior::class,
        ],
      ]
    );
  }

  /**
   * Lists all TextTranslation models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new TextTranslationSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single TextTranslation model.
   * @param int $id ID
   * @return string
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new TextTranslation model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate($redirect_url = null)
  {
    $model = new TextTranslation();
    $ajax = $this->request->get('ajax');
    $as_html = $this->request->get('as_html');

    if ($this->request->isPost) {
      if ($model->load($this->request->post()) && $model->save()) {
        if ($ajax) {
          if ($as_html) {
            return $this->renderPartial('_translation_card', ['translation' => $model]);
          }
          Yii::$app->response->format = Response::FORMAT_JSON;
          return $model;
        }
        if ($redirect_url) {
          return $this->redirect($redirect_url);
        } else {
          return $this->redirect(['view', 'id' => $model->id]);
        }
      }
    } else {
      $model->loadDefaultValues();
    }

    Utils::printAsError('none of those checks worked, using normal render create');

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing TextTranslation model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing TextTranslation model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    $ajax = $this->request->get('ajax');

    if ($ajax) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return '';
    }
    return $this->redirect(['index']);
  }

  /**
   * Finds the TextTranslation model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return TextTranslation the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = TextTranslation::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
  }
}
