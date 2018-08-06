<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

/**
 * Provides a 'Liste - Page Carrefour' Block.
 *
 * @Block(
 *   id = "nc_liste_carrefour",
 *   admin_label = @Translation("Liste - Page Carrefour - Bloc"),
 * )
 */
class ListecarrefourBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {
		$build          = [];
		$cnode          = \Drupal::routeMatch()->getParameter( 'node' );
		$menu_to_show   = [];
		$nids_carrefour = [];
		if ( $cnode instanceof NodeInterface ) {
			// You can get nid and anything else you need from the node object.
			$type = "";
			if ( ! empty( $cnode->get( 'field_type' )->getValue()[0]["value"] ) ) {
				$type = $cnode->get( 'field_type' )->getValue()[0]["value"];
			}

			$current_node = $cnode->id();
			if ( $type == 'carrefour' ) {
				$contents = $nids = [];

				$menu_tree  = Drupal::menuTree();
				$parameters = $menu_tree->getCurrentRouteMenuTreeParameters( 'main' );
				$menu       = $menu_tree->load( 'main', $parameters );
				foreach ( $menu as $key => $element ) {
					if ( $element->inActiveTrail ) {
						if ( $current_node == $element->link->getUrlObject()->getRouteParameters()["node"] ) {
							$menu_to_show = $element->subtree;
						} else {
							foreach ( $element->subtree as $subKey => $subelement ) {
								if ( $current_node == $subelement->link->getUrlObject()->getRouteParameters()["node"] ) {
									$menu_to_show = $subelement->subtree;
								}
							}
						}
					}
				}

				foreach ( $menu_to_show as $menu_key => $menu_item ) {
					$nids_carrefour[] = $menu_item->link->getUrlObject()->getRouteParameters()["node"];
				}

				$pages_enfant = Node::LoadMultiple( $nids_carrefour );

				foreach ( $pages_enfant as $node ) {
					$image = "";
					if ( ! empty( $node->get( "field_image" )->getValue()[0]['target_id'] ) ) {
						$image = file_create_url( File::load( $node->get( "field_image" )->getValue()[0]['target_id'] )->getFileUri() );
					} else {
						$fileUuid = $node->get( 'field_image' )->getSetting( 'default_image' )['uuid'];
						$file     = \Drupal::service( 'entity.repository' )->loadEntityByUuid( 'file', $fileUuid );
						if ( ! empty( $file ) ) {
							$image = ImageStyle::load( 'detail' )->buildUrl( $file->getFileUri() );
						}
					}

					$body = "";
					if ( ! empty( $node->get( "body" )->getValue()[0]["value"] ) ) {
						$body = strlen( $node->get( "body" )->getValue()[0]["value"] ) > 175 ? substr( $node->get( "body" )->getValue()[0]["value"], 0, 175 ) . "..." : $node->get( "body" )->getValue()[0]["value"];
					}
					$contents[] = [
						'title' => $node->getTitle(),
						'body'  => $body,
						'image' => [
							"url" => $image,
							'alt' => ! empty( $node->get( "field_image" )->getValue()[0]['alt'] ) ? $node->get( "field_image" )->getValue()[0]['alt'] : "",
						],
						'url'   => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $node->id() )
					];
				}

				$build = [
					'liste' => [
						'#theme' => 'carrefourliste',
						'#data'  => $contents,
					],
					'pager' => [
						'#type' => 'pager',
					],
				];
			}
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
