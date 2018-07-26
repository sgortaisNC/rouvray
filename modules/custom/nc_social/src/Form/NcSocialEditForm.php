<?php

/**
 * @file
 * Contains \Drupal\nc_social\Form\NcSocialEditForm
 */
namespace Drupal\nc_social\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\nc_social\NcSocialStorage;

/**
 * Implements a social network admin edit form
 */
class NcSocialEditForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ncsocial_admin_edit_form';
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
  public function buildForm(array $form, FormStateInterface $form_state, $param = NULL) {
    $data = $this->getItem($param);

    $form = array(
      'id' => array(
        '#type' => 'hidden',
        '#default_value' => $param,
      ),
      'label' => array(
        '#type' => 'textfield',
        '#title' => t('Label'),
        '#default_value' => $data->sn_label,
      ),
      'link' => array(
        '#type' => 'textfield',
        '#title' => t('Link'),
        '#default_value' => $data->sn_link,
      ),
      'icon' => array(
        '#type' => 'textfield',
        '#title' => t('Icon'),
        '#default_value' => $data->sn_icon,
      ),
      'order' => array(
        '#type' => 'textfield',
        '#title' => t('Order'),
        '#default_value' => $data->sn_order,
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
      'sn_id' => $form_state->getValue('id'),
      'sn_label' => $form_state->getValue('label'),
      'sn_link' => $form_state->getValue('link'),
      'sn_icon' => $form_state->getValue('icon'),
      'sn_order' => $form_state->getValue('order'),
    );
    NcSocialStorage::update($data);
    parent::submitForm($form, $form_state);
  }

  private function getItem($entityId){
    $entity = NcSocialStorage::load(array('sn_id' => $entityId), false);

    return $entity[0];
  }
}
