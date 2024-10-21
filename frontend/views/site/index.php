<?php

use common\components\Utils;
use common\models\Coffee;
use common\models\Product;
use common\models\CoffeeCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;



?>
<!--==================== LOADER ====================-->
<div class="load" id="load">
  <img src="/img/loadcoffee.gif" alt="Load Gif" class="load__gif">
</div>

<!--==================== HEADER ====================-->
<header class="header" id="header">
  <nav class="nav container">
    <a href="#!" class="nav__logo">
      <img src="/img/logo.png" alt="Logo" class="nav__logo-img">
      Coffee.
    </a>

    <div class="nav__menu" id="nav-menu">
      <ul class="nav__list">
        <li class="nav__item">

          <form action="/site/language" method="post">
            <input type="hidden" value="<?= Yii::$app->request->csrfToken ?>" name="<?= Yii::$app->request->csrfParam ?>">
            <?= Html::dropDownList('language', Yii::$app->language, Utils::languages_list, [
              "onchange" => "this.parentElement.submit()"
            ]) ?>
          </form>
        </li>
        <li class="nav__item">
          <a href="#home" class="nav__link active-link"><?= Yii::t("app", "Home") ?></a>
        </li>
        <li class="nav__item">
          <a href="#products" class="nav__link"><?= Yii::t("app", "Products") ?></a>
        </li>
        <li class="nav__item">
          <a href="#premium" class="nav__link"><?= Yii::t("app", "Premium") ?></a>
        </li>
        <li class="nav__item">
          <a href="#blog" class="nav__link"><?= Yii::t("app", "Blog") ?></a>
        </li>
        <li class="nav__item">
          <button href="#" style="padding: 8px; border-radius: 8px; background-color: var(--first-color); color: white" onclick="modals.cart.show()" hx-get="/site/cart" hx-target="#cartModal" hx-swap="innerHTML"><?= Yii::t("app", "Cart") ?></button>
        </li>
        <li class="nav__item">
          <form action="<?= Yii::$app->user->isGuest ? Yii::$app->urlManager->createUrl(['/site/login']) : Yii::$app->urlManager->createUrl(['/site/logout']) ?>" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
            <button href="#" style="padding: 8px; border-radius: 8px; background-color: var(--danger-color); color: white"><?= Yii::$app->user->isGuest ? Yii::t("app", "Login") : Yii::t("app", "Logout") ?></button>
          </form>
        </li>
      </ul>

      <div class="nav__close" id="nav-close">
        <i class="bx bx-x"></i>
      </div>
    </div>

    <!-- Toggle button -->
    <div class="nav__toggle" id="nav-toggle">
      <i class="bx bx-grid-alt"></i>
    </div>
  </nav>
</header>

