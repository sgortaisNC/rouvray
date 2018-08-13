<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Liste - Actualites/Evenements' Block.
 *
 * @Block(
 *   id = "nc_liste_actualite_evenement",
 *   admin_label = @Translation("Liste - Actualites/Evenements - Bloc"),
 * )
 */
class ListeactualiteBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'article' ], 'IN' )
		      ->condition( 'status', 1 );

		$nids = $query->sort( 'field_date', 'DESC' )
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
					else{
						$fileUuid = $nodeContent->get('field_image')->getSetting('default_image')['uuid'];
						$file = \Drupal::service('entity.repository')->loadEntityByUuid('file', $fileUuid);
						if(!empty($file)){
							$path = $file->getFileUri();
							$image = file_create_url(ImageStyle::load('detail')->buildUrl($path));
						}
					}


					$body = "";
					if ( ! empty( $nodeContent->get( "body" )->getValue()[0]["value"] ) ) {
						$body = strlen( $nodeContent->get( "body" )->getValue()[0]["value"] ) > 175 ? substr( $nodeContent->get( "body" )->getValue()[0]["value"], 0, 175 ) . "..." : $nodeContent->get( "body" )->getValue()[0]["value"];
					}
					$date_fin   = ! empty( $nodeContent->get( "field_date_other" )->getValue()[0]["value"] ) ? $nodeContent->get( "field_date_other" )->getValue()[0]["value"] : "";
					if  (!empty($date_fin)) {
						$date_fin = \Drupal::service( 'date.formatter' )->format( strtotime( $date_fin ), "long" );
					}
					$lieu       = ! empty( $nodeContent->get( "field_lieu" )->getValue()[0]["value"] ) ? $nodeContent->get( "field_lieu" )->getValue()[0]["value"] : '';
					$contents[] = [
						'title'     => $nodeContent->getTitle(),
						'affichage' => $nodeContent->get( "field_affichage" )->getValue()[0]["value"],
						"image"     => [
							"url" => $image,
							"alt" => ! empty( $nodeContent->get( "field_image" )->getValue()[0]['alt'] ) ? $nodeContent->get( "field_image" )->getValue()[0]['alt'] : $nodeContent->getTitle(),
						],
						"date_deb"  => \Drupal::service('date.formatter')->format(strtotime($nodeContent->get( "field_date" )->getValue()[0]["value"]),"long"),
						"date_fin"  => $date_fin,
						"lieu"      => $lieu,
						"body"      => $body,
						'url'       => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}

		$build = [
			'liste' => [
				'#theme' => 'articleliste',
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
