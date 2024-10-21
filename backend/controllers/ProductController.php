<?php

namespace backend\controllers;

use common\components\Utils;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\TextSource;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
   * Lists all Product models.
   *
   * @return string
   */
  public function actionIndex()
  {

    $product = Product::getOne();

    return $this->render('index', [
      'product' => $product
    ]);
  }


  /**
   * Creates a new Product model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Product();
    if ($this->request->isPost) {
      $product = $this->request->post("Product");
      $title = $product["title"];
      $description = $product["description"];

      if ($model->load($this->request->post())) {
        $uploaded_file_1  = UploadedFile::getInstance($model, 'image_layer_1_upload');
        $uploaded_file_2  = UploadedFile::getInstance($model, 'image_layer_2_upload');

        $model->upload([$uploaded_file_1, $uploaded_file_2]);

        $titleTextSource = new TextSource(['text' => $title]);
        $titleTextSource->save();

        $desctiptionTextSource = new TextSource(['text' => $description]);
        $desctiptionTextSource->save();

        $model->title_text_source_id = $titleTextSource->id;
        $model->description_text_source_id = $desctiptionTextSource->id;

        if ($model->save()) {
          return $this->redirect(['index']);
        } else {
          Utils::printAsError($model->errors);
        }
      }
    } else {
      $model->loadDefaultValues();
    }

    /*Utils::printAsError($model->errors);*/

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Product model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($popup = false)
  {
    $model = $this->findModel();

    if ($this->request->isPost && $model->load($this->request->post())) {

      $uploaded_file_1 = UploadedFile::getInstance($model, 'image_layer_1_upload');
      $uploaded_file_2 = UploadedFile::getInstance($model, 'image_layer_2_upload');

      $model->upload([$uploaded_file_1, $uploaded_file_2]);

      $model->save();
      return $this->redirect(['index',]);
    }

    return $this->render('update', [
      'model' => $model,
      'popup' => $popup
    ]);
  }

  /**
   * Deletes an existing Product model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete()
  {
    $this->findModel()->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Product model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Product the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel()
  {
    if (($model = Product::getOne()) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
  }
}
