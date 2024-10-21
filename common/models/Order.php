<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $phone_number
 * @property int $user_id
 * @property string|null $address
 * @property string|null $type
 * @property string|null $payment_type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item[] $items
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
  const PAYMENT_TYPE_CASH = 'cash';
  const PAYMENT_TYPE_PAYME = 'payme';
  const PAYMENT_TYPE_CLICK = 'click';

  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'order';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['phone_number', 'user_id'], 'required'],
      [['phone_number', 'address', 'type', 'payment_type'], 'string'],
      [['user_id'], 'default', 'value' => null],
      [['user_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
    ];
  }

  public static function getPaymentTypeOptions()
  {
    return [
      self::PAYMENT_TYPE_CASH => Yii::t('common', 'Cash'),
      self::PAYMENT_TYPE_PAYME => Yii::t('common', 'Payme'),
      self::PAYMENT_TYPE_CLICK => Yii::t('common', 'Click'),
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
      'user_id' => Yii::t('common', 'User ID'),
      'address' => Yii::t('common', 'Address'),
      'type' => Yii::t('common', 'Type'),
      'payment_type' => Yii::t('common', 'Payment Type'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[Items]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getItems()
  {
    return $this->hasMany(Item::class, ['order_id' => 'id']);
  }

  /**
   * Gets query for [[User]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(User::class, ['id' => 'user_id']);
  }
}
