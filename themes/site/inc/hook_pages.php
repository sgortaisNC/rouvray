<?php 

function site_preprocess_page(&$variables) {
	// Config du site
	$site_config = \Drupal::config('system.site');

	// Site Name
	$variables['site_name'] = $site_config->get('name');
	// Slogan
	$variables['site_slogan'] = $site_config->get('slogan');
    //Logo Header
    $variables['logo_header'] = theme_get_setting('logo.url');
}

function site_page_attachments_alter(array &$attachments) {
    foreach ($attachments['#attached']['html_head'] as $key => $attachment) {
        if ($attachment[1] == 'system_meta_generator') {
            unset($attachments['#attached']['html_head'][$key]);
        }
    }
}