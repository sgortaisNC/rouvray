<?php

namespace Drupal\nc_site\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Database\Database;

/**
 * Provides a 'Home - Consultations Form' Block.
 *
 * @Block(
 *   id = "nc_site_consultations_form",
 *   admin_label = @Translation("Home - Consultations Form - Bloc"),
 * )
 */
class ConsultationsBlock extends BlockBase {
	/**
	 * {@inheritdoc}
	 */
	public function build() {
		$tabPatients = ["" => "Type de patient"];
		$patients    = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'types_patient' );
		foreach ( $patients as $patient ) {
			$tabPatients[ $patient->tid ] = $patient->name;
		}

		$tabVilles  = ["" => "Choisir votre ville"];
		$connection = Database::getConnection();
		$query      = $connection->select( 'nc_villes', 'v' )
		                         ->fields( 'v', array( 'id', 'ville', 'cp' ) )
		                         ->orderBy( 'ville', 'ASC' );
		$result     = $query->execute();
		foreach ( $result as $record ) {
			$tabVilles[ $record->id ] = $record->ville . ' (' . $record->cp . ')';
		}

		$tabPatho = ["" => "Pathologie / Type de prestation"];
		$pathos    = \Drupal::entityTypeManager()->getStorage( 'taxonomy_term' )->loadTree( 'types_prestation' );
		foreach ( $pathos as $patho ) {
			$tabPatho[ $patho->tid ] = $patho->name;
		}

		$data = [
			'form1' => [
				'title'  => 'Où consulter ?',
				'action' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/107' ),
				'form'   => [
					'lieu' => [
						'#type'      => 'select',
						'#title'     => '',
						'#attributes' => [
							'class' => ['custom-select', 'my-3']
						],
						"#name"      => 'ville',
						'#options'   => $tabVilles,
					],
					'type' => [
						'#type'      => 'select',
						'#title'     => '',
						'#attributes' => [
							'class' => ['custom-select', 'my-3']
						],
						'#name'      => 'type',
						'#options'   => $tabPatients,
					],
				],
			],
			'form2' => [
				'title'  => 'Consultations spécialisées',
				'action' => \Drupal::service( 'path.alias_manager' )->getAliasByPath( '/node/108' ),
				'form'   => [
					'pathologie' => [
						'#type'      => 'select',
						'#title'     => '',
						'#attributes' => [
							'class' => ['custom-select', 'my-3']
						],
						'#name'  => 'type',
						'#options' => $tabPatho,
					],
				],
			],
		];

		if ( count( $data ) > 0 ) {
			$build = [
				'#theme' => 'consultationsform',
				'#data'  => $data,
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
