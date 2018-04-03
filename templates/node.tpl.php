<?php

?>
<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  
  <?php if (!$page): ?>
    <header>
      <?php print render($title_prefix); ?>
      <h3<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h3>
      <?php print render($title_suffix); ?>
      <?php 
        if ($display_submitted): ?>
          <div class="submitted">
            <?php print $submitted; ?>
          </div>
        <?php endif;
            ?>
    </header>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>
  <?php if ($page): ?>
    <footer>
      <?php print render($content['links']); ?>
      <?php print render($content['comments']); ?>
    </footer>
  <?php endif; ?>

</article>
