<?php
namespace Drupal\nc_links\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Liens utiles' Block.
 *
 * @Block(
 *   id = "nc_links",
 *   admin_label = @Translation("Liens utiles - Bloc"),
 * )
 */

class LinksBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $links = [];
        $node = '';
    
        $route_name = \Drupal::routeMatch()->getRouteName();
        if ($route_name == 'entity.node.canonical' || $route_name == 'entity.node.latest_version') {
            $node = \Drupal::routeMatch()->getParameter('node');
        } elseif ($route_name == 'entity.node.preview') {
            $node = \Drupal::routeMatch()->getParameter('node_preview');
        }

        if (is_object($node)) {
            if($node->hasField('field_links') && count($node->get('field_links')->getValue()) > 0){
                foreach ($node->get('field_links')->getValue() as $link){
                    $links[] = [
                        'title' => $link['title'],
                        'url' => $link['uri'],
                    ];
                }
            }
        }

        if(count($links) > 0){
            $build = [
                '#theme' => 'linkslist',
                '#data' => $links,
            ];
        }else{
            $build = [];
        }

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
