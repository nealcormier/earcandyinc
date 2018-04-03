<?php
/**
 * @file */
 */
function earcandyinc_form_system_theme_settings_alter(&$form, $form_state) {

    $form['earcandyinc'] = array(
      '#type'        => 'vertical_tabs',
      '#title'       => t('earcandyinc theme settings'),
      '#description' => t('Layout'),
      '#weight'      => -10,
      // Attach earcandyinc custom Css file - to be used when extending and
      // glorifying the theme-settings form.
      '#attached'    => array(
        'css' => array(drupal_get_path('theme', 'earcandyinc') . '/styles/ff.settings.form.css'),
      ),
    );
  
  // Social Urls.
  $form['earcandyinc']['general'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('General'),
    '#collapsible' => TRUE,
  );
  
  // Show/Hide page titles on taxonomy term pages. 
  $form['earcandyinc']['general']['hide_page_tile'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Hide page title on Taxonomy term pages'),
    '#default_value' => theme_get_setting('hide_page_tile'),
    '#description'   => t("By default, In EarCandyInc theme, we don't display the page title on taxonomy term pages. If you want to display The title uncheck this checkbox."),
  );
  
  $form['earcandyinc']['general']['show_lang_links'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Multilingual - Display languages links in Main menu'),
    '#default_value' => theme_get_setting('show_lang_links'),
    '#description'   => t("By default, earcandyinc dispalys in main menu link to homepage of each enabled language. Uncheck this checkbox and Language links will not auto displayed."),
  );
  

  // Social Urls.
  $form['earcandyinc']['social'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Social Media URLs'),
    '#collapsible' => TRUE,
  );

  $form['earcandyinc']['social']['facebook'] = array(
    '#type'             => 'textfield',
    '#title'            => t('Facebook Link'),
    '#default_value'    => theme_get_setting('facebook'),
    '#description'      => t('Your Facebook page link'),
    '#element_validate' => array('earcandyinc_social_url_validate'),
  );

  $form['earcandyinc']['social']['twitter'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Twitter Link'),
    '#default_value' => theme_get_setting('twitter'),
    '#description'   => t('Your Twitter page link'),
    '#element_validate' => array('earcandyinc_social_url_validate'),
  );

  $form['earcandyinc']['social']['dribble'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Dribble Link'),
    '#default_value' => theme_get_setting('dribble'),
    '#description'   => t('Your Dribble page link'),
    '#element_validate' => array('earcandyinc_social_url_validate'),
  );

  $form['earcandyinc']['social']['plus'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Google+ Link'),
    '#default_value' => theme_get_setting('plus'),
    '#description'   => t('Your Google+ page link'),
    '#element_validate' => array('earcandyinc_social_url_validate'),
  );
}

/**
 * Validate social urls with valid_url();
 */
function earcandyinc_social_url_validate($element, &$form_state, $form) {
  if ($element['#value'] && !valid_url($element['#value'], TRUE)) {
    form_set_error($element['#name'], t('The @social_url is not valid URL. Please try to copy/paste it one more time.', array('@social_url' => $element['#title'])));
  }
}
