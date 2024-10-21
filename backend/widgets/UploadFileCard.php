<?php

namespace backend\widgets;

use yii\base\Widget;

class UploadFileCard extends Widget
{
  public $model;
  public $upload_field;
  public $image_path;
  public $image_alt;
  public $card_title;
  public $form;

  public function run()
  {
    return $this->render('upload-file-card', [
      'model' => $this->model,
      'upload_field' => $this->upload_field,
      'image_path' => $this->image_path,
      'image_alt' => $this->image_alt,
      'card_title' => $this->card_title,
      'form' => $this->form
    ]);
  }
}
