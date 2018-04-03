<?php

/**
 * This page contains a mix of overrides for ECE. Edge Suite is substituted here rather than a module. 
 */

function earcandyinc_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Override or insert variables into the html template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function earcandyinc_preprocess_html(&$vars) {
  // We want to use core's body class 'no-sidebars' but is useless for us
  // because it doesn't ccounts earcandyinc's 'sidebar' region as sidebar.
  // So we first remove it.
  $vars['classes_array'] = array_diff($vars['classes_array'], array('no-sidebars'));
  // And puyll it back it if it is appropriate. 
      if ( empty($vars['page']['sidebar']) ) {
        $vars['classes_array'][] = 'no-sidebars';
      }

      $vars['path_to_earcandyinc'] = drupal_get_path('theme', 'earcandyinc');
      $vars['base_path'] = base_path();
        
  // Attributes for html element.
  $vars['html_attributes_array'] = array(
    'lang' => $vars['language']->language,
    'dir'  => $vars['language']->dir,
  );
  // Send X-UA-Compatible HTTP header to force IE to use the most recent
  // rendering engine or use Chrome's frame rendering engine if available.
  // This also prevents the IE compatibility mode button to appear when using
  // conditional classes on the html tag.
      if (is_null(drupal_get_http_header('X-UA-Compatible'))) {
        drupal_add_http_header('X-UA-Compatible', 'IE=edge,chrome=1');
      }
   
  // We want to insert inline css rules based on EarCandyInc theme settings.
  $bg_color = check_plain(theme_get_setting('body_bg_color'));
  $data = 'body { background-color: ' . $bg_color . '}';
  drupal_add_css($data, 'inline');

}

/**
 * Override or insert vars into the html templates.
 *
 * @param $vars
 *   An array of vars to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function earcandyinc_process_html(&$vars, $hook) {
  // Flatten out html_attributes.
  $vars['html_attributes'] = drupal_attributes($vars['html_attributes_array']);
}

/**
 * Override or insert vars in the html_tag theme function.
 */
function earcandyinc_process_html_tag(&$vars) {
  $tag = &$vars['element'];

  if ($tag['#tag'] == 'style' || $tag['#tag'] == 'script') {
    // Remove redundant type attribute and CDATA comments.
    unset($tag['#attributes']['type'], $tag['#value_prefix'], $tag['#value_suffix']);

    // Remove media="all" but leave others unaffected.
    if (isset($tag['#attributes']['media']) && $tag['#attributes']['media'] === 'all') {
      unset($tag['#attributes']['media']);
    }
  }
}

/**
 * Override or insert vars into the page template. 
 */


 */
function earcandyinc_preprocess_page(&$vars) {

  // Create variables according to theme settings information.
  $social['facebook'] = theme_get_setting('facebook');
  $social['twitter']  = theme_get_setting('twitter');
  $social['plus']     = theme_get_setting('plus');
  $social['dribble']  = theme_get_setting('dribble');
  $vars['social_links'] = '';

  // Set $options['html'] to TRUE to enable image as l() function text
  $options['html'] = TRUE;
  foreach ($social as $key => $value) {
    if ($value != '') {
      $imgvars['path'] = drupal_get_path('theme', 'earcandyinc') . '/styles/images/' . $key . '-icon.png';
      $imgvars['attributes']['class'] = array($key);
      if ($key == 'plus') {
        $key = 'Google+';
      }
      $imgvars['alt'] = t("@site_name's at @social_network", array(
        '@social_network' => $key,
        '@site_name' => $vars['site_name'],
      ));
      $icon = theme('image', $imgvars);
      $vars['social_links'] .= l($icon, $value, $options);
    }
  }

  // Show page title on taxonomy term pages?
  if (arg(0) == 'taxonomy' && arg(1) == 'term' && theme_get_setting('hide_page_tile') == 1) {
    $vars['title'] = '';
  }

  // If site is multilingual and not disabled in theme settings Create links to all
  // frontpages in all enabled languages and attach them to main manu.
  $vars['lang_links'] = array();
  if (theme_get_setting('show_lang_links') == 1) {
    $languages = language_list('enabled');
    if (count($languages[1]) > 1) {
      // We dont want to include language code
      // as part of the default language frontpage link.
      $default_lang_object = language_default();
          $default_lang = $default_lang_object->language;
          global $base_url;
          foreach ($languages[1] as $language) {
            if ($vars['language']->language != $language->language) {
              if ($language->language == $default_lang) {
                $href = $base_url . '/';
          }
          else {
            $href = $base_url . '/' . $language->language;
          }
          $vars['lang_links'][$language->language] = array(
            'href' => $href,
            'title' => $language->native,
            'attributes' => array('class' => array('language-link')),
          );
          // Insert language links to main_menu array of links.

              // Implements hook_permission() for Edge Suite 2.
            if(drupal_is_front_page()) {
                drupal_add_js(drupal_get_path('theme', 'earcandyinc') . '/hompageanimation/edge_includes/edge.6.0.0.min.js');
                drupal_add_js(drupal_get_path('theme', 'earcandyinc') . '/homepageanimation/index.js');
              }
              // Implements hook_permission() for Edge Suite 2.
               if (!empty($variables['node']) && $variables['node']->type == 'djshow') {
                  $variables['show_title'] = FALSE;
              }

          if (isset($vars['node']->type)) {
            // If the content type's machine name is "my_machine_name" the file
            // name will be "page--my-machine-name.tpl.php". - Keep in mind that this will only work if class is set to column-one. 
            $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;
          }

        }
      }
    }
  }
}

