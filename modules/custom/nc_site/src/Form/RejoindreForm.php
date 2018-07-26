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
        return ['ncsite.config.rejoindre'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('ncsite.config.rejoindre');
        $form = [
            'formation' => [
                '#type' => 'entity_autocomplete',
                '#target_type' => 'node',
                '#selection_handler' => 'default', // Optional. The default selection handler is pre-populated to 'default'.
                '#required' => TRUE,
                '#selection_settings' => array(
                    'target_bundles' => array('formation'),
                ),
                '#default_value' => Node::load($config->get('formation')),
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
        $this->config('ncsite.config.rejoindre')
            ->set('formation', $form_state->getValue('formation'))
            ->save();
    }
}
