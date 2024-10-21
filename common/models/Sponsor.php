<?php

namespace common\models;

use common\components\Utils;
use Yii;

/**
 * This is the model class for table "sponsor".
 *
 * @property int $id
 * @property string $image_path
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Sponsor extends \yii\db\ActiveRecord
{
  public $image_path_upload;

  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'sponsor';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['image_path', 'name'], 'required'],
      [['image_path', 'name'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'image_path' => Yii::t('common', 'Image Path'),
      'name' => Yii::t('common', 'Name'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  public function upload($file)
  {
    $path = Utils::uploadImage($file);
    if ($path) {
      $this->image_path = $path;
    }
  }

  public function getImage()
  {
    return Yii::getAlias('@backendAssetOrigin') . '/' . $this->image_path;
  }
}
