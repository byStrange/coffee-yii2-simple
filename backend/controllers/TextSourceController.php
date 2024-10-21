<?php

namespace backend\controllers;

use common\components\RedirectBehavior;
use common\components\Utils;
use common\models\TextSource;
use common\models\search\TextSourceSearch;
use common\models\TextTranslation;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TextSourceController implements the CRUD actions for TextSource model.
 */
class TextSourceController extends Controller
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
          'actions' => ['view', 'create', 'update', 'delete'],
        ]
      ]
    );
  }

  /**
   * Lists all TextSource models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new TextSourceSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single TextSource model.
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
   * Creates a new TextSource model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $textSourceModel = new TextSource();

    if ($this->request->isPost) {
      if (
        ($textSourceModel->load($this->request->post()) && $textSourceModel->save())
      ) {
        return $this->redirect(['update', 'id' => $textSourceModel->id]);
      }
    } else {
      $textSourceModel->loadDefaultValues();
    }

    return $this->render('create', [
      'model' => $textSourceModel,
    ]);
  }

  /**
   * Updates an existing TextSource model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id, $popup = false)
  {
    $model = $this->findModel($id);
    $translations = $model->textTranslations;
    $translationModel = new TextTranslation();

    if ($this->request->isPost) {
      if (
        ($model->load($this->request->post()) && $model->save())
        ||
        ($translationModel->load($this->request->post()) && $translationModel->save())
      ) {
        return $this->redirect(['update', 'id' => $model->id, 'popup' => $popup]);
      }
    }
    /*Utils::printAsError($translationModel->errors);*/

    return $this->render('update', [
      'model' => $model,
      'translationModel' => $translationModel,
      'translations' => $translations,
      'popup' => $popup
    ]);
  }

  /**
   * Deletes an existing TextSource model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the TextSource model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return TextSource the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = TextSource::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
  }

}
