<?php

/** @var yii\web\View $this */
/** @var array $items */
/** @var app\models\Cart $cart */
?>

<div class="relative top-20 mx-auto p-8 border w-full max-w-2xl shadow-2xl rounded-lg bg-white">
  <div class="flex justify-between items-start">
    <div class="mb-6">
      <h2 class="text-3xl font-bold text-coffee-dark"><?= Yii::t('app', 'Your Cart') ?></h2>
      <p class="text-coffee mt-2"><?= Yii::t('app', 'Review and adjust your order before checkout.') ?></p>
    </div>
    <button onclick="modals.cart.hide()" class="text-red-500 hover:text-red-700 transition duration-300 ease-in-out transform hover:scale-110">
      <i class="bx bx-x" style="font-size: 24px"></i>
    </button>
  </div>

  <div class="space-y-6">
    <?php foreach ($items as $item): ?>
      <?= $this->render('_cart_modal__cart_item', ['item' => $item]) ?>
    <?php endforeach; ?>
  </div>

  <?php if (count($items)): ?>
    <div class="mt-8">
      <div class="flex justify-between items-center mb-4">
        <span class="text-xl font-semibold text-coffee-dark"><?= Yii::t('app', 'Total') ?></span>
        <span class="text-2xl font-bold text-coffee-dark"><?= $cart->totalAmountFormatted() ?></span>
      </div>

      <button
        id="checkoutBtn"
        hx-get="<?= \yii\helpers\Url::to(['/site/checkout']) ?>"
        hx-target="#checkoutModal"
        hx-swap="innerHTML"
        class="w-full py-3 bg-coffee text-white text-lg font-semibold rounded-lg shadow-md hover:bg-coffee-dark transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg"
        onclick="modals.checkout.show()">
        <?= Yii::t('app', 'Proceed to Checkout') ?>
      </button>
    </div>
  <?php else: ?>
    <div class="flex justify-center items-center">
      <h2 class="text-3xl font-bold text-coffee-dark"><?= Yii::t('app', 'Your Cart is empty') ?></h2>
    </div>
  <?php endif; ?>
</div>
</div>
