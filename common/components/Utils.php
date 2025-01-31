<?php

namespace common\components;

use Exception;
use Yii;
use yii\base\Component;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;

class Utils extends Component
{

  const languages_list = ['uz' => 'Uzbek', 'en' => 'English', 'ru' => 'Russian', 'uz-Cy' => 'Uzbek (Cyrillic)'];
  const localEmailDir = '@app/mail';
  public static function preSelectOptions($existingRelation)
  {
    if (empty($existingRelation)) {
      return [];
    }
    $options = [];
    $existingIds = array_column($existingRelation, "id");
    foreach ($existingIds as $id) {
      $options[$id] = [
        "selected" => in_array($id, $existingIds),
      ];
    }
    return $options;
  }

  public static function uploadImage(
    $image,
    $outputFolder = "uploads",
    $generateImageId = null
  ) {
    if (!$image || !$image->tempName) {
      return false;
    }

    if (!is_dir($outputFolder)) {
      if (!mkdir($outputFolder, 0755, true)) {
        throw new Exception(
          "Failed to create upload directory: $outputFolder"
        );
      }
    }

    $filename = $generateImageId
      ? $generateImageId($image) . "." . $image->extension
      : $image->baseName . uniqid() . "." . $image->extension;
    $filePath = $outputFolder . "/" . $filename;

    if (!$image->saveAs($filePath)) {
      throw new Exception("Failed to save uploaded image to $filePath");
    }

    return $filePath;
  }

  public static function printAsError($text, $die = true)
  {
    echo '<pre>';
    var_dump($text);
    echo '</pre>';
    if ($die) die;
  }
  public static function daysInSeconds(int|float $days)
  {
    return $days * 24 * 60 * 60;
  }

  public static function sendEmail($to, $subject, $content)
  {
    $timestamp = date('Y-m-d_H-i-s');
    $filename = Yii::getAlias(self::localEmailDir) . "/{$timestamp}_{$to}.eml";

    $headers = implode("\r\n", [
      "To: {$to}",
      "Subject: {$subject}",
      "X-Mailer: PHP/" . PHP_VERSION,
      "MIME-Version: 1.0",
      "Content-Type: text/html; charset=UTF-8"
    ]);

    $fullContent = $headers . "\r\n\r\n" . $content;

    if (!is_dir(dirname($filename))) {
      mkdir(dirname($filename), 0777, true);
    }

    return file_put_contents($filename, $fullContent) !== false;
  }

  # send email for real
  public static function sendEmailFr($to, $subject, $content)
  {
    try {
      $result = Yii::$app->mailer->compose()
        ->setFrom('qosimovrahmatullo006@gmail.com')
        ->setTo($to)
        ->setSubject($subject)
        ->setHtmlBody($content)
        ->send();

      if (!$result) {
        Yii::error("Failed to send email to {$to}", 'email');
      }

      return $result;
    } catch (\Exception $e) {
      Yii::error("Error sending email to {$to}: " . $e->getMessage(), 'email');
      return false;
    }
  }

  public static function crudActionsDisableOnly($actions, $extraActions = [])
  {
    $crud_actions = ['create', 'view', 'update', 'delete', 'index'];
    $crud_actions = array_merge($crud_actions, $extraActions);
    $remaining = array_diff($crud_actions, $actions);
    return [
      "class" => AccessControl::class,
      "rules" => [
        [
          "allow" => false,
          "actions" => $actions
        ],
        [
          "allow" => true,
          "actions" => $remaining,
        ]
      ]
    ];
  }
  public static function sortData(array $products, array $sortCriteria): array
  {
    // Check if the products array is empty
    if (empty($products)) {
      return $products; // Return an empty array if there are no products
    }

    // Prepare sorting arrays
    $sortArrays = [];
    foreach ($sortCriteria as $key => $direction) {
      if (isset($products[0][$key])) {
        $sortArrays[] = array_column($products, $key); // Extract the column values
        $sortArrays[] = $direction; // Add the sort direction
      } else {
        throw new \InvalidArgumentException("Invalid key: $key");
      }
    }

    // Use array_multisort to sort the data
    $sortArrays[] = &$products; // Reference the original array at the end
    call_user_func_array('array_multisort', $sortArrays);

    return $products; // Return the sorted array
  }
  public static function find($array, $callback)
  {
    if (!$array || !count($array)) return null;

    foreach ($array as $item) {
      if ($callback($item)) {
        return $item;
      }
    }
    return null;
  }

  public static function generateUniqueSlug($modelClass, $fieldValue, $slugField = 'slug')
  {
    $baseSlug = Inflector::slug($fieldValue);
    $slug = $baseSlug;
    $counter = 1;

    while ($modelClass::find()->where([$slugField => $slug])->exists()) {
      $slug = "{$baseSlug}-{$counter}";
      $counter++;
    }

    return $slug;
  }
  public static function toKebabCase($string)
  {
    $spacedString = preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);

    $kebabCase = strtolower(str_replace(' ', '-', $spacedString));

    return $kebabCase;
  }
}
