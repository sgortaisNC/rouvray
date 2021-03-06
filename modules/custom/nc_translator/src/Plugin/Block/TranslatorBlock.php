<?php
namespace Drupal\nc_translator\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Translator' Block.
 *
 * @Block(
 *   id = "nc_translator",
 *   admin_label = @Translation("Translator - Bloc"),
 * )
 */

class TranslatorBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $build = [
            '#theme' => 'translator',
            '#data' => NULL,
        ];

        return $build;
    }

    public function getCacheTags() {
        //With this when your node change your block will rebuild
        if ($node = \Drupal::routeMatch()->getParameter('node')) {
            //if there is node add its cachetag
            return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
        } else {
            //Return default tags instead.
            return parent::getCacheTags();
        }
    }

    public function getCacheContexts() {
        //if you depends on \Drupal::routeMatch()
        //you must set context of this block with 'route' context tag.
        //Every new route this block will rebuild
        return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
    }
}
