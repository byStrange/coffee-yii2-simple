<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "text_translation".
 *
 * @property int $id
 * @property int $text_source_id
 * @property string $language_code
 * @property string $translation
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TextSource $textSource
 */
class TextTranslation extends \yii\db\ActiveRecord
{
  use TimeStampTrait;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'text_translation';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['text_source_id', 'language_code', 'translation'], 'required'],
      [['text_source_id'], 'default', 'value' => null],
      [['text_source_id'], 'integer'],
      [['translation'], 'string'],
      [['language_code'], 'unique', 'targetAttribute' => ['text_source_id', 'language_code'], 'message' => 'Translation for language "{value}" has already been added'],
      [['created_at', 'updated_at'], 'safe'],
      [['language_code'], 'string', 'max' => 255],
      [['text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['text_source_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'text_source_id' => Yii::t('common', 'Text Source ID'),
      'language_code' => Yii::t('common', 'Language Code'),
      'translation' => Yii::t('common', 'Translation'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
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
}
