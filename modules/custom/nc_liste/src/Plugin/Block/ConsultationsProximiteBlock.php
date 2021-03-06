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

    $correspondancesVilles = [];
    $field_name = 'field_ville';
    $definitions = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'consultation');

    if (isset($definitions[$field_name])) {
      $correspondancesVilles = $definitions[$field_name]->getSetting('allowed_values');
    }

		$contents = $contentsMap = $nids = $nidsMap = [];

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
		              ->pager( 10 )
		              ->execute();

		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {
					$contents[] = [
						'title'     => $nodeContent->getTitle(),
						'adresse'   => !empty($nodeContent->get( 'field_adresse' )->getValue()[0]) ? $nodeContent->get( 'field_adresse' )->getValue()[0]['value'] : "" ,
						'ville'     => (!empty($nodeContent->get( 'field_ville' )->value)) ? $correspondancesVilles[$nodeContent->get( 'field_ville' )->value] : '',
						'telephone' => !empty($nodeContent->get( 'field_telephone' )->getValue()) ? $nodeContent->get( 'field_telephone' )->getValue()[0]['value'] : "",
						'horaires'  => !empty($nodeContent->get( 'field_horaires' )->getValue()) ? $nodeContent->get( 'field_horaires' )->getValue()[0]['value'] : "",
						'lat'       => !empty($nodeContent->get( 'field_gps_latitude' )->getValue()[0]['value']) ? $nodeContent->get( 'field_gps_latitude' )->getValue()[0]['value'] : "" ,
						'lng'       => !empty($nodeContent->get( 'field_gps_longitude' )->getValue()[0]['value']) ? $nodeContent->get( 'field_gps_longitude' )->getValue()[0]['value'] : "",
						'url'       => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
					];
				}
			}
		}


    /*QUERY MAP*/
    $queryMap = \Drupal::entityQuery( 'node' );
    $queryMap->condition( 'type', [ 'consultation' ], 'IN' )
      ->condition( 'status', 1 )
      ->condition( 'field_consultation', $config['consultation_type'] ); //Consultation de proximité

    switch ( $config['consultation_type'] ) {
      case "728":
        if ( ! empty( $_GET["type"] ) ) {
          $queryMap->condition( "field_patients", $_GET["type"] );
        }
        if ( ! empty( $_GET["ville"] ) ) {
          $queryMap->condition( "field_ville", $_GET["ville"] );
        }
        break;
      case "729":
        if ( ! empty( $_GET["type"] ) ) {
          $queryMap->condition( "field_prestation", $_GET["type"] );
        }
        break;
      default:
        break;
    }

    $nidsMap = $queryMap->sort( 'title', 'ASC' )
      ->sort( 'created', 'DESC' )
      ->execute();
    if ( count( $nidsMap ) > 0 ) {
      foreach ( $nidsMap as $nid ) {
        $nodeContent = Node::load( $nid );

        if ( ! empty( $nodeContent ) ) {
          $contentsMap[] = [
            'title'     => $nodeContent->getTitle(),
            'adresse'   => !empty($nodeContent->get( 'field_adresse' )->getValue()[0]) ? $nodeContent->get( 'field_adresse' )->getValue()[0]['value'] : "" ,
            'ville'     => (!empty($nodeContent->get( 'field_ville' )->value)) ? $correspondancesVilles[$nodeContent->get( 'field_ville' )->value] : '',
            'telephone' => !empty($nodeContent->get( 'field_telephone' )->getValue()) ? $nodeContent->get( 'field_telephone' )->getValue()[0]['value'] : "",
            'horaires'  => !empty($nodeContent->get( 'field_horaires' )->getValue()) ? $nodeContent->get( 'field_horaires' )->getValue()[0]['value'] : "",
            'lat'       => !empty($nodeContent->get( 'field_gps_latitude' )->getValue()[0]['value']) ? $nodeContent->get( 'field_gps_latitude' )->getValue()[0]['value'] : "" ,
            'lng'       => !empty($nodeContent->get( 'field_gps_longitude' )->getValue()[0]['value']) ? $nodeContent->get( 'field_gps_longitude' )->getValue()[0]['value'] : "",
            'url'       => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/' . $nodeContent->id() ),
          ];
        }
      }
    }
    /*END MAP*/

		$tabPatients = ["" => "---"];
		$patients    = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'types_patient' );
		foreach ( $patients as $patient ) {
			$tabPatients[ $patient->tid ] = $patient->name;
		}

		$tabPatho = ["" => "---"];
		$pathos    = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'types_prestation' );
		foreach ( $pathos as $patho ) {
			$tabPatho[ $patho->tid ] = $patho->name;
		}

    $correspondancesVilles = [];
    $field_name = 'field_ville';
    $definitions = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'consultation');

    if (isset($definitions[$field_name])) {
      $correspondancesVilles= $definitions[$field_name]->getSetting('allowed_values');
    }

    $connection = Database::getConnection();
    $result = $connection->query("SELECT DISTINCT field_ville_value FROM node__field_ville WHERE bundle = 'consultation' ORDER BY field_ville_value ASC")
      ->fetchAll();

    $villes = [];
    foreach ( $result as $record ) {
      if(!empty($correspondancesVilles[$record->field_ville_value])){
        $villes[ $record->field_ville_value ] = $correspondancesVilles[$record->field_ville_value];
      }
    }
    asort($villes);

    $tabVilles = [
        '' => "---"
      ] + $villes;

		$form = [
			'title'  => 'Où consulter ?',
    ];

		switch ( $config['consultation_type'] ) {
			case "728":
				$form['action'] = \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/194' );
				$form['form'] = [
					'lieu' => [
						'#type'      => 'select',
						'#title'     => 'Ville la plus proche de chez vous :',
						'#attributes' => [
							'class' => ['form-control'],
						],
						'#name'      => 'ville',
						'#options'   => $tabVilles,
					],
					'type' => [
						'#type'      => 'select',
						'#title'     => 'Type de patient :',
						'#attributes' => [
							'class' => ['form-control'],
						],
						'#name'      => 'type',
						'#options'   => $tabPatients,
					],
				];
				break;
			case "729":
				$form['action'] = \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/198' );
				$form['form'] = [
					'type' => [
						'#type'      => 'select',
						'#title'     => 'Pathologie / Type de prestation :',
						'#attributes' => [
							'class' => ['form-control'],
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
				'#data'     => $contentsMap,
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

  public function getCacheMaxAge() {
    return 0;
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
