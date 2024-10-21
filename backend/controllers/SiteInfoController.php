<?php

namespace backend\controllers;

use common\models\SiteInfo;
use common\models\search\SiteInfoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SiteInfoController implements the CRUD actions for SiteInfo model.
 */
class SiteInfoController extends Controller
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
      ]
    );
  }

  /**
   * Lists all SiteInfo models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $model = SiteInfo::getOne();
    return $this->render('index', [
      'model' => $model
    ]);
  }

  /**
   * Creates a new SiteInfo model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new SiteInfo();

    if ($this->request->isPost) {
      if ($model->load($this->request->post()) && $model->save()) {
        return $this->redirect(['index']);
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing SiteInfo model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate()
  {
    $model = $this->findModel();

    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing SiteInfo model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete()
  {
    $model = $this->findModel();
    if ($model) {
      $model->delete();
    }
    return $this->redirect(['index']);
  }

  /**
   * Finds the SiteInfo model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return SiteInfo the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel()
  {
    if (($model = SiteInfo::getOne()) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
  }
}
