<?php

/**
 * @file
 * Contains \Drupal\nc_shortcut\Form\GalleryForm
 */
namespace Drupal\nc_shortcut\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Implements a gallery block config form
 */
class GalleryForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'ncshortcut_config_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames() {
        return ['ncshortcut.config.gallery'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('ncshortcut.config.gallery');

        $form = [
            'link1' => [
                '#type' => 'fieldset',
                '#title' => "Lien rapide 1",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/shortcut/gallery',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('link1.image'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('link1.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'textfield',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('link1.link'),
                    '#required' => TRUE,
                ],
            ],

            'link2' => [
                '#type' => 'fieldset',
                '#title' => "Lien rapide 2",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/shortcut/gallery',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('link2.image'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('link2.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'textfield',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('link2.link'),
                    '#required' => TRUE,
                ],
            ],

            'link3' => [
                '#type' => 'fieldset',
                '#title' => "Lien rapide 3",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/shortcut/gallery',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('link3.image'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('link3.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'textfield',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('link3.link'),
                    '#required' => TRUE,
                ],
            ],

            /*'link4' => [
                '#type' => 'fieldset',
                '#title' => "Lien rapide 4",
                '#tree' => TRUE,

                'image' => [
                    '#type' => 'managed_file',
                    '#title' => 'Image',
                    '#upload_location' => 'public://modules/custom/shortcut/gallery',
                    '#upload_validators' => array(
                        'file_validate_extensions' => array('png gif jpg jpeg'),
                    ),
                    '#default_value' => $config->get('link4.image'),
                    '#required' => TRUE,
                ],
                'title' => [
                    '#type' => 'textfield',
                    '#title' => 'Titre',
                    '#default_value' => $config->get('link4.title'),
                    '#required' => TRUE,
                ],
                'link' => [
                    '#type' => 'textfield',
                    '#title' => 'Lien',
                    '#default_value' => $config->get('link4.link'),
                    '#required' => TRUE,
                ],
            ],*/
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

        //Lien 1
        $image = $form_state->getValue('link1')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncshortcut.config.gallery')
            ->set('link1.image', $form_state->getValue('link1')['image'])
            ->set('link1.title', $form_state->getValue('link1')['title'])
            ->set('link1.link', $form_state->getValue('link1')['link'])
            ->save();

        //Lien 2
        $image = $form_state->getValue('link2')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncshortcut.config.gallery')
            ->set('link2.image', $form_state->getValue('link2')['image'])
            ->set('link2.title', $form_state->getValue('link2')['title'])
            ->set('link2.link', $form_state->getValue('link2')['link'])
            ->save();

        //Lien 3
        $image = $form_state->getValue('link3')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncshortcut.config.gallery')
            ->set('link3.image', $form_state->getValue('link3')['image'])
            ->set('link3.title', $form_state->getValue('link3')['title'])
            ->set('link3.link', $form_state->getValue('link3')['link'])
            ->save();

        //Lien 4
        /*$image = $form_state->getValue('link4')['image'];
        if(!empty($image)) {
            $file = File::load($image[0]);
            $file->setPermanent();
            $file->save();
        }
        $this->config('ncshortcut.config.gallery')
            ->set('link4.image', $form_state->getValue('link4')['image'])
            ->set('link4.title', $form_state->getValue('link4')['title'])
            ->set('link4.link', $form_state->getValue('link4')['link'])
            ->save();*/
    }
}
