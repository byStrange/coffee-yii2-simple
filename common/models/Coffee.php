<?php

namespace common\models;

use common\components\Utils;
use Yii;

/**
 * This is the model class for table "coffee".
 *
 * @property int $id
 * @property int $price
 * @property int $text_source_id Translated title for Coffee
 * @property string $image Coffee image 
 * @property int $category_id
 * @property int|null $description_text_source_id Translated description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CoffeeCategory $category
 * @property TextSource $descriptionTextSource
 * @property TextSource $textSource
 */
class Coffee extends \yii\db\ActiveRecord
{

  public $image_upload;
  public $title;
  public $description;
  use TimeStampTrait;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'coffee';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['price', 'text_source_id', 'category_id', 'image'], 'required'],
      [['price', 'text_source_id', 'category_id', 'description_text_source_id'], 'default', 'value' => null],
      [['price', 'text_source_id', 'category_id', 'description_text_source_id'], 'integer'],
      ['image', 'image', 'skipOnEmpty' => false,],
      [['created_at', 'updated_at'], 'safe'],
      [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoffeeCategory::class, 'targetAttribute' => ['category_id' => 'id']],
      [['text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['text_source_id' => 'id']],
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
      'price' => Yii::t('common', 'Price'),
      'text_source_id' => Yii::t('common', 'Translated title for Coffee'),
      'category_id' => Yii::t('common', 'Category ID'),
      'description_text_source_id' => Yii::t('common', 'Translated description'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[Category]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCategory()
  {
    return $this->hasOne(CoffeeCategory::class, ['id' => 'category_id']);
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
   * Gets query for [[TextSource]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'text_source_id']);
  }


  public function upload($files)
  {
    [$file1] = $files;
    $image_path = Utils::uploadImage($file1);

    if ($image_path) {
      $this->image = $image_path;
    }
  }

  public function __toString()
  {
    return $this->textSource->getText();
  }

  public function getImage()
  {
    return Yii::getAlias('@backendAssetOrigin') . '/' . $this->image;
  }

  public function totalAmount()
  {
    $price = $this->type === 'coffee' ? $this->coffee->price : $this->product->price;
    return $price * $this->quantity;
  }

  public function totalAmountFormatted()
  {
    return Yii::$app->formatter->asCurrency($this->totalAmount());
  }
}
