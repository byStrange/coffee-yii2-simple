<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_info".
 *
 * @property int $id
 * @property string $phone_number
 * @property string|null $email
 * @property string|null $address
 * @property string|null $secondary_address
 * @property string|null $start_week
 * @property string|null $end_week
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $facebook_url
 * @property string|null $instagram_url
 * @property string|null $telegram_url
 * @property string $created_at
 * @property string $updated_at
 */
class SiteInfo extends \yii\db\ActiveRecord
{
  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'site_info';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['phone_number'], 'required'],
      [['phone_number', 'email', 'address', 'secondary_address', 'start_week', 'end_week', 'start_time', 'end_time', 'facebook_url', 'instagram_url', 'telegram_url'], 'string'],
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
      'phone_number' => Yii::t('common', 'Phone Number'),
      'email' => Yii::t('common', 'Email'),
      'address' => Yii::t('common', 'Address'),
      'secondary_address' => Yii::t('common', 'Secondary Address'),
      'start_week' => Yii::t('common', 'Start Week'),
      'end_week' => Yii::t('common', 'End Week'),
      'start_time' => Yii::t('common', 'Start Time'),
      'end_time' => Yii::t('common', 'End Time'),
      'facebook_url' => Yii::t('common', 'Facebook Url'),
      'instagram_url' => Yii::t('common', 'Instagram Url'),
      'telegram_url' => Yii::t('common', 'Telegram Url'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  public static function getOne()
  {
    return self::find()->one();
  }
}
