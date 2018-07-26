<?php

/**
 * @file
 * Contains \Drupal\nc_site\Form\MultiSiteForm
 */
namespace Drupal\nc_site\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Implements a multisite block config form
 */
class MultiSiteForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'ncsite_multisite_config';
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames() {
        return ['ncsite.config.multisite'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('ncsite.config.multisite');

        $form = [
            'multisite1' => [
                '#type' => 'fieldset',
                '#title' => "Multisite 1",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite1.image'),
                    '#required' => TRUE,
                ],
                'logo' => [
                    '#type' => 'managed_file',
                    '#title' => 'Logo',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite1.logo'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('multisite1.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'url',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('multisite1.link'),
                    '#required' => TRUE,
                ],
            ],

            'multisite2' => [
                '#type' => 'fieldset',
                '#title' => "Multisite 2",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite2.image'),
                    '#required' => TRUE,
                ],
                'logo' => [
                    '#type' => 'managed_file',
                    '#title' => 'Logo',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite2.logo'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('multisite2.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'url',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('multisite2.link'),
                    '#required' => TRUE,
                ],
            ],

            'multisite3' => [
                '#type' => 'fieldset',
                '#title' => "Multisite 3",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite3.image'),
                    '#required' => TRUE,
                ],
                'logo' => [
                    '#type' => 'managed_file',
                    '#title' => 'Logo',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite3.logo'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('multisite3.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'url',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('multisite3.link'),
                    '#required' => TRUE,
                ],
            ],

            'multisite4' => [
                '#type' => 'fieldset',
                '#title' => "Multisite 4",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite4.image'),
                    '#required' => TRUE,
                ],
                'logo' => [
                    '#type' => 'managed_file',
                    '#title' => 'Logo',
                    '#upload_location' => 'public://modules/custom/site/multisite',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('multisite4.logo'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('multisite4.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'url',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('multisite4.link'),
                    '#required' => TRUE,
                ],
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

        //Multisite 1
        $image = $form_state->getValue('multisite1')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $logo = $form_state->getValue('multisite1')['logo'];
        if(!empty($image)) {
            $file = File::load($logo[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncsite.config.multisite')
            ->set('multisite1.image', $form_state->getValue('multisite1')['image'])
            ->set('multisite1.logo', $form_state->getValue('multisite1')['logo'])
            ->set('multisite1.title', $form_state->getValue('multisite1')['title'])
            ->set('multisite1.link', $form_state->getValue('multisite1')['link'])
            ->save();

        //Multisite 2
        $image = $form_state->getValue('multisite2')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $logo = $form_state->getValue('multisite2')['logo'];
        if(!empty($image)) {
            $file = File::load($logo[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncsite.config.multisite')
            ->set('multisite2.image', $form_state->getValue('multisite2')['image'])
            ->set('multisite2.logo', $form_state->getValue('multisite2')['logo'])
            ->set('multisite2.title', $form_state->getValue('multisite2')['title'])
            ->set('multisite2.link', $form_state->getValue('multisite2')['link'])
            ->save();

        //Multisite 3
        $image = $form_state->getValue('multisite3')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $logo = $form_state->getValue('multisite3')['logo'];
        if(!empty($image)) {
            $file = File::load($logo[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncsite.config.multisite')
            ->set('multisite3.image', $form_state->getValue('multisite3')['image'])
            ->set('multisite3.logo', $form_state->getValue('multisite3')['logo'])
            ->set('multisite3.title', $form_state->getValue('multisite3')['title'])
            ->set('multisite3.link', $form_state->getValue('multisite3')['link'])
            ->save();

        //Multisite 4
        $image = $form_state->getValue('multisite4')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $logo = $form_state->getValue('multisite4')['logo'];
        if(!empty($image)) {
            $file = File::load($logo[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncsite.config.multisite')
            ->set('multisite4.image', $form_state->getValue('multisite4')['image'])
            ->set('multisite4.logo', $form_state->getValue('multisite4')['logo'])
            ->set('multisite4.title', $form_state->getValue('multisite4')['title'])
            ->set('multisite4.link', $form_state->getValue('multisite4')['link'])
            ->save();
    }
}
