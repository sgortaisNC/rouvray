<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a 'Liste - Recherche Offres d'emploi' Block.
 *
 * @Block(
 *   id = "nc_liste_offres",
 *   admin_label = @Translation("Liste - Recherche Offres d'emploi - Bloc"),
 * )
 */
class ListeoffresBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'offre' ], 'IN' )
		      ->condition( 'status', 1 );


		if ( ! empty( $_GET["q"] ) ) {
			$groupORq = $query->orConditionGroup()
			                  ->condition( 'title', '%' . $_GET["q"] . '%', 'LIKE' )
			                  ->condition( 'field_fiche', '%' . $_GET["q"] . '%', 'LIKE' );
			$query->condition( $groupORq );
		}
		if ( ! empty( $_GET["statut"] ) ) {
			$query->condition( "field_statut", $_GET["statut"] );
		}
		if ( ! empty( $_GET["grade"] ) ) {
			$query->condition( "field_grade", $_GET["grade"] );
		}


		$nids = $query->sort( 'field_date_limite', 'DESC' )
		              ->pager( 25 )
		              ->execute();

		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$type_contrat_oe = [];

				$nodeContent = Node::load( $nid );
				if ( !empty( $nodeContent->get( 'field_contrat' )->getValue() ) ) {
					foreach ($nodeContent->get( 'field_contrat' )->getValue() as $v){
						$type_contrat_oe[] = Term::Load( $v["target_id"] )->getName();
					}
				}



				if ( ! empty( $nodeContent ) ) {
					$fiche      = strip_tags(strlen( $nodeContent->get( "field_fiche" )->getValue()[0]["value"] ) > 175 ? substr( $nodeContent->get( "field_fiche" )->getValue()[0]["value"], 0, 175 ) . "..." : $nodeContent->get( "field_fiche" )->getValue()[0]["value"]);
					$contents[] = [
						'title'        => $nodeContent->getTitle(),
						"statut"       => ! empty( $nodeContent->get( 'field_statut' )->getValue()[0]["target_id"] ) ? Term::Load( $nodeContent->get( 'field_statut' )->getValue()[0]["target_id"] )->getName() : "",
						"grade"        => ! empty( $nodeContent->get( 'field_grade' )->getValue()[0]["target_id"] ) ? Term::Load( $nodeContent->get( 'field_grade' )->getValue()[0]["target_id"] )->getName() : "",
						"fiche"        => $fiche,
						"date_limite"  => ! empty( $nodeContent->get( 'field_date_limite' )->getValue()[0]["value"] ) ? \Drupal::service( 'date.formatter' )->format( strtotime( $nodeContent->get( "field_date_limite" )->getValue()[0]["value"] ), "long" ) : '',
						"date_fin"     => ! empty( $nodeContent->get( 'field_date_other' )->getValue()[0]["value"] ) ? \Drupal::service( 'date.formatter' )->format( strtotime( $nodeContent->get( "field_date_other" )->getValue()[0]["value"] ), "long" ) : "",
						"date_deb"     => ! empty( $nodeContent->get( 'field_date' )->getValue()[0]["value"] ) ? \Drupal::service( 'date.formatter' )->format( strtotime( $nodeContent->get( "field_date" )->getValue()[0]["value"] ), "long" ) : "",
						"type_contrat" => implode(", ",$type_contrat_oe),
							'url'          => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}

			}
		}

		$tabStatut = [ "" => "---" ];
		$tabGrade  = [ "" => "---" ];

		$statuts = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'statuts' );
		foreach ( $statuts as $statut ) {
			$tabStatut[ $statut->tid ] = $statut->name;
		}

		$grades = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'grades' );
		foreach ( $grades as $grade ) {
			$tabGrade[ $grade->tid ] = $grade->name;
		}

		$form = [
			'title'  => 'Filtrer les formations',
			'action' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/113' ),
			'form'   => [
				'titre'  => [
					'#type'       => 'textfield',
					'#title'      => 'Mot clé :',
					'#size'       => 60,
					'#name'       => "q",
					'#maxlength'  => 128,
					'#required'   => true,
					'#attributes' => [
						'class' => [ 'form-control' ],
					],
				],
				'statut' => [
					'#type'       => 'select',
					'#title'      => 'Statut du poste :',
					'#name'       => "statut",
					'#attributes' => [
						'class' => [ 'form-control' ],
					],
					'#options'    => $tabStatut,
				],
				'grade'  => [
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
			if ( ! empty( $_GET["statut"] ) ) {
				$form["form"]["statut"]["#value"] = $_GET["statut"];
			}
			if ( ! empty( $_GET["grade"] ) ) {
				$form["form"]["grade"]["#value"] = $_GET["grade"];
			}
		}

		$build = [
			'form'  => [
				'#theme' => 'offresform',
				'#data'  => $form,
			],
			'liste' => [
				'#theme' => 'offresliste',
				'#data'  => $contents,
			],
			'pager' => [
				'#type' => 'pager',
			],
		];

		return $build;
	}
}
