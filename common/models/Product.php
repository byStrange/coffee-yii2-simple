<?php

namespace common\models;

use common\components\Utils;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $title_text_source_id
 * @property string|null $image_layer_1
 * @property string|null $image_layer_2
 * @property int $price
 * @property int|null $description_text_source_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TextSource $descriptionTextSource
 * @property TextSource $titleTextSource
 */
class Product extends \yii\db\ActiveRecord
{

  use TimeStampTrait;
  public $title = "";
  public $description = "";
  public $image_layer_1_upload;
  public $image_layer_2_upload;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'product';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['title_text_source_id', 'price'], 'required'],
      [['title_text_source_id', 'price', 'description_text_source_id'], 'default', 'value' => null],
      [['title_text_source_id', 'price', 'description_text_source_id'], 'integer'],
      [['image_layer_1', 'image_layer_2'], 'string', 'max' => 255],
      [['image_layer_1', 'image_layer_2'], 'image', 'skipOnEmpty' => true],
      [['created_at', 'updated_at'], 'safe'],
      [['title_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['title_text_source_id' => 'id']],
      [['description_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['description_text_source_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'title_text_source_id' => Yii::t('common', 'Title Text Source ID'),
      'image_layer_1' => Yii::t('common', 'Image Layer 1'),
      'image_layer_2' => Yii::t('common', 'Image Layer 2'),
      'price' => Yii::t('common', 'Price'),
      'description_text_source_id' => Yii::t('common', 'Description Text Source ID'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[DescriptionTextSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getDescriptionTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'description_text_source_id']);
  }

  /**
   * Gets query for [[TitleTextSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTitleTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'title_text_source_id']);
  }

  public function upload($files)
  {
    [$file1, $file2] = $files;
    $layer_1_path = Utils::uploadImage($file1);
    /*Utils::printAsError($layer_1_path);*/
    $layer_2_path = Utils::uploadImage($file2);
    if ($layer_1_path) {
      $this->image_layer_1 = $layer_1_path;
    }
    if ($layer_2_path) {
      $this->image_layer_2 = $layer_2_path;
    }
  }

  public function __toString()
  {
    return $this->titleTextSource;
  }

  public function getImages()
  {
    return [
      'layer_1' => Yii::getAlias('@backendAssetOrigin') . '/' . $this->image_layer_1,
      'layer_2' => Yii::getAlias('@backendAssetOrigin') . '/' . $this->image_layer_2,
    ];
  }

  public static function getOne()
  {
    return self::find()->one();
  }
}