/**
 * Override or insert vars into the node template.
 */
function earcandyinc_preprocess_node(&$vars) {
  if ($vars['view_mode'] == 'full' && node_is_page($vars['node'])) {
    // @TODOS: see if needed.
    $vars['classes_array'][] = 'node-full';
  }
     else {
    
        static $numbered = 1;
    
    $teaser_box_type = 'post-box';
    
    if (arg(0) == 'blog' && !($vars['is_front'])) {
      $teaser_box_type = 'blog-box';
    }
    
        $vars['classes_array'][] = $vars['zebra'];
    
      // Set first teaser node classes to allow the bigger dimentions for first teaser.
          if ($numbered == 1) {
            $vars['classes_array'][] = 'first';
            $numbered++;
            if ($vars['is_front']) {
              $teaser_box_type = 'big-post-box';
            }
          }

    $vars['classes_array'][] = $teaser_box_type;
  }
}

/**
 * Override or insert vars into the block template.
 */
function earcandyinc_preprocess_block(&$vars) {

  // On sidebar block insert 'side-box' class.
  if ($vars['elements']['#block']->region == 'sidebar') {
    $vars['classes_array'][] = 'side-box';
  }
}

/**
 * Implements hook_form_FORM_ID_alter.
 */
function earcandyinc_form_search_block_form_alter(&$form, &$form_state, $form_id) {
  $form['search_block_form']['#title'] = t('Search');
  $form['search_block_form']['#title_display'] = 'invisible';
  $form['search_block_form']['#default_value'] = t('Search');
  $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = '" . t('Search') . "';}";
  $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == '" . t('Search') . "') {this.value = '';}";

  // Submit Button.
  $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/styles/images/search-icon.png');
  $form['actions']['submit']['#attributes']['class'] = array('search_icon');
}


/**
 * Overrides core theme_pager function to manipulate pager classes
 */
