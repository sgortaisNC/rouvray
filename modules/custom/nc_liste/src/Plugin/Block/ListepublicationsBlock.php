<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Liste - Publications' Block.
 *
 * @Block(
 *   id = "nc_liste_publications",
 *   admin_label = @Translation("Liste - Page Publications - Bloc"),
 * )
 */
class ListepublicationsBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'public' ], 'IN' )
		      ->condition( 'status', 1 );

		$nids = $query->sort( 'changed', 'DESC' )
		              ->pager( 25 )
		              ->execute();


		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {

					$body = "";
					if ( ! empty( $nodeContent->get( "body" )->getValue()[0]["value"] ) ) {
						$body = strlen( $nodeContent->get( "body" )->getValue()[0]["value"] ) > 175 ? substr( $nodeContent->get( "body" )->getValue()[0]["value"], 0, 175 ) . "..." : $nodeContent->get( "body" )->getValue()[0]["value"];
					}


$uri = File::load($nodeContent->get( "field_files" )->getValue()[0]["target_id"])->getFileUri();

					$url = URL::fromUri($uri)->toString();

					$contents[] = [
						'title' => $nodeContent->getTitle(),
						"body"  => $body,
						'url'   => $url
					];
				}
			}
		}

		$build = [
			'liste' => [
				'#theme' => 'publicationliste',
				'#data'  => $contents,
			],
			'pager' => [
				'#type' => 'pager',
			],
		];

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
