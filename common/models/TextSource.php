<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "text_source".
 *
 * @property int $id
 * @property string $text Default text that can be displayed when there is no translation
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Coffee[] $coffees
 * @property Coffee[] $coffees0
 * @property Product[] $products
 * @property Product[] $products0
 * @property TextTranslation[] $textTranslations
 */
class TextSource extends \yii\db\ActiveRecord
{
  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'text_source';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['text'], 'required'],
      [['text'], 'string'],
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
      'text' => Yii::t('common', 'Default text'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[Coffees]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCoffees()
  {
    return $this->hasMany(Coffee::class, ['text_source_id' => 'id']);
  }

  /**
   * Gets query for [[Coffees0]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCoffees0()
  {
    return $this->hasMany(Coffee::class, ['description_text_source_id' => 'id']);
  }

  /**
   * Gets query for [[Products]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getProducts()
  {
    return $this->hasMany(Product::class, ['title_text_source_id' => 'id']);
  }

  /**
   * Gets query for [[Products0]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getProducts0()
  {
    return $this->hasMany(Product::class, ['description_text_source_id' => 'id']);
  }

  /**
   * Gets query for [[TextTranslations]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTextTranslations()
  {
    return $this->hasMany(TextTranslation::class, ['text_source_id' => 'id']);
  }

  public function getText()
  {
    $language = Yii::$app->language;
    $translation = $this->getTextTranslations()->where(['language_code' => $language])->one();
    if ($translation) {
      return $translation->translation;
    }
    return $this->text;
  }

  public function __toString()
  {
    return $this->getText();
  }
}
