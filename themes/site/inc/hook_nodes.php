<?php

use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;


/**
 * Implements hook_preprocess_HOOK().
 */
function site_preprocess_node( &$variables ) {
	//$node = \Drupal::routeMatch()->getParameter('node');
	$node = $variables['node'];
	if ( $node instanceof \Drupal\node\NodeInterface ) {
		if ( $node->bundle() == "gallerie" ) {
			$gallerie = $node->get( 'field_images' )->getValue();
			$variables["gallerie"] = [];
			foreach ( $gallerie as $photo ) {
				$file = File::load( $photo['target_id'] );
				if ( ! empty( $file ) ) {
					$path     = $file->getFileUri();
					$urlImage = file_create_url( ImageStyle::load( 'large' )->buildUrl( $path ) );
					$urlImageOrignal = file_create_url($path);
					$altImage = $photo['alt'];
					$variables["gallerie"][] = ["url" => $urlImage, "alt" => $altImage, "urlOrig" => $urlImageOrignal];
				}
			}
		}
	}
}