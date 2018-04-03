
<?php

/**
 * @file
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
?><!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" <?php print $html_attributes; ?>><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7" <?php print $html_attributes; ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8" <?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9" <?php print $html_attributes; ?>><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html class="mdq-aware" <?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->

<head profile="<?php print $grddl_profile; ?>">

  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="cleartype" content="on">
  <?php print $styles; ?>
  <?php print $scripts; ?>

    <!--[if lt IE 9]>
    <script src="<?php print $base_path . $path_to_EarCandyInc; ?>/js/html5.js"></script>
    <![endif]-->
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>

</body>
</html>