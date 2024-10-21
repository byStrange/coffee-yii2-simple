<?php

use common\models\Item;
use yii\helpers\Url;

/** @var Item $item */

?>

<div class="flex items-center justify-between border rounded-lg p-4 transition duration-300 ease-in-out hover:shadow-md"
  id="item-<?= $item->id ?>">


  <img src="/api/placeholder/120/120" alt="Coffee" class="w-24 h-24 object-cover rounded-md">
  <div class="flex-1 ml-6">
    <h3 class="text-xl font-semibold text-coffee-dark"><?= $item->type === 'coffee' ? $item->coffee : $item->product ?></h3>
    <p class="text-coffee text-lg mt-1">Quantity: <?= $item->quantity ?></p>
    <p class="text-coffee-dark font-bold text-xl mt-2">
      <?= $item->totalAmountFormatted() ?>
    </p>
  </div>
  <button class="text-red-500 hover:text-red-700 transition duration-300 ease-in-out transform hover:scale-110"
    hx-get="<?= Url::to(['site/remove-item', 'id' => $item->id]) ?>"
    hx-target="#cartModal"
    hx-swap="innerHTML"
    hx-confirm="Are you sure you want to delete this item?">
    <i class="bx bx-trash" style="font-size: 24px"></i>
  </button>
</div>
