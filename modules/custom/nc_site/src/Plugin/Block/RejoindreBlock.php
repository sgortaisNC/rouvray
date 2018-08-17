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
		$data      = [];
		$config    = \Drupal::config( 'ncsite.config.rejoindre' );
		$formation = Node::load( $config->get( 'formation' ) );

		//Image
		$urlImage = $altImage = '';
		if ( ! empty( $formation ) ) {
			if ( count( $formation->get( 'field_image' )->getValue() ) > 0 ) {
				$file = File::load( $formation->get( 'field_image' )->getValue()[0]['target_id'] );
				if ( ! empty( $file ) ) {
					$path     = $file->getFileUri();
					$urlImage = file_create_url( ImageStyle::load( 'detail' )->buildUrl( $path ) );
					if ( count( $formation->get( 'field_image' )->getValue() ) > 0 ) {
						$altImage = $formation->get( 'field_image' )->getValue()[0]['alt'];
					} else {
						$altImage = $formation->getTitle();
					}
				}
			} else {
				$fileUuid = $formation->get( 'field_image' )->getSetting( 'default_image' )['uuid'];
				$file     = \Drupal::service( 'entity.repository' )->loadEntityByUuid( 'file', $fileUuid );
				if ( ! empty( $file ) ) {
					$path     = $file->getFileUri();
					$urlImage = file_create_url( ImageStyle::load( 'detail' )->buildUrl( $path ) );
					$altImage = $formation->getTitle();
				}
			}


			//Summary
			$summary = Html::normalize( Unicode::truncate( strip_tags( $formation->get( 'body' )->getValue()[0]['value'] ), 150 ) . '...' );

			//Offres d'emploi
			$query  = \Drupal::entityQuery( 'node' )
			                 ->condition( 'status', '1' )
			                 ->condition( 'type', 'offre' );
			$result = $query->count()->execute();

			$data = [
				'formation'   => [
					'title'   => $formation->getTitle(),
					'summary' => $summary,
					'image'   => [
						'url' => $urlImage,
						'alt' => $altImage,
					],
					'link'    => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $formation->id() ),
					'url'     => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/110' ),
				],
				'offre'       => [
					'url' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/113' ),
					'nb'  => (int) $result,
				],
				'candidature' => [
					'url' => "/form/deposer-une-candidature",
				],
			];
		}

		if ( count( $data ) > 0 ) {
			$build = [
				'#theme' => 'rejoindre',
				'#data'  => $data,
			];
		} else {
			$build = [];
		}

		return $build;
	}

	public function getCacheTags() {
		//With this when your node change your block will rebuild
		if ( $node = \Drupal::routeMatch()->getParameter( 'node' ) ) {
			//if there is node add its cachetag
			return Cache::mergeTags( parent::getCacheTags(), array( 'node:' . $node->id() ) );
		} else {
			//Return default tags instead.
			return parent::getCacheTags();
		}
	}

	public function getCacheContexts() {
		//if you depends on \Drupal::routeMatch()
		//you must set context of this block with 'route' context tag.
		//Every new route this block will rebuild
		return Cache::mergeContexts( parent::getCacheContexts(), array( 'route' ) );
	}
}
