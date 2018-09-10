<?php

/**
 * @file
 * Contains \Drupal\nc_site\Form\RejoindreForm
 */

namespace Drupal\nc_site\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

/**
 * Implements a rejoindre block config form
 */
class RejoindreForm extends ConfigFormBase {
	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		return 'ncsite_rejoindre_config';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEditableConfigNames() {
		return [ 'ncsite.config.rejoindre' ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm( array $form, FormStateInterface $form_state ) {
		$config = $this->config( 'ncsite.config.rejoindre' );

		$form = [
			'slide1' => [
				'#type'  => 'fieldset',
				'#title' => "Slider n°1",
				'#tree'  => true,

				'image' => [
					'#type'              => 'managed_file',
					'#title'             => 'Image',
					'#upload_location'   => 'public://modules/custom/nc_site/rejoindre',
					'#upload_validators' => array(
						'file_validate_extensions' => array( 'png gif jpg jpeg' ),
					),
					'#default_value'     => $config->get( 'slide1.image' ),
					'#required'          => true,
				],
				'title' => [
					'#type'          => 'textfield',
					'#title'         => 'Titre',
					'#default_value' => $config->get( 'slide1.title' ),
					'#required'      => true,
				],
				'description'  => [
					'#type'          => 'text_format',
					'#title'         => 'Description',
					'#default_value' => $config->get( 'slide1.description' ),
					'#required'      => true,
				],
				'url' => [
					'#type'          => 'textfield',
					'#title'         => 'URL de la page',
					'#default_value' => $config->get( 'slide1.url' ),
					'#required'      => true,
				],
			],
			'slide2' => [
				'#type'  => 'fieldset',
				'#title' => "Slider n°2",
				'#tree'  => true,

				'image' => [
					'#type'              => 'managed_file',
					'#title'             => 'Image',
					'#upload_location'   => 'public://modules/custom/nc_site/rejoindre',
					'#upload_validators' => array(
						'file_validate_extensions' => array( 'png gif jpg jpeg' ),
					),
					'#default_value'     => $config->get( 'slide2.image' ),
					'#required'          => true,
				],
				'title' => [
					'#type'          => 'textfield',
					'#title'         => 'Titre',
					'#default_value' => $config->get( 'slide2.title' ),
					'#required'      => true,
				],
				'description'  => [
					'#type'          => 'text_format',
					'#title'         => 'Description',
					'#default_value' => $config->get( 'slide2.description' ),
					'#required'      => true,
				],
				'url' => [
					'#type'          => 'textfield',
					'#title'         => 'URL de la page',
					'#default_value' => $config->get( 'slide2.url' ),
					'#required'      => true,
				],
			],
			'slide3' => [
				'#type'  => 'fieldset',
				'#title' => "Slider n°3",
				'#tree'  => true,

				'image' => [
					'#type'              => 'managed_file',
					'#title'             => 'Image',
					'#upload_location'   => 'public://modules/custom/nc_site/rejoindre',
					'#upload_validators' => array(
						'file_validate_extensions' => array( 'png gif jpg jpeg' ),
					),
					'#default_value'     => $config->get( 'slide3.image' ),
					'#required'          => true,
				],
				'title' => [
					'#type'          => 'textfield',
					'#title'         => 'Titre',
					'#default_value' => $config->get( 'slide3.title' ),
					'#required'      => true,
				],
				'description'  => [
					'#type'          => 'text_format',
					'#title'         => 'Description',
					'#default_value' => $config->get( 'slide3.description' ),
					'#required'      => true,
				],
				'url' => [
					'#type'          => 'textfield',
					'#title'         => 'URL de la page',
					'#default_value' => $config->get( 'slide3.url' ),
					'#required'      => true,
				],
			],
		];

		return parent::buildForm( $form, $form_state );
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm( array &$form, FormStateInterface $form_state ) {
		parent::validateForm( $form, $form_state );
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm( array &$form, FormStateInterface $form_state ) {
		parent::submitForm( $form, $form_state );
		//Lien 1
		$image = $form_state->getValue('slide1')['image'];
		if(!empty($image)) {
			$file = File::load($image[0]);
			$file->setPermanent();
			$file->save();
		}
		$this->config('ncsite.config.rejoindre')
		     ->set('slide1.image', $form_state->getValue('slide1')['image'])
		     ->set('slide1.title', $form_state->getValue('slide1')['title'])
		     ->set('slide1.description', $form_state->getValue('slide1')['description']["value"])
			->set('slide1.url', $form_state->getValue('slide1')['url'])
			->save();

		//Lien 2
		$image = $form_state->getValue('slide2')['image'];
		if(!empty($image)) {
			$file = File::load($image[0]);
			$file->setPermanent();
			$file->save();
		}
		$this->config('ncsite.config.rejoindre')
		     ->set('slide2.image', $form_state->getValue('slide2')['image'])
		     ->set('slide2.title', $form_state->getValue('slide2')['title'])
		     ->set('slide2.url', $form_state->getValue('slide2')['url'])
		     ->set('slide2.description', $form_state->getValue('slide2')['description']["value"])
		     ->save();

		//Lien 3
		$image = $form_state->getValue('slide3')['image'];
		if(!empty($image)) {
			$file = File::load($image[0]);
			$file->setPermanent();
			$file->save();
		}
		$this->config('ncsite.config.rejoindre')
		     ->set('slide3.image', $form_state->getValue('slide3')['image'])
		     ->set('slide3.title', $form_state->getValue('slide3')['title'])
		     ->set('slide3.url', $form_state->getValue('slide3')['url'])
		     ->set('slide3.description', $form_state->getValue('slide3')['description']["value"])
		     ->save();
	}
}
