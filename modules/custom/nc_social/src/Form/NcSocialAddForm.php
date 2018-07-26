<?php

/**
 * @file
 * Contains \Drupal\nc_social\Form\NcSocialAddForm
 */
namespace Drupal\nc_social\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\nc_social\NcSocialStorage;

/**
 * Implements a social network admin add form
 */
class NcSocialAddForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ncsocial_admin_add_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    //return ['ncsocial.config'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = array(
      'label' => array(
        '#type' => 'textfield',
        '#title' => t('Label'),
      ),
      'link' => array(
        '#type' => 'textfield',
        '#title' => t('Link'),
      ),
      'icon' => array(
        '#type' => 'textfield',
        '#title' => t('Icon'),
      ),
      'order' => array(
        '#type' => 'textfield',
        '#title' => t('Order'),
      ),
      'actions' => array(
        'cancel' => array(
          '#type' => 'link',
          '#title' => t('Cancel'),
          '#url' => Url::fromRoute('ncsocial.list'),
          '#attributes' => array(
            'class' => ['button'],
          ),
        ),
      )
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = array(
      'sn_label' => $form_state->getValue('label'),
      'sn_link' => $form_state->getValue('link'),
      'sn_icon' => $form_state->getValue('icon'),
      'sn_order' => $form_state->getValue('order'),
    );
    NcSocialStorage::insert($data);
    parent::submitForm($form, $form_state);
  }
}
