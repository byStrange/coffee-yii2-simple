<?php

namespace common\models;

use common\components\Utils;
use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property int $author_id
 * @property string $thumbnail_image
 * @property string $main_image
 * @property int $title_text_source_id Translated title for Blog
 * @property string|null $body
 * @property int $highlighted_text_source_id
 * @property string $slug
 * @property int|null $views
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $author
 * @property Comment[] $comments
 * @property TextSource $highlightedTextSource
 * @property TextSource $titleTextSource
 */
class Blog extends \yii\db\ActiveRecord
{

  use TimeStampTrait;
  public $main_image_upload;
  public $thumbnail_image_upload;
  public $title;
  public $highlighted_text;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'blog';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['author_id', 'thumbnail_image', 'main_image', 'slug', 'title_text_source_id', 'highlighted_text_source_id'], 'required'],
      [['title', 'thumbnail_image', 'main_image', 'body', 'slug', 'highlighted_text'], 'string'],
      [['author_id', 'views', 'status', 'title_text_source_id', 'highlighted_text_source_id'], 'default', 'value' => null],
      [['author_id', 'views', 'status', 'title_text_source_id', 'highlighted_text_source_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
      [['title_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['title_text_source_id' => 'id']],
      [['highlighted_text_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::class, 'targetAttribute' => ['highlighted_text_source_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('common', 'ID'),
      'title' => Yii::t('common', 'Title'),
      'author_id' => Yii::t('common', 'Author ID'),
      'thumbnail_image' => Yii::t('common', 'Thumbnail Image'),
      'main_image' => Yii::t('common', 'Main Image'),
      'body' => Yii::t('common', 'Body'),
      'slug' => Yii::t('common', 'Slug'),
      'views' => Yii::t('common', 'Views'),
      'status' => Yii::t('common', 'Status'),
      'created_at' => Yii::t('common', 'Created At'),
      'updated_at' => Yii::t('common', 'Updated At'),
    ];
  }

  /**
   * Gets query for [[Author]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAuthor()
  {
    return $this->hasOne(User::class, ['id' => 'author_id']);
  }

  /**
   * Gets query for [[Comments]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComments()
  {
    return $this->hasMany(Comment::class, ['blog_id' => 'id']);
  }

  public function getTitleTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'title_text_source_id']);
  }

  public function getHighlightedTextSource()
  {
    return $this->hasOne(TextSource::class, ['id' => 'highlighted_text_source_id']);
  }

  public function upload($files)
  {
    [$main_image, $thumbnail_image] = $files;
    $thumbnail_image_path = Utils::uploadImage($thumbnail_image);
    $main_image_path = Utils::uploadImage($main_image);


    if ($thumbnail_image_path) {
      $this->thumbnail_image = $thumbnail_image_path;
    }
    if ($main_image_path) {
      $this->main_image = $main_image_path;
    }
  }

  public function getShortHighlight()
  {
    return $this->highlightedTextSource;
  }

  public function __toString()
  {
    return $this->titleTextSource;
  }

  public function getImages()
  {
    return [
      'main_image' => Yii::getAlias('@backendAssetOrigin') . '/' . $this->main_image,
      'thumbnail_image' => Yii::getAlias('@backendAssetOrigin') . '/' . $this->thumbnail_image
    ];
  }
}
