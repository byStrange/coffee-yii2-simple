<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "newsletter_subscriber".
 *
 * @property int $id
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class NewsletterSubscriber extends \yii\db\ActiveRecord
{

  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'newsletter_subscriber';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['email'], 'required'],
      [['email'], 'string'],
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
      'email' => Yii::t('common', 'Email'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }
}
