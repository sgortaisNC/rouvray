<?php
namespace Drupal\nc_social\Plugin\Block;

use Drupal\nc_social\NcSocialStorage;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Social Network' Block.
 *
 * @Block(
 *   id = "nc_social_block",
 *   admin_label = @Translation("Social Network Block"),
 * )
 */

class NcSocialBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */

  public function build() {
    $rows = [];
    $page = 0;
    $num_per_page = 7;
    $orderby = array(
      'field' => 'sn_order',
      'direction' => 'ASC',
    );

    foreach ($entries = NcSocialStorage::load(array(), false, $page, $num_per_page, $orderby) as $entry) {
      $fields = array(
        'label' => $entry->sn_label,
        'link' => $entry->sn_link,
        'icon' => $entry->sn_icon,
      );
      $rows[] = $fields;
    }

    return array(
      '#theme' => 'link-list',
      '#rows' => $rows,
      '#cache' => array(
        'keys' => ['ncsocial_block'],
        'max-age' => 0
      ),
    );
  }
}
