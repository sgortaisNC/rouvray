<?php

function site_form_system_theme_settings_alter( &$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = null ) {
	// Work-around for a core bug affecting admin themes. See issue #943212.
	if ( isset( $form_id ) ) {
		return;
	}

	$form['site_options'] = [
		'#type'  => 'fieldset',
		'#title' => "Options complèmentaires",
		'#tree'  => true,
	];

	$form['site_options']['site_robots'] = array(
		'#type'          => 'checkbox',
		'#title'         => "Ne pas montrer mon site aux robots de référencement",
		'#default_value' => theme_get_setting( 'site_options.site_robots' ),
		'#description'   => "Si la case est coché les balises no-index/no-follow s'afficheront sur le site",
	);
}

function site_preprocess_search_result( &$variables ) {
	if ( isset( $variables['result']['node']->type ) ) {
		$correpondance = [
			"article"      => "calendar-alt",
			"concours"     => "user-graduate",
			"consultation" => "user-md",
			"formation"    => "notes-medical",
			"offre"        => "briefcase",
			"page"         => "file-alt",
			"secured"      => "lock",
		];

		$correpondanceT = [
			"article"      => "Actualité",
			"concours"     => "Concours",
			"consultation" => "Consultation",
			"formation"    => "Formation",
			"offre"        => "Offre d'emploi",
			"page"         => "Page",
			"secured"      => "Page securisée",
		];

		$variables['info_split']['icon'] = $correpondance[ $variables['result']['node']->getType() ];
		$variables['info_split']['type'] = $correpondanceT[ $variables['result']['node']->getType() ];
	}
}