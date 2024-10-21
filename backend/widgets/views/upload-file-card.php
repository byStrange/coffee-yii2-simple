<div class="col-md-4 mb-4">
  <div class="card">
    <div class="card-header">
      <?= $card_title ?>
    </div>
    <div class="card-body">
      <div class="image-preview mb-3" id="portrait-preview">
        <img src="<?= $image_path ?>" alt="<?= $image_alt ? $image_alt : $card_title ?>" class="img-fluid">
      </div>
      <?= $form->field($model, $upload_field, [
        "template" => "{input}\n{hint}\n{error}\n",
        "options" => ["class" => 'input-group']
      ])->fileInput(["class" => 'form-control']) ?>
      <div>
      </div>

    </div>

  </div>
</div>
