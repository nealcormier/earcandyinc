<?php

/**
 * @file
 * Default theme implementation to present feeds as list items.
 */
?>
<section id="feed-<?php print $title; ?>" class="feed">
  <h3><?php print $title; ?></h3>
  <?php print $summary_list; ?>
  <div class="links">
    <a href="<?php print $source_url; ?>"><?php print t('More'); ?></a>
  </div>
</section> <!-- /.feed -->
