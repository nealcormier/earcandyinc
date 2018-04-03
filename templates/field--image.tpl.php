<?php

/**
 * @file field--image.tpl.php
 */
 // In EarCandyInc the default node teasers galleries  can use only 
 // one image.
 
 if ( $element['#view_mode'] == 'teaser') {
  // $items contains only one item.
  $items = array_slice($items, 0, 1);
 }
?>

<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <div class="field-items"<?php print $content_attributes; ?>>
    <?php foreach ($items as $delta => $item): ?>
      <div class="field-item <?php print $delta % 2 ? 'odd' : 'even'; ?>"<?php print $item_attributes[$delta]; ?>><?php print render($item); ?></div>
    <?php endforeach; ?>
  </div>
</div>
