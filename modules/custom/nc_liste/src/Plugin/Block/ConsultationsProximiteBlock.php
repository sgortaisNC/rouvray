<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Liste - Consultations de proximité' Block.
 *
 * @Block(
 *   id = "nc_liste_consultations_proximite",
 *   admin_label = @Translation("Liste - Consultations de proximité - Bloc"),
 * )
 */
class ConsultationsProximiteBlock extends BlockBase {
	/**
	 * {@inheritdoc}
	 */
	public function build() {
		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'consultation' ], 'IN' )
		      ->condition( 'status', 1 )
		      ->condition( 'field_consultation', 728 ); //Consultation de proximité
		if (!empty($_GET[""]))
		{$nids = $query->sort( 'field_date', 'DESC' )
		               ->sort( 'created', 'DESC' )
		               ->pager( 25 )
		               ->execute();
	}

		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {
					$contents[] = [
						'title'     => $nodeContent->getTitle(),
						'adresse'   => $nodeContent->get( 'field_adresse' )->value,
						'telephone' => $nodeContent->get( 'field_telephone' )->value,
						'horaires'  => $nodeContent->get( 'field_horaires' )->value,
						'url'       => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}

		if ( count( $contents ) > 0 ) {
			$build = [
				'liste' => [
					'#theme' => 'consultationsp',
					'#data'  => $contents,
				],
				'pager' => [
					'#type' => 'pager',
				],
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
