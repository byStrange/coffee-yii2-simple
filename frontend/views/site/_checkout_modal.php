<div class="relative top-20 mx-auto p-8 border w-full max-w-2xl shadow-2xl rounded-lg bg-white">
  <div class="mb-6">
    <h2 class="text-3xl font-bold text-coffee-dark"><?= Yii::t("app", "Checkout") ?></h2>
    <p class="text-coffee mt-2"><?= Yii::t("app", "Please provide your details to complete the order.") ?></p>
  </div>
  <?php

  use common\models\Order;
  use yii\widgets\ActiveForm;

  $form = ActiveForm::begin(['options' => ['class' => 'space-y-6']]); ?>
  <?= $form->field($model, 'phone_number', [
    'template' => '{label}{input}{error}', // Customize field structure
    'labelOptions' => [
      'for' => 'phone',
      'class' => 'block text-sm font-medium text-coffee-dark mb-1'
    ],
  ])->input('tel', [
    'id' => 'phone',
    'placeholder' => Yii::t("app", 'Your phone number'),
    'class' => 'w-full px-4 py-2 rounded-md border-coffee-light focus:border-coffee-dark focus:ring focus:ring-coffee-light focus:ring-opacity-50'
  ]) ?>
  <?= $form->field($model, 'address', [
    'template' => '{label}{input}{error}', // Customize field structure
    'labelOptions' => [
      'for' => 'address',
      'class' => 'block text-sm font-medium text-coffee-dark mb-1'
    ],
  ])->textarea([
    'id' => 'address',
    'placeholder' => Yii::t("app",  'Your address'),
    'class' => 'w-full px-4 py-2 rounded-md border-coffee-light focus:border-coffee-dark focus:ring focus:ring-coffee-light focus:ring-opacity-50'
  ]) ?>
  <div>
    <?= $form->field($model, 'payment_type', [
      'template' => '{label}{input}{error}', // Custom template to control structure
      'labelOptions' => [
        'for' => 'payment',
        'class' => 'block text-sm font-medium text-coffee-dark mb-1'
      ],
    ])->dropDownList(Order::getPaymentTypeOptions(), [
      'id' => 'payment',
      'class' => 'w-full px-4 py-2 rounded-md border-coffee-light focus:border-coffee-dark focus:ring focus:ring-coffee-light focus:ring-opacity-50'
    ]) ?>
  </div>
  <button type="submit" class="w-full py-3 bg-coffee text-white text-lg font-semibold rounded-lg shadow-md hover:bg-coffee-dark transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg"><?= Yii::t("app", "Place Order") ?></button>
  <?php ActiveForm::end(); ?>
</div>
