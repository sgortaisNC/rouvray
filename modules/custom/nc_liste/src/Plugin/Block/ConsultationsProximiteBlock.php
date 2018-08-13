<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;

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
	public function blockForm( $form, FormStateInterface $form_state ) {

		$form    = parent::blockForm( $form, $form_state );
		$config  = $this->getConfiguration();
		$tids    = [ 728, 729 ];
		$terms   = Term::loadMultiple( $tids );
		$tabType = [];

		foreach ( $terms as $term ) {
			$tabType[ $term->tid->value ] = $term->name->value;
		}

		$form['consultation'] = [
			'#type'          => 'select',
			'#title'         => 'Type de consultation',
			'#options'       => $tabType,
			'#default_value' => isset( $config['consultation_type'] ) ? $config['consultation_type'] : '728',
		];

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function blockSubmit( $form, FormStateInterface $form_state ) {
		parent::blockSubmit( $form, $form_state );
		$values                                   = $form_state->getValues();
		$this->configuration['consultation_type'] = $values['consultation'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function build() {
		$config     = $this->getConfiguration();
		$connection = Database::getConnection();

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'consultation' ], 'IN' )
		      ->condition( 'status', 1 )
		      ->condition( 'field_consultation', $config['consultation_type'] ); //Consultation de proximité

		switch ( $config['consultation_type'] ) {
			case "728":
				if ( ! empty( $_GET["type"] ) ) {
					$query->condition( "field_patients", $_GET["type"] );
				}
				if ( ! empty( $_GET["ville"] ) ) {
					$query->condition( "field_ville", $_GET["ville"] );
				}
				break;
			case "729":
				if ( ! empty( $_GET["type"] ) ) {
					$query->condition( "field_prestation", $_GET["type"] );
				}
				break;
			default:
				break;
		}

		$nids = $query->sort( 'title', 'ASC' )
		              ->sort( 'created', 'DESC' )
		              ->pager( 25 )
		              ->execute();


		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {
					$query  = $connection->select( 'nc_villes', 'v' )
					                     ->fields( 'v', array( 'id', 'ville', 'cp' ) )
					                     ->condition( 'id', $nodeContent->get( 'field_ville' )->value )
					                     ->orderBy( 'ville', 'ASC' );
					$result = $query->execute();
					$nvillle = "";
					foreach ( $result as $ville ) {
						$hasZero = "";
						if ( strlen( $ville->cp ) == 4 ) {
							$hasZero = 0;
						}
						$nvillle = $ville->ville . " ($hasZero" . $ville->cp . ")";
					}
					$contents[] = [
						'title'     => $nodeContent->getTitle(),
						'adresse'   => $nodeContent->get( 'field_adresse' )->getValue()[0]['value'],
						'ville'     => $nvillle,
						'telephone' => $nodeContent->get( 'field_telephone' )->getValue()[0]['value'],
						'horaires'  => $nodeContent->get( 'field_horaires' )->getValue()[0]['value'],
						'lat'       => $nodeContent->get( 'field_gps_latitude' )->getValue()[0]['value'],
						'lng'       => $nodeContent->get( 'field_gps_longitude' )->getValue()[0]['value'],
						'url'       => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}
		$tabPatients = ["" => "Sélectionnez un type de patient"];
		$patients    = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'types_patient' );
		foreach ( $patients as $patient ) {
			$tabPatients[ $patient->tid ] = $patient->name;
		}

		$tabPatho = ["" => "Sélectionnez une pathologie ou un type de prestation"];
		$pathos    = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'types_prestation' );
		foreach ( $pathos as $patho ) {
			$tabPatho[ $patho->tid ] = $patho->name;
		}

		$tabVilles = ['' => 'Sélectionnez une ville'];
		$query     = $connection->select( 'nc_villes', 'v' )
		                        ->fields( 'v', array( 'id', 'ville', 'cp' ) )
		                        ->orderBy( 'ville', 'ASC' );
		$result    = $query->execute();

		/**
		 * Décommenter pour affiché la liste clef|label utilisé dans le champ filed_ville des consultations.
		 * Début zone commentaire
		 */

		//echo "-------------------<br>";
		foreach ( $result as $record ) {
			$hasZero = "";
			if ( strlen( $record->cp ) == 4 ) {
				$hasZero = 0;
			}
			$tabVilles[ $record->id ] = $record->ville . ' (' . $hasZero . $record->cp . ')';

			//echo $record->id ."|".$record->ville . ' (' . $hasZero  .$record->cp . ')<br>';
		}
		//echo "-------------------<br>";

		/**
		 * Fin zone commentaire
		 */


		$form = [
			'title'  => 'Où consulter ?',


		];

		switch ( $config['consultation_type'] ) {
			case "728":
				$form['action'] = \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/107' );
				$form['form'] = [
					'lieu' => [
						'#type'      => 'select',
						'#title'     => 'Choisir votre commune',
						'#attribute' => [
							'class' => 'form-control'
						],
						'#name'      => 'ville',
						'#options'   => $tabVilles,
					],
					'type' => [
						'#type'      => 'select',
						'#title'     => 'Type de patient',
						'#attribute' => [
							'class' => 'form-control',
						],
						'#name'      => 'type',
						'#options'   => $tabPatients,
					],
				];
				break;
			case "729":
				$form['action'] = \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/108' );
				$form['form'] = [
					'type' => [
						'#type'      => 'select',
						'#title'     => 'Pathologie / Type de prestation',
						'#attributes' => [
							'class' => 'form-control',
						],
						'#name'      => 'type',
						'#options'   => $tabPatho,
					]
				];
				break;
			default:
				break;
		}


		if ( ! empty( $_GET ) ) {
			if (!empty($_GET["ville"])){
				$form["form"]["lieu"]["#value"] = $_GET["ville"];
			}
			if (!empty($_GET["type"])) {
				$form["form"]["type"]["#value"] = $_GET["type"];
			}
		}

		$build = [
			'form'  => [
				'#theme' => 'formconsultation',
				'#data'  => $form,
			],
			'carte' => [
				'#theme'    => 'consultationmap',
				'#data'     => $contents,
				'#attached' => [
					'library' => [
						'nc_liste/leaflet',
					],
				],
			],
			'liste' => [
				'#theme' => 'consultationsp',
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
