<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int|null $cart_id
 * @property int|null $order_id
 * @property string $type
 * @property string $quantity
 * @property int $object_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Cart $cart
 * @property Order $order
 */
class Item extends \yii\db\ActiveRecord
{

  use TimeStampTrait;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'item';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['cart_id', 'order_id', 'object_id'], 'default', 'value' => null],
      [['cart_id', 'order_id', 'object_id'], 'integer'],
      [['type', 'object_id'], 'required'],
      [['type'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
      [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::class, 'targetAttribute' => ['cart_id' => 'id']],
      [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'cart_id' => Yii::t('common', 'Cart ID'),
      'order_id' => Yii::t('common', 'Order ID'),
      'type' => Yii::t('common', 'Type'),
      'object_id' => Yii::t('common', 'Object ID'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[Cart]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCart()
  {
    return $this->hasOne(Cart::class, ['id' => 'cart_id']);
  }

  public function getCoffee()
  {
    return $this->hasOne(Coffee::class, ['id' => 'object_id']);
  }

  public function getProduct()
  {
    return $this->hasOne(Product::class, ['id' => 'object_id']);
  }

  /**
   * Gets query for [[Order]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrder()
  {
    return $this->hasOne(Order::class, ['id' => 'order_id']);
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
