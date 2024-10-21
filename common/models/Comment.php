<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $blog_id
 * @property int|null $user_id
 * @property string|null $comment_text
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Blog $blog
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{

  use TimeStampTrait;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'comment';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['blog_id'], 'required'],
      [['blog_id', 'user_id'], 'default', 'value' => null],
      [['blog_id', 'user_id'], 'integer'],
      [['comment_text'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
      [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::class, 'targetAttribute' => ['blog_id' => 'id']],
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
      'blog_id' => Yii::t('common', 'Blog ID'),
      'user_id' => Yii::t('common', 'User ID'),
      'comment_text' => Yii::t('common', 'Comment Text'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[Blog]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getBlog()
  {
    return $this->hasOne(Blog::class, ['id' => 'blog_id']);
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
