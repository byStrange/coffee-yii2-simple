<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "coffee_category".
 *
 * @property int $id
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Coffee[] $coffees
 */
class CoffeeCategory extends \yii\db\ActiveRecord
{

  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'coffee_category';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['label'], 'required'],
      [['created_at', 'updated_at'], 'safe'],
      [['label'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'label' => Yii::t('common', 'Label'),
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
    return $this->hasMany(Coffee::class, ['category_id' => 'id']);
  }

  public function __toString()
  {
    return $this->label;
  }

  static  function toOptionList()
  {
    return ArrayHelper::map(
      self::find()
        ->select(["id", "label"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }
}