<!--==================== MAIN ====================-->
<main>
  <!--==================== HOME ====================-->
  <section class="home grid" id="home">
    <div class="home__container">
      <div class="home__content container">
        <h1 class="home__title">
          <?= Yii::t("app", " Choose Your Favorite Coffee And Enjoy ") ?>
          <span>.</span>
        </h1>
        <p class="home__description"><?= Yii::t("app", "Buy the best and delicious coffees.") ?></p>

        <div class="home__data">

          <div class="home__data-group">
            <h2 class="home__data-number">
              <?= Product::find()->count()  + Coffee::find()->count() . '+' ?>
            </h2>
            <h3 class="home__data-title"><?= Yii::t("app", "Exclusive Product") ?></h3>
            <p class="home__data-description"><?= Yii::t("app", "Premium preparation with quality ingredients.") ?></p>
          </div>
        </div>

        <a href="#specialty">
          <img src="/img/scroll.png" alt="Scroll" class="home__scroll">
        </a>
      </div>
    </div>

    <img src="/img/home.png" alt="Home" class="home__img">
  </section>

  <!--==================== ESPECIALTY ====================-->
  <div class="specialty section container" id="specialty">
    <div class="specialty__container">
      <div class="specialty__box">
        <h2 class="section__title"><?= Yii::t("app", "Specialty coffees that make you happy and cheer you up!") ?></h2>
      </div>

      <div class="specialty__category">
        <div class="specialty__group specialty__line">
          <img src="/img/specialty1.png" alt="Specialty img" class="specialty__img">

          <h3 class="specialty__title"><?= Yii::t("app", "Selected Coffee") ?></h3>
          <p class="specialty__description"><?= Yii::t("app", "We select the best premium coffee, for a true taste.") ?></p>
        </div>

        <div class="specialty__group specialty__line">
          <img src="/img/specialty2.png" alt="Specialty img" class="specialty__img">

          <h3 class="specialty__title"><?= Yii::t("app", "Delicious Cookies") ?></h3>
          <p class="specialty__description"><?= Yii::t("app", "Enjoy your coffee with some hot cookies") ?></p>
        </div>

        <div class="specialty__group">
          <img src="/img/specialty3.png" alt="Specialty img" class="specialty__img">

          <h3 class="specialty__title"><?= Yii::t("app", "Enjoy at Home") ?></h3>
          <p class="specialty__description"><?= Yii::t("app", "Enjoy the best coffee in the comfort of your home.") ?></p>
        </div>
      </div>
    </div>
  </div>

  <?php

  $categories = CoffeeCategory::find()->with('coffees')->all();
  ?>
  <!--==================== PRODUCTS ====================-->
  <section class="products section" id="products">
    <div class="products__container container">
      <h2 class="section__title"><?= Yii::t("app", "Choose our delicious and best products") ?></h2>

      <ul class="products__filters">

        <?php foreach ($categories as $key => $category): ?>
          <li class="products__item products__line <?= $key == 0 ? 'active-product' : '' ?>" data-filter=".category-<?= $category->id ?>">
            <h3 class="products__title"><?= $category->label ?></h3>
            <span class="products__stock"><?= Yii::t('app', '{count} products', ['count' => $category->getCoffees()->count()]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <script>
        setTimeout(() => {
          window.mixerProducts.filter('.category-<?= $categories[0]->id ?>');
        }, 100)
      </script>

      <div class="products__content grid">
        <!--==================== Delicacies ====================-->

        <?php foreach ($categories as $category): ?>
          <?php foreach ($category->coffees as $coffee): ?>
            <article class="products__card <?= 'category-' . $category->id ?>">
              <div class="products__shape">
                <?= Html::img($coffee->getImage(), ['class' => 'products__img', 'alt' => $coffee->title, 'style' => 'height: 140px; margin: 0 auto;']) ?>
              </div>

              <div class="products__data">
                <h2 class="products__price">
                  <?= Yii::$app->formatter->asCurrency($coffee->price) ?>
                </h2>
                <h3 class="products__name">
                  <?= $coffee ?>
                </h3>

                <button class="button products__button"
                  hx-get="<?= Url::to(['site/add-to-cart', 'id' => $coffee->id, 'type' => 'coffee']) ?>">
                  <i class="bx bx-shopping-bag"></i>
                </button>
              </div>
            </article>

          <?php endforeach ?>
        <?php endforeach ?>
      </div>
    </div>
  </section>

  <?php $product = Product::getOne() ?>
  <!--==================== QUALITY ====================-->
  <section class="quality section" id="premium">
    <div class="quality__container container">
      <h2 class="section__title"><?= Yii::t("app", "We offer a premium and better quality preparation just for you!") ?></h2>

      <div class="quality__content grid">
        <div class="quality__images">
          <?Php $images = $product->getImages() ?>
          <?= Html::img($images['layer_1'], ['alt' => $product->titleTextSource, 'class' => 'quality__img-big']) ?>

          <?= Html::img($images['layer_2'], ['alt' => $product->titleTextSource, 'class' => 'quality__img-small']) ?>
        </div>

        <div class="quality__data">
          <h1 class="quality__title">
            <?= $product ?>
          </h1>
          <h2 class="quality__price">
            <?= Yii::$app->formatter->asCurrency($product->price) ?>
          </h2>
          <p class="quality__description">
            <?= $product->descriptionTextSource ?>
          </p>

          <div class="quality__buttons">
            <button class="button"
              hx-swap="none"
              hx-get="<?= Url::to(['site/add-to-cart', 'id' => $product->id, 'type' => 'product']) ?>">
              <?= Yii::t("app", "Add to Cart") ?>
            </button>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!--==================== LOGOS ====================-->
  <section class="logo section">
    <div class="logo__container container grid">
      <?php foreach ($sponsors as $sponsor): ?>
        <?= Html::img($sponsor->getImage(), ['alt' => $sponsor->name]) ?>
      <?php endforeach ?>
    </div>
  </section>

  <!--==================== BLOG ====================-->
  <section class="blog section" id="blog">
    <div class="blog__container container">
      <h2 class="section__title"><?= Yii::t("app", "Our Blogs Coffee with trending topic for this week") ?></h2>

      <div class="blog__content grid">
        <?php foreach ($blogs as $blog): ?>
          <article class="blog__card" id="blog-<?= $blog->id ?>">
            <div class="blog__image">
              <?= Html::img($blog->getImages()['thumbnail_image'], ['class' => 'blog__img']) ?>
              <button onclick="modals.blog.show()" class="blog__button" hx-get="/site/blog?slug=<?= $blog->slug ?>" hx-target="#blogModal" hx-swap="innerHTML">

                <i class="bx bx-right-arrow-alt"></i>
              </button>
            </div>

            <div class="blog__data">
              <h2 class="blog__title">
                <?= $blog ?>
              </h2>
              <p class="blog__description">
                <?= $blog->getShortHighlight() ?>
              </p>

              <div class="blog__footer">
                <div class="blog__reaction">
                  <i class="bx bx-comment"></i>
                  <span class="blog__reaction-comment"><?= count($blog->comments) ?></span>
                </div>

                <div class="blog__reaction">
                  <i class="bx bx-show"></i>
                  <span class="blog__reaction-views"><?= $blog->views ?></span>
                </div>
              </div>
            </div>
          </article>
        <?php endforeach ?>

      </div>
    </div>
  </section>
</main>

<!--==================== FOOTER ====================-->
<footer class="footer">
  <div class="footer__container container">
    <h1 class="footer__title">Coffee.</h1>

    <div class="footer__content grid">
      <div class="footer__data">
        <p class="footer__description"><?= Yii::t("app", "Subscribe to our newsletter") ?></p>

        <?php $form = ActiveForm::begin() ?>
        <div style="display: flex; justify-content: center; align-items: center; gap: 12px;">
          <?= $form->field($newsLetterModel, 'email', ['template' => '{input}', 'options' => ['tag' => false]])->input('email', ['placeholder' => Yii::t("app", "Your email..."), 'required' => true, 'class' => 'footer__input']) ?>
          <button class="footer__button" type="submit">
            <i class="bx bx-right-arrow-alt"></i>
          </button>

        </div>
        <?php $form->end() ?>
      </div>
      <div class="footer__data">
        <h2 class="footer__subtitle"><?= Yii::t("app", "Address") ?></h2>
        <p class="footer__information">
          <?= $siteInfo->address ?> <br>
          <?= $siteInfo->secondary_address ?>
        </p>
      </div>
      <div class="footer__data">
        <h2 class="footer__subtitle"><?= Yii::t("app", "Contact") ?></h2>
        <p class="footer__information">
          <?= $siteInfo->phone_number ?> <br>
          <?= $siteInfo->email ?>
        </p>
      </div>
      <div class="footer__data">
        <h2 class="footer__subtitle"><?= Yii::t("app", "Office") ?></h2>
        <p class="footer__information">
          <?= $siteInfo->start_week ?> - <?= $siteInfo->end_week ?> <br>
          <?= $siteInfo->start_time ?> - <?= $siteInfo->end_time ?>
        </p>
      </div>
    </div>

    <div class="footer__group">
      <ul class="footer__social">
        <a target="_blank" href="<?= $siteInfo->facebook_url ?>" class="footer__social-link">
          <i class="bx bxl-facebook"></i>
        </a>
        <a target="_blank" href="<?= $siteInfo->instagram_url ?>" class="footer__social-link">
          <i class="bx bxl-instagram"></i>
        </a>
        <a target="_blank" href="<?= $siteInfo->telegram_url ?>" class="footer__social-link">
          <i class="bx bxl-telegram"></i>
        </a>
      </ul>

      <div class="footer__copy">
        &#169; by Omonjon Sobirov. All rigths reserved (2022)
      </div>
    </div>
  </div>
</footer>


<!--========== SCROLL UP ==========-->
<a href="#" class="scrollup" id="scroll-up">
  <i class="bx bx-up-arrow-alt"></i>
</a>
