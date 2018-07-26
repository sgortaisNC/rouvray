<?php

/**
 * @file
 * Contains \Drupal\nc_social\Controller\NcSocialController.
 */

namespace Drupal\nc_social\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\nc_social\NcSocialStorage;
use Drupal\Core\Link;
use Drupal\Core\Url;

class NcSocialController extends ControllerBase {

  public function contentList() {
    $num_per_page = 25;
    $total = NcSocialStorage::load(array(), true);
    $page = pager_default_initialize($total, $num_per_page);
    $orderby = array(
      'field' => 'sn_order',
      'direction' => 'ASC',
    );

    $rows = array();
    $headers = array(
      t('Label'),
      t('Order'),
      t('Actions'),
    );

    foreach ($entries = NcSocialStorage::load(array(), false, $page, $num_per_page, $orderby) as $entry) {
      $urlEdit = Url::fromRoute('ncsocial.edit', array('param' => $entry->sn_id));
      $urlDelete = Url::fromRoute('ncsocial.delete', array('param' => $entry->sn_id));
      $linkEdit = Link::fromTextAndUrl(t('Edit'), $urlEdit);
      $linkDelete = Link::fromTextAndUrl(t('Delete'), $urlDelete);

      $fields = array(
        'label' => $entry->sn_label,
        'order' => $entry->sn_order,
        'actions' => @render($linkEdit->toRenderable()) ." ". @render($linkDelete->toRenderable()),
      );
      $rows[] = $fields;
    }

    return array(
      'add' => array(
        '#type' => 'link',
        '#title' => "Ajouter un réseau social",
        '#url' => Url::fromRoute('ncsocial.add'),
        '#attributes' => array(
          'class' => ['button'],
        ),
      ),
      'table-list' => array(
        '#theme' => 'table-list',
        '#header' => $headers,
        '#rows' => $rows,
        '#empty' => "Aucun réseau social pour le moment",
      ),
      'pages' => array(
        '#type' => 'pager',
      ),
      '#cache' => array(
        'max-age' => '0',
      ),
    );
  }

  public function delete($param){
    NcSocialStorage::delete( array( 'sn_id' => $param ) );

    return array(
      '#markup' => "Ce réseau social a bien été supprimé",
      'actions' => array(
        '#type' => 'link',
        '#title' => "Retour à la liste",
        '#url' => Url::fromRoute('ncsocial.list'),
        '#attributes' => array(
          'class' => ['button'],
        ),
      ),
      '#cache' => array(
        'max-age' => '0',
      ),
    );
  }
}