function earcandyinc_pager($vars) {
  $tags = $vars['tags'];
  $element = $vars['element'];
  $parameters = $vars['parameters'];
  $quantity = $vars['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // Current is the page we are currently paged to.
  $pager_current = $pager_page_array[$element] + 1;
  // First is the first page listed by this pager piece (re quantity).
  $pager_first = $pager_current - $pager_middle + 1;
  // Last is the last page listed by this pager piece (re quantity).
  $pager_last = $pager_current + $quantity - $pager_middle;
  // Max is the maximum page number.
  $pager_max = $pager_total[$element];
  // End of marker calculations.
  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.
  $li_first = theme('pager_first', array(
    'text' => (isset($tags[0]) ? $tags[0] : t('« first')),
    'element' => $element,
    'parameters' => $parameters,
    ));
  $li_previous = theme('pager_previous', array(
    'text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters,
    ));
  $li_next = theme('pager_next', array(
    'text' => (isset($tags[3]) ? $tags[3] : t('next ›')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters,
    ));
  $li_last = theme('pager_last', array(
  'text' => (isset($tags[4]) ? $tags[4] : t('last »')),
  'element' => $element,
  'parameters' => $parameters,
  ));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first', 'load_more_text'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous', 'load_more_text'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis', 'load_more_text'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item', 'load_more_text'),
            'data' => theme('pager_previous', array(
              'text' => $i,
              'element' => $element,
              'interval' => ($pager_current - $i),
              'parameters' => $parameters,
              )),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current', 'load_more_text'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item', 'load_more_text'),
            'data' => theme('pager_next', array(
              'text' => $i,
              'element' => $element,
              'interval' => ($i - $pager_current),
              'parameters' => $parameters,
              )),
          );
        }
      }
          if ($i < $pager_max) {
            $items[] = array(
              'class' => array('pager-ellipsis', 'load_more_text'),
              'data' => '…',
            );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next', 'load_more_text'),
        'data' => $li_next,
      );
    }
      if ($li_last) {
        $items[] = array(
          'class' => array('pager-last', 'load_more_text'),
          'data' => $li_last,
        );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager', 'load_more_cont')),
    ));
  }
}


function earcandyinc_feed_icon($vars) {
  $path = drupal_get_path('theme', 'earcandyinc') . '/styles/images/feed.png';
  $text = t('Subscribe to @feed-title', array('@feed-title' => $vars['title']));
  if ($image = theme('image', array(
              'path' => $path,
              'width' => 20,
              'height' => 20,
              'alt' => $text,
    ))) {
    return l($image, $vars['url'], array(
    'html' => TRUE,
    'attributes' => array('class' => array('feed-icon'), 'title' => $text),
    ));
  }
}



/**
 * Implements hook_form_alter(). This is a Parallax Settings Page (w/ module) that I have embedded notes for under each respective box or select field etc.
 */
function earcandyinc_parallax_block_form_alter(&$form, &$form_state, $form_id) {
  if (($form_id == 'block_admin_configure') || ($form_id == 'block_add_block_form')) {
    $block = block_load($form['module']['#value'], $form['delta']['#value']);

    $form['settings']['parallax'] = array(
      '#type'         => 'fieldset',
      '#title'        => t('Parallax 2 Settings'),
      '#collapsible'  => FALSE,
    );

    $form['settings']['parallax']['vertical_parallax_value'] = array(
      '#title'    => t('Vertical Parallax Direction: Note: Is ONLY Set Upon Initial Reload'),
      '#type'     => 'select',
      '#options'  => array(
        'none' => t('None'),
        'top-to-bottom' => t('Move to bottom on scroll (fast effect - override bug note)'),
        'bottom-to-top' => t('Move to top on scroll (slow effect - need bug fix for slide speed to work)'),
      ),
      '#default_value' => isset($block->vertical_parallax_value) ? $block->vertical_parallax_value : 'none',
    );

    $form['settings']['parallax']['horizontal_parallax_value'] = array(
      '#title'    => t('Horizontal Parallax Direction'),
      '#type'     => 'select',
      '#options'  => array(
        'none' => t('None'),
        'left-to-right' => t('Move to left on scroll - Conflicts with Edge Suite'),
        'right-to-left' => t('Move to right on scroll - Conflicts with Edge Suite'),
      ),
      '#default_value' => isset($block->horizontal_parallax_value) ? $block->horizontal_parallax_value : 'none',
    );

    $form['settings']['parallax']['background_image'] = array(
      '#title'                => t('Background Image Pane'),
      '#type'                 => 'managed_file',
      '#description'          => t('Replace all spaces in file name with dashes. Larger pictures are recommended.'),
      '#default_value'        => isset($block->background_image) ? $block->background_image : '',
      '#upload_location'      => 'public://parallax_block/',
      '#upload_validators'    => array(
        'file_validate_extensions' => array('gif png jpg jpeg'),
        'file_validate_size'  => array(2 * 1024 * 1024),
      ),
    );

    $form['settings']['parallax']['background_size'] = array(
      '#title'            => t('Background Size'),
      '#type'             => 'textfield',
      '#size'             => 60,
      '#default_value'    => isset($block->background_size) ? $block->background_size : 'none',
      '#description'      => t('Acceptable values are none, cover, contain, or percentages/pixels in the form of "200px" and "200%". If there is no effect, try altering this value.'),
      '#maxlength'        => 20,
      '#required'         => FALSE,
      '#element_validate' => array('parallax_block_validate_size'),
    );

    $form['#submit'][] = 'parallax_block_form_submit';
  }
}




