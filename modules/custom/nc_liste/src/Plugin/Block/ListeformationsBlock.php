<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Liste - Formations' Block.
 *
 * @Block(
 *   id = "nc_liste_formations",
 *   admin_label = @Translation("Liste - Formations - Bloc"),
 * )
 */
class ListeformationsBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];
		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'formation' ], 'IN' )
		      ->condition( 'status', 1 );


		if  (!empty($_GET["titre"])){
			$query->condition('title','%'.$_GET["titre"].'%','LIKE');
		}


		$nids = $query->sort( 'created', 'DESC' )
		              ->pager( 25 )
		              ->execute();


		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {
					$tabpublic = [];
					$prepublics = $nodeContent->get("field_publics")->getValue();
					foreach ( $prepublics as $k => $v ){
						foreach($v as $data) {
							$tabpublic[] = $data;
						}
					}
					$publics = Term::LoadMultiple($tabpublic);
					$fPublic = [];
					foreach ($publics as $public){
						$fPublic[] = $public->getName();
					}

					$contents[] = [
						'title'        => $nodeContent->getTitle(),
						'duree'        => !empty($nodeContent->get("field_duree")->getValue()[0]["value"]) ? $nodeContent->get("field_duree")->getValue()[0]["value"] : "",
						'organisation' => !empty($nodeContent->get("field_organisation")->getValue()[0]["value"]) ? $nodeContent->get("field_organisation")->getValue()[0]["value"] : "",
						'publics'      => implode(", ",$fPublic),
						'objectifs'    => !empty($nodeContent->get("field_objectifs")->getValue()[0]["value"]) ? $nodeContent->get("field_objectifs")->getValue()[0]["value"] : "",
						'url'          => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}


		$form = [
			'title' => 'Filtrer les formations',
			'action' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/110' ),
			'form' => [
				'titre' => [
					'#type' => 'textfield',
					'#title' => 'Mot clé',
					'#size' => 60,
					'#name' => "titre",
					'#maxlength' => 128,
					'#required' => TRUE,
				]
			]
		];

		if ( ! empty( $_GET ) ) {
			if ( ! empty( $_GET["titre"] ) ) {
				$form["form"]["titre"]["#value"] = $_GET["titre"];
			}
		}

		$build = [
			'form'  => [
				'#theme' => 'formationform',
				'#data'  => $form,
			],
			'liste' => [
				'#theme' => 'formationliste',
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
