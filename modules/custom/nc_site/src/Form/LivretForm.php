<?php

/**
 * @file
 * Contains \Drupal\nc_site\Form\LivretForm
 */
namespace Drupal\nc_site\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Implements a livret block config form
 */
class LivretForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'ncsite_livret_config';
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames() {
        return ['ncsite.config.livret'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('ncsite.config.livret');

        $form = [
            'image' => [
                '#type' => 'managed_file',
                '#title' => 'Image',
                '#upload_location' => 'public://modules/custom/site/livret',
                '#upload_validators' => array(
                    'file_validate_extensions' => array('png gif jpg jpeg'),
                ),
                '#default_value' => $config->get('image'),
                '#required' => TRUE,
            ],
            'file' => [
                '#type' => 'managed_file',
                '#title' => 'PDF',
                '#upload_location' => 'public://modules/custom/site/livret/file',
                '#upload_validators' => array(
                    'file_validate_extensions' => array('pdf'),
                ),
                '#default_value' => $config->get('file'),
                '#required' => TRUE,
            ],
            'code' => [
                '#type' => 'textfield',
                '#title' => 'Lien calaméo',
                '#default_value' => $config->get('code'),
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
        $pdf = $form_state->getValue('file');
        if(!empty($pdf)) {
            $file = File::load($pdf[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncsite.config.livret')
            ->set('image', $form_state->getValue('image'))
            ->set('file', $form_state->getValue('file'))
            ->set('code', $form_state->getValue('code'))
            ->save();
    }
}
