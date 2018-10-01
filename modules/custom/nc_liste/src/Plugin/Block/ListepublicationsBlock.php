<?php

namespace Drupal\nc_liste\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Provides a 'Liste - Publications' Block.
 *
 * @Block(
 *   id = "nc_liste_publications",
 *   admin_label = @Translation("Liste - Page Publications - Bloc"),
 * )
 */
class ListepublicationsBlock extends BlockBase {

	/**
	 * {@inheritdoc}
	 */
	public function blockForm($form, FormStateInterface $form_state) {
		$form = parent::blockForm($form, $form_state);
		$config = $this->getConfiguration();

		$termsTree = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('type_publication');
		$tabterm = [];
foreach ($termsTree as $term){
	$tabterm[$term->tid] = $term->name;

}

		$form['nc_links'] = [
			'#type' => 'fieldset',
			'#title' => "Configuration",
			'#tree' => TRUE,

			'field' => [
				'#type' => 'select',
				'#options' => $tabterm,
				'#title' => "Type de publication",
				'#default_value' => isset($config['nc_links_field']) ? $config['nc_links_field'] : null,
				'#description' => $this->t('Select the machine name of the file field'),
			],
		];
		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function blockSubmit($form, FormStateInterface $form_state) {
		parent::blockSubmit($form, $form_state);
		$values = $form_state->getValues();

		$this->configuration['nc_links_field'] = $values['nc_links']['field'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function build() {

		$contents = $nids = [];

		$query = \Drupal::entityQuery( 'node' );
		$query->condition( 'type', [ 'public' ], 'IN' )
		      ->condition( 'status', 1 );

		$nids = $query->sort( 'changed', 'DESC' )
		              ->pager( 25 )
		              ->execute();


		if ( count( $nids ) > 0 ) {
			foreach ( $nids as $nid ) {
				$nodeContent = Node::load( $nid );
				if ( ! empty( $nodeContent ) ) {

					$body = "";
					if ( ! empty( $nodeContent->get( "body" )->getValue()[0]["value"] ) ) {
						$body = strlen( $nodeContent->get( "body" )->getValue()[0]["value"] ) > 175 ? substr( $nodeContent->get( "body" )->getValue()[0]["value"], 0, 175 ) . "..." : $nodeContent->get( "body" )->getValue()[0]["value"];
					}

					$url = "";

					if ( ! empty( $nodeContent->get( "field_files" )->getValue() ) ) {
						$uri = File::load( $nodeContent->get( "field_files" )->getValue()[0]["target_id"] )->getFileUri();
						$url = file_create_url( $uri );
					}

					$contents[] = [
						'title' => $nodeContent->getTitle(),
						"body"  => $body,
						'url'   => $url
					];
				}
			}
		}

		$build = [
			'liste' => [
				'#theme' => 'publicationliste',
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
