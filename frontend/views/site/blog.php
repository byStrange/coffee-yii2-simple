<div class="blog-container" data-comments-count="<?= $blog->comments ? count($blog->comments) : 0 ?>"
  data-views-count="<?= $blog->views ?>" data-id="<?= $blog->id ?>">
  <header class="blog-header">
    <h1><?= Yii::t('app', 'Blog Title: {title}', ['title' => $blog]) ?></h1> <!-- Assuming $blog has a title property -->
    <div class="blog-post-meta">
      <span>
        <?= Yii::t('app', 'Posted on {date} by {author}', [
          'date' => Yii::$app->formatter->asDate($blog->created_at, 'medium'),
          'author' => $blog->author
        ]) ?>
      </span>
      <span class="views-count"><?= Yii::t('app', 'Views: {count}', ['count' => number_format($blog->views)]) ?></span>
    </div>
  </header>

  <img src="<?= $blog->getImages()['main_image'] ?>" alt="<?= Yii::t('app', 'Web Design Illustration') ?>" class="blog-featured-image">

  <article class="blog-post-content">
    <?= Yii::t('app', 'Content: {content}', ['content' => $blog->body]) ?>
  </article>

  <div class="comments-section">
    <?php

    use yii\widgets\ActiveForm; ?>

    <?php if ($blog->comments && count($blog->comments) > 0): ?>
      <h3><?= Yii::t('app', 'Comments {count}', ['count' => count($blog->comments)]) ?></h3>

      <?php foreach ($blog->comments as $comment): ?>
        <div class="comment">
          <div class="comment-author"><?= $comment->user ?></div>
          <div class="comment-text"><?= $comment->comment_text ?></div>
        </div>
      <?php endforeach; ?>

    <?php else: ?>

      <p><?= Yii::t('app', 'No comments yet.') ?></p>

    <?php endif; ?>

    <div class="comment-form">
      <h3><?= Yii::t('app', 'Post a Comment') ?></h3>
      <?php if (Yii::$app->user->isGuest): ?>
        <p><?= Yii::t('app', 'Please {loginLink} or {registerLink} to post a comment.', [
              'loginLink' => '<a href="/login" class="nav__link">' . Yii::t('app', 'login') . '</a>',
              'registerLink' => '<a href="/register" class="nav__link">' . Yii::t('app', 'register') . '</a>',
            ]) ?></p>
      <?php else: ?>
        <?php $form = ActiveForm::begin(['options' => [
          'hx-swap' => 'innerHTML',
          'hx-target' => '#blogModal',
          'hx-post' => '/site/blog?slug=' . $blog->slug,
        ]]) ?>

        <?= $form->field($commentModel, 'comment_text')->textarea(['rows' => 6]) ?>

        <button type="submit" class="submit-btn"><?= Yii::t('app', 'Post Comment') ?></button>

        <div class="error-message" id="error-message" style="display: none;">
          <?= Yii::t('app', 'Please fill out both fields before submitting.') ?>
        </div>
        <?php ActiveForm::end() ?>
      <?php endif; ?>
    </div>
  </div>
</div>
</div>
