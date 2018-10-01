<?php

namespace Drupal\nc_share\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class NcShareSettingsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'nc_share_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'nc_share.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('nc_share.settings');

        $form = [
            'facebook' => [
                '#title' => $this->t('Facebook'),
                '#type' => 'select',
                '#options' => [
                    '0' => $this->t('Inactive'),
                    '1' => $this->t('Active'),
                ],
                '#default_value' => $config->get('facebook'),
            ],

            'twitter' => [
                '#title' => $this->t('Twitter'),
                '#type' => 'select',
                '#options' => [
                    '0' => $this->t('Inactive'),
                    '1' => $this->t('Active'),
                ],
                '#default_value' => $config->get('twitter'),
            ],

            'google' => [
                '#title' => $this->t('Google +'),
                '#type' => 'select',
                '#options' => [
                    '0' => $this->t('Inactive'),
                    '1' => $this->t('Active'),
                ],
                '#default_value' => $config->get('google'),
            ],

            'linkedin' => [
                '#title' => $this->t('LinkedIn'),
                '#type' => 'select',
                '#options' => [
                    '0' => $this->t('Inactive'),
                    '1' => $this->t('Active'),
                ],
                '#default_value' => $config->get('linkedin'),
            ],

            'pinterest' => [
                '#title' => $this->t('Pinterest'),
                '#type' => 'select',
                '#options' => [
                    '0' => $this->t('Inactive'),
                    '1' => $this->t('Active'),
                ],
                '#default_value' => $config->get('pinterest'),
            ],

            'group_mail' => [
                '#type' => 'fieldset',
                '#title' => $this->t('Mail'),
                '#tree' => TRUE,

                'mail' => [
                    '#title' => $this->t('Mail'),
                    '#type' => 'select',
                    '#options' => [
                        '0' => $this->t('Inactive'),
                        '1' => $this->t('Active'),
                    ],
                    '#default_value' => $config->get('mail'),
                ],

                'subject' => [
                    '#title' => $this->t('Subject'),
                    '#type' => 'textfield',
                    '#default_value' => $config->get('subject'),
                ],

                'message' => [
                    '#title' => $this->t('Message'),
                    '#type' => 'text_format',
                    '#format' => 'full_html',
                    '#description' => $this->t('Note: Using "[share_link]" to display page\'s url and "[name]" to display recipient\'s email'),
                    '#default_value' => $config->get('message')['value'],
                ],
            ],

            'group_rss'=> [
                '#type' => 'fieldset',
                '#title' => $this->t('RSS'),
                '#tree' => TRUE,

                'rss' => [
                    '#title' => $this->t('RSS'),
                    '#type' => 'select',
                    '#options' => [
                        '0' => $this->t('Inactive'),
                        '1' => $this->t('Active'),
                    ],
                    '#default_value' => $config->get('rss'),
                ],

                'url_rss' => [
                    '#title' => $this->t('RSS url'),
                    '#type' => 'textfield',
                    '#default_value' => (!empty($config->get('url_rss'))) ? $config->get('url_rss') : "/rss.xml",
                ],
            ],

            'print' => [
                '#title' => $this->t('Print'),
                '#type' => 'select',
                '#options' => [
                    '0' => $this->t('Inactive'),
                    '1' => $this->t('Active'),
                ],
                '#default_value' => $config->get('print'),
            ],
        ];
        
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        $this->config('nc_share.settings')
            ->set('facebook', $values['facebook'])
            ->set('twitter', $values['twitter'])
            ->set('google', $values['google'])
            ->set('linkedin', $values['linkedin'])
            ->set('pinterest', $values['pinterest'])
            ->set('mail', $values['group_mail']['mail'])
            ->set('subject', $values['group_mail']['subject'])
            ->set('message', $values['group_mail']['message'])
            ->set('rss', $values['group_rss']['rss'])
            ->set('url_rss', $values['group_rss']['url_rss'])
            ->set('print', $values['print'])
            ->save();
        parent::submitForm($form, $form_state);
    }

}