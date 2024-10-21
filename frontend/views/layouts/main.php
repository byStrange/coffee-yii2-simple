<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--=============== DESCRIPTION ===============-->
  <meta name="description" content="by Omonjon Sobirov">

  <!--=============== FAVICON ===============-->
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

  <?php $this->head() ?>

  <title>Coffee</title>
</head>

<body class="d-flex flex-column h-100">
  <?php $this->beginBody() ?>

  <script>
    class Modal {
      static modals = [];
      constructor(id, onChange) {
        this.id = id;
        this.element = null;
        this.commonClass = "fixed inset-0 overflow-y-auto h-full w-full hidden";
        this.onChange = typeof onChange == 'function' ? onChange : null;
        this.render();
      }


      _init_observer() {
        const observer = new MutationObserver((mutationsList) => {
          for (const mutation of mutationsList) {
            if (mutation.type == 'childList') {
              this.onChange(mutation, this.element);
            }
          }
        });

        observer.observe(this.element, {
          childList: true
        })
      }
      render() {
        console.log(this)
        if (document.getElementById(this.id)) {
          console.warn('Modal with id ' + this.id + ' already exists.');
          return;
        }

        const div = document.createElement('div');
        this.element = div;

        div.className = (this.commonClass);
        div.style.padding = "20px 0"
        div.style.zIndex = 9999;
        div.style.backgroundColor = "rgba(0,0, 0, .2)";
        div.style.backdropFilter = "blur(24px)";
        div.id = this.id;


        div.onclick = (e) => {
          if (e.target == div) {
            this.hide();
          }
        }

        if (this.onChange) {
          this._init_observer();
        }

        document.body.appendChild(div);
        Modal.modals.push(this);
      }

      show() {
        Modal.modals.forEach(modal => {
          modal.hide();
        });
        this.lockBodyScroll();
        this.element.classList.remove("hidden");
      }
      hide() {
        this.unlockBodyScroll();
        this.element.classList.add("hidden");
      }

      unlockBodyScroll() {
        document.body.style.overflow = '';
      }

      lockBodyScroll() {
        console.log('what')
        document.body.style.overflow = 'hidden';
      }

      static create(id, onChange) {
        var modal = new Modal(id, onChange);
        return modal;
      }
    }


    const modals = {
      checkout: Modal.create('checkoutModal', (change, el) => {}),
      cart: Modal.create('cartModal'),
      blog: Modal.create('blogModal', (change, el) => {
        const blogWrapper = el.children[0];
        const {
          viewsCount,
          commentsCount,
          id
        } = blogWrapper.dataset;
        const blogCard = document.getElementById('blog-' + id);
        blogCard.querySelector('.blog__reaction-comment').innerText = commentsCount;
        blogCard.querySelector('.blog__reaction-views').innerText = viewsCount;
      }),
    }

    window.modals = modals;
  </script>



  <?= $content ?>


  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
