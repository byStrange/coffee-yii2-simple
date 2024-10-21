<?php

namespace backend\controllers;

use common\models\Coffee;
use common\models\search\CoffeeSearch;
use common\models\TextSource;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CoffeeController implements the CRUD actions for Coffee model.
 */
class CoffeeController extends Controller
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
   * Lists all Coffee models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new CoffeeSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Coffee model.
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
   * Creates a new Coffee model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Coffee();
    if ($this->request->isPost) {
      $coffee = $this->request->post("Coffee");
      $title = $coffee["title"];
      $description = $coffee["description"];


      if ($model->load($this->request->post())) {
        $uploaded_file_1  = UploadedFile::getInstance($model, 'image_upload');

        $model->upload([$uploaded_file_1]);

        $titleTextSource = new TextSource(['text' => $title]);
        $titleTextSource->save();

        $descriptionTextSource = new TextSource(['text' => $description]);
        $descriptionTextSource->save();

        $model->text_source_id = $titleTextSource->id;
        $model->description_text_source_id = $descriptionTextSource->id;

        $model->save();
        return $this->redirect(['view', 'id' => $model->id]);
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Coffee model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($this->request->isPost && $model->load($this->request->post())) {
      $uploaded_file_1 = UploadedFile::getInstance($model, 'image_upload');
      $model->upload([$uploaded_file_1]);

      if ($model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
      }
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing Coffee model.
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
   * Finds the Coffee model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Coffee the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Coffee::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
  }
}
