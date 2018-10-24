<?php

function site_form_alter( &$form, \Drupal\Core\Form\FormStateInterface $form_state, $form_id ) {
	if ( ! empty( $form["#webform_id"] ) ) {
		if ( $form["#webform_id"] == "contact_et_inscription" ) {
			$title   = "";
			$request = \Drupal::request();
			if ( $route = $request->attributes->get( \Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT ) ) {
				$title = \Drupal::service( 'title_resolver' )->getTitle( $request, $route );
			}
			$form["elements"]['flexbox']['flexbox_01']["formation"]["#value"] = $title;
		}
	}

  if(strpos($form['#form_id'], 'webform_') !== false){
    if(isset($form['elements']['cnil'])){
      if(empty($form['elements']['cnil']['#markup'])){
        $form['elements']['cnil']['#markup'] = theme_get_setting( 'site_options.cnil' )['value'];
      }
    }
  }
}

function site_theme_suggestions_form_alter( array &$suggestions, array $variables ) {
	$suggestions[] = 'form__' . $variables["element"]["#form_id"];
}
