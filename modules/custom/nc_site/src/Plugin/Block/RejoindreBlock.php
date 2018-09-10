<?php

namespace Drupal\nc_site\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\node\Entity\Node;
use Drupal\Component\Utility\Unicode;
use Drupal\Component\Utility\Html;

/**
 * Provides a 'Home - Nous rejoindre' Block.
 *
 * @Block(
 *   id = "nc_site_rejoindre",
 *   admin_label = @Translation("Home - Nous rejoindre - Bloc"),
 * )
 */
class RejoindreBlock extends BlockBase {
	/**
	 * {@inheritdoc}
	 */
	public function build() {
		$data   = [];
		$config = \Drupal::config( 'ncsite.config.rejoindre' );

		$slider = [
			[
				"image"       => $config->get( "slide1.image" ),
				"titre"       => $config->get( "slide1.title" ),
				"url"         => $config->get( "slide1.url" ),
				"description" => strip_tags( $config->get( "slide1.description" ) )
			],
			[
				"image"       => $config->get( "slide2.image" ),
				"titre"       => $config->get( "slide2.title" ),
				"url"         => $config->get( "slide2.url" ),
				"description" => strip_tags( $config->get( "slide2.description" ) )
			],
			[
				"image"       => $config->get( "slide3.image" ),
				"titre"       => $config->get( "slide3.title" ),
				"url"         => $config->get( "slide3.url" ),
				"description" => strip_tags( $config->get( "slide3.description" ) )
			],
		];

		foreach ( $slider as $key => $slide ) {
			if ( ! empty( $slide["image"] ) ) {
				$file = File::load( $slide["image"][0] );
				if ( ! empty( $file ) ) {
					$path                    = $file->getFileUri();
					$urlImage                = file_create_url( ImageStyle::load( 'detail' )->buildUrl( $path ) );
					$slider[ $key ]["image"] = $urlImage;
				}
			}
		}


		//Offres d'emploi
		$query  = \Drupal::entityQuery( 'node' )
		                 ->condition( 'status', '1' )
		                 ->condition( 'type', 'offre' );
		$result = $query->count()->execute();

		$data = [
			'slider'      => $slider,
			'offre'       => [
				'url' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/113' ),
				'nb'  => (int) $result,
			],
			'candidature' => [
				'url' => "/form/deposer-une-candidature",
			],
		];


		if ( count( $data ) > 0 ) {
			$build = [
				'#theme' => 'rejoindre',
				'#data'  => $data,
			];
		}

		return $build;
	}

	public
	function getCacheTags() {
		//With this when your node change your block will rebuild
		if ( $node = \Drupal::routeMatch()->getParameter( 'node' ) ) {
			//if there is node add its cachetag
			return Cache::mergeTags( parent::getCacheTags(), array( 'node:' . $node->id() ) );
		} else {
			//Return default tags instead.
			return parent::getCacheTags();
		}
	}

	public
	function getCacheContexts() {
		//if you depends on \Drupal::routeMatch()
		//you must set context of this block with 'route' context tag.
		//Every new route this block will rebuild
		return Cache::mergeContexts( parent::getCacheContexts(), array( 'route' ) );
	}
}