/**
 * Implements hook_menu() for ES.
 */
function earcandyinc_edge_suite_menu() {
  $items['admin/config/media/edge_suite'] = array(
    'title' => 'Edge Suite ECE',
    'description' => 'Configure general Edge Suite settings.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_settings'),
    'access arguments' => array('administer edge suite'),
    'file' => 'includes/edge_suite.admin.inc',
    'type' => MENU_NORMAL_ITEM,
  );

  $items['admin/structure/edge_suite'] = array(
    'title' => 'Edge Suite ECE',
    'description' => 'Import, manage and configure your Edge content.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_admin_form'),
    'access arguments' => array('administer edge suite'),
    'file' => 'includes/edge_suite_ece.admin.inc',
  );

  // Composition definition actions: add instance, rebuild, reupload, delete.
  $items['admin/structure/edge_suite/%/add'] = array(
    'title' => 'Add instance to ECE Form',
    'description' => 'Add a new instance of a ECE compositions, e.g. a block.',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_instance_form_add', 3),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('create instance', 3),
    'file' => 'includes/edge_suite.admin.inc',
  );

  $items['admin/structure/edge_suite/%/edit/%'] = array(
    'title' => 'Edit composition instance',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_instance_form_edit', 3, 5),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('edit instance', 3, 5),
    'file' => 'includes/edge_suite.admin.inc',
  );

  $items['admin/structure/edge_suite/%/edit/%/configure'] = array(
    'title' => 'Edit composition',
    'type' => MENU_DEFAULT_LOCAL_TASK,
    'context' => MENU_CONTEXT_INLINE,
  );

  $items['admin/structure/edge_suite/%/reupload'] = array(
    'title' => 'Reupload composition',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_definition_reupload_confirm', 3),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('reupload definition', 3),
    'file' => 'includes/edge_suite.admin.inc',
  );

  $items['admin/structure/edge_suite/%/delete'] = array(
    'title' => 'Delete composition',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_definition_delete_confirm', 3),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('delete definition', 3),
    'file' => 'includes/edge_suite.admin.inc',
  );

  $items['admin/structure/edge_suite/%/rebuild'] = array(
    'title' => 'Rebuild composition',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_definition_rebuild_confirm', 3),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('rebuild definition', 3),
    'file' => 'includes/edge_suite.admin.inc',
  );

  // Composition instance actions: test, edit, delete.
  $items['admin/structure/edge_suite/%/test/%'] = array(
    'title' => 'Instance testing',
    'description' => 'Testing of an instance',
    'page callback' => 'edge_suite_instance_callback',
    'page arguments' => array(5, 'testing'),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('test instance', 3, 5),
    'file' => 'includes/edge_suite.admin.inc',
  );

  $items['admin/structure/edge_suite/%/delete/%'] = array(
    'title' => 'Delete composition instance',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('edge_suite_instance_delete_confirm', 3, 5),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('delete instance', 3, 5),
    'file' => 'includes/edge_suite.admin.inc',
  );

  $items['edge_suite/iframe/%'] = array(
    'title' => 'Edge iframe',
    'page callback' => 'edge_suite_instance_callback',
    'page arguments' => array(2, 'iframe', 3),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('view iframe', 3),
  );

  $items['edge_suite/iframe/data/%'] = array(
    'title' => 'Edge iframe',
    'page callback' => 'edge_suite_instance_callback',
    'page arguments' => array(3, 'data'),
    'access callback' => 'edge_suite_access',
    'access arguments' => array('view iframe', 3),
  );

  return $items;
}

/**
 * Implements hook_permission() for Edge Suite 2.
 */
function earcandyinc_edge_suite_permission() {
  // Todo urgent: Implement permissions.
  return array(
    'administer edge suite' => array(
      'title' => t('Administer Edge suite'),
      'description' => t('Fully administrate Edge suite.'),
      'restrict access' => TRUE,
    ),
  );
}










