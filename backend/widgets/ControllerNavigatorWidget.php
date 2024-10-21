<?php

namespace backend\widgets;

use common\components\Utils;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use ReflectionClass;

class ControllerNavigatorWidget extends Widget
{
  public $controllerNamespace = 'backend\\controllers';
  public $exclude = [];

  public function exclude($array)
  {
    foreach ($array as $controller => &$actions) {
      // Convert controller name to kebab-case
      $controllerKebab = Utils::toKebabCase($controller);

      // Filter actions based on the excluded list
      $actions = array_filter($actions, function ($action) use ($controllerKebab) {
        // Check if the "controller/action" is in the excluded list
        $actionPath = "$controllerKebab/$action";
        return !in_array($actionPath, $this->exclude);
      });

      // Reset array keys to be sequential
      $actions = array_values($actions);
    }
    return $array;
  }
  public function run()
  {
    $controllerDir = Yii::getAlias('@backend/controllers');

    $controllers = $this->findControllers($controllerDir);
    $controllers = $this->exclude($controllers);

    return $this->render('controller-navigator', [
      'controllers' => $controllers
    ]);
  }

  protected function findControllers($directory)
  {
    $controllers = [];
    foreach (glob($directory . '/*Controller.php') as $file) {
      $controllerClass = $this->controllerNamespace . '\\' . basename($file, '.php');

      if (class_exists($controllerClass)) {
        $reflection = new ReflectionClass($controllerClass);
        $actions = $this->getControllerActions($reflection);

        $controllerName = $reflection->getShortName();
        $controllerName = str_replace('Controller', '', $controllerName);

        $controllers[$controllerName] = $actions;
      }
    }

    return $controllers;
  }

  protected function getControllerActions(ReflectionClass $reflection)
  {
    $actions = [];
    foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
      if (strpos($method->name, 'action') === 0 && $method->name !== 'actions') {
        $actionName = str_replace('action', '', $method->name);
        $actionName = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $actionName)); // Converts camelCase to kebab-case
        $actions[] = $actionName;
      }
    }

    return $actions;
  }
}
