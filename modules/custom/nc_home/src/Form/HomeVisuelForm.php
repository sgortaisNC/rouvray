<?php

/**
 * @file
 * Contains \Drupal\nc_home\Form\HomeVisuelForm
 */
namespace Drupal\nc_home\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Implements a image home config form
 */
class HomeVisuelForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'nchome_visuel_config';
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames() {
        return ['nchome.config'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('nchome.config');

        $form = [
            'image' => [
                '#type' => 'managed_file',
                '#title' => 'Image',
                '#upload_location' => 'public://modules/custom/home/visuel',
                '#upload_validators' => array(
                    'file_validate_extensions' => array('png gif jpg jpeg'),
                ),
                '#default_value' => $config->get('image'),
                '#required' => TRUE,
            ],
            'title' => [
                '#type' => 'textfield',
                '#title' => 'Titre',
                '#default_value' => $config->get('title'),
                '#required' => TRUE,
            ],
            'presentation' => [
                '#type' => 'textarea',
                '#title' => 'Présentation',
                '#default_value' => $config->get('presentation'),
                '#required' => TRUE,
            ],
            'link' => [
                '#type' => 'textfield',
                '#title' => 'Lien',
                '#default_value' => $config->get('link'),
                '#required' => TRUE,
            ],
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state){
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        parent::submitForm($form, $form_state);

        $image = $form_state->getValue('image');
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }

        $this->config('nchome.config')
            ->set('image', $form_state->getValue('image'))
            ->set('title', $form_state->getValue('title'))
            ->set('presentation', $form_state->getValue('presentation'))
            ->set('link', $form_state->getValue('link'))
            ->save();
    }
}
