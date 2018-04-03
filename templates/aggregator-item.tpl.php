<?php

/**
 * @file
 * Default theme implementation to format an individual feed item for display
 * on the aggregator page.
 */
?>
<article class="feed-item">

  <header>
    <h3>
      <a href="<?php print $feed_url; ?>"><?php print $feed_title; ?></a>
    </h3>
    <p class="submitted">
      <?php if ($source_url) : ?>
        <a href="<?php print $source_url; ?>" class="feed-item-source"><?php print $source_title; ?></a> - 
      <?php endif; ?>
      <span class="feed-item-date"><?php print $source_date; ?></span>
    </p>
  </header>

  <?php if ($content) : ?>
    <div class="content">
      <?php print $content; ?>
    </div>
  <?php endif; ?>

  <?php if ($categories): ?>
    <footer>
      <p class="categories"><?php print t('Categories'); ?>: <?php print implode(', ', $categories); ?></p>
    </footer>
  <?php endif; ?>

</article> <!-- /.feed-item -->
