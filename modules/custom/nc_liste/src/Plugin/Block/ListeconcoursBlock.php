<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Liste - Recherche Concours' Block.
 *
 * @Block(
 *   id = "nc_liste_concours",
 *   admin_label = @Translation("Liste - Recherche Concours - Bloc"),
 * )
 */
class ListeconcoursBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'concours' ], 'IN' )
		      ->condition( 'status', 1 );


		if ( ! empty( $_GET["q"] ) ) {
			$query->condition( 'title', '%' . $_GET["q"] . '%', 'LIKE' );
		}
		if ( ! empty( $_GET["epreuve"] ) ) {
			$query->condition( "body", "%" . $_GET["epreuve"] . "%", "LIKE" );
		}
		if ( ! empty( $_GET["grade"] ) ) {
			$query->condition( "field_grade", $_GET["grade"] );
		}


		$nids = $query->sort( 'field_date', 'DESC' )
		              ->pager( 25 )
		              ->execute();

		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {
					$epreuve    = strlen( $nodeContent->get( "body" )->getValue()[0]["value"] ) > 175 ? substr( $nodeContent->get( "body" )->getValue()[0]["value"], 0, 175 ) . "..." : $nodeContent->get( "body" )->getValue()[0]["value"];
					$contents[] = [
						'title'            => $nodeContent->getTitle(),
						"epreuve"          => $epreuve,
						"date_publication" => ! empty( $nodeContent->get( 'field_date' )->getValue()[0]["value"] ) ? \Drupal::service('date.formatter')->format(strtotime($nodeContent->get( 'field_date' )->getValue()[0]["value"]),"long") : "",
						"type_concours"    => ! empty( $nodeContent->get( 'field_concours' )->getValue()[0]["target_id"] ) ? Term::Load( $nodeContent->get( 'field_concours' )->getValue()[0]["target_id"] )->getName() : "",
						"grade"            => ! empty( $nodeContent->get( 'field_grade' )->getValue()[0]["target_id"] ) ? Term::Load( $nodeContent->get( 'field_grade' )->getValue()[0]["target_id"] )->getName() : "",
						"date_limite"      => ! empty( $nodeContent->get( 'field_date_limite' )->getValue()[0]["value"] ) ? \Drupal::service('date.formatter')->format(strtotime($nodeContent->get( 'field_date_limite' )->getValue()[0]["value"]),"long") : '',
						'url'              => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}

		$tabGrade = [ "" => "Sélectionnez un grade" ];

		$grades = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'grades' );
		foreach ( $grades as $grade ) {
			$tabGrade[ $grade->tid ] = $grade->name;
		}

		$form = [
			'title'  => 'Filtrer les concours',
			'action' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/117' ),
			'form'   => [
				'titre'   => [
					'#type'       => 'textfield',
					'#title'      => 'Mot clé :',
					'#size'       => 60,
					'#name'       => "q",
					'#maxlength'  => 128,
					'#attributes' => [
						'class' => [ 'form-control' ],
					],
				],
				'epreuve' => [
					'#type'       => 'textfield',
					'#title'      => 'Epreuve :',
					'#size'       => 60,
					'#name'       => "epreuve",
					'#maxlength'  => 128,
					'#attributes' => [
						'class' => [ 'form-control' ],
					],
				],
				'grade'   => [
					'#type'       => 'select',
					'#title'      => 'Grade :',
					'#name'       => "grade",
					'#attributes' => [
						'class' => [ 'form-control' ],
					],
					'#options'    => $tabGrade,
				]
			]
		];

		if ( ! empty( $_GET ) ) {
			if ( ! empty( $_GET["q"] ) ) {
				$form["form"]["titre"]["#value"] = $_GET["q"];
			}
			if ( ! empty( $_GET["epreuve"] ) ) {
				$form["form"]["epreuve"]["#value"] = $_GET["epreuve"];
			}
			if ( ! empty( $_GET["grade"] ) ) {
				$form["form"]["grade"]["#value"] = $_GET["grade"];
			}
		}

		$build = [
			'form'  => [
				'#theme' => 'concoursform',
				'#data'  => $form,
			],
			'liste' => [
				'#theme' => 'concoursliste',
				'#data'  => $contents,
			],
			'pager' => [
				'#type' => 'pager',
			],
		];

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
