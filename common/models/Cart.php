<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item[] $items
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{

  use TimeStampTrait;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'cart';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['user_id'], 'default', 'value' => null],
      [['user_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'user_id' => Yii::t('common', 'User ID'),
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
    return $this->hasMany(Item::class, ['cart_id' => 'id']);
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

  public static function getOrCreateCurrentInstance($auto_create = true)
  {
    $user = Yii::$app->user->identity;
    if ($user && $user->cart) {
      return $user->cart;
    }

    $session = Yii::$app->session;
    $cart_id = $session->get('cart_id');
    if (!$cart_id && $auto_create) {
      $cart = new Cart();
      $cart->user_id = $user ? $user->id : null;
      $cart->save();
      $session->set('cart_id', $cart->id);
      return $cart;
    };

    $cart = self::findOne(['id' => $cart_id]);
    return $cart;
  }

  public function totalAmount()
  {
    $total = 0;
    foreach ($this->items as $item) {
      $total += $item->totalAmount();
    }
    return $total;
  }

  public function totalAmountFormatted()
  {
    return Yii::$app->formatter->asCurrency($this->totalAmount());
  }
}
