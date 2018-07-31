<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Liste - Page sécurisées' Block.
 *
 * @Block(
 *   id = "nc_liste_secured",
 *   admin_label = @Translation("Liste - Page sécurisées - Bloc"),
 * )
 */
class ListesecuredBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'secured' ], 'IN' )
		      ->condition( 'status', 1 );

		$nids = $query->sort( 'changed', 'DESC' )
		              ->pager( 25 )
		              ->execute();


		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {
					$image = "";
					if ( ! empty( $nodeContent->get( "field_image" )->getValue()[0]['target_id'] ) ) {
						$image = file_create_url( File::load( $nodeContent->get( "field_image" )->getValue()[0]['target_id'] )->getFileUri() );
					}
					$body = "";
					if ( ! empty( $nodeContent->get( "body" )->getValue()[0]["value"] ) ) {
						$body = strlen( $nodeContent->get( "body" )->getValue()[0]["value"] ) > 175 ? substr( $nodeContent->get( "body" )->getValue()[0]["value"], 0, 175 ) . "..." : $nodeContent->get( "body" )->getValue()[0]["value"];
					}
					$contents[] = [
						'title' => $nodeContent->getTitle(),
						"image" => [
							"url" => $image,
							"alt" => ! empty( $nodeContent->get( "field_image" )->getValue()[0]['alt'] ) ? $nodeContent->get( "field_image" )->getValue()[0]['alt'] : ""
						],
						"body"  => $body,
						'url'   => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}

		$build = [
			'liste' => [
				'#theme' => 'securedliste',
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
