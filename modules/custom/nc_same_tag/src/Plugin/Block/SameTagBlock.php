<?php
namespace Drupal\nc_same_tag\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Sur le même thème' Block.
 *
 * @Block(
 *   id = "nc_sametag",
 *   admin_label = @Translation("Sur le même thème - Bloc"),
 * )
 */

class SameTagBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $contents = [];
        $node = '';

        $route_name = \Drupal::routeMatch()->getRouteName();
        if ($route_name == 'entity.node.canonical' || $route_name == 'entity.node.latest_version') {
            $node = \Drupal::routeMatch()->getParameter('node');
        } elseif ($route_name == 'entity.node.preview') {
            $node = \Drupal::routeMatch()->getParameter('node_preview');
        }

        if (is_object($node)) {
            if ($node->hasField('field_tags') && count($node->get('field_tags')->getValue()) > 0) {
                foreach ($node->get('field_tags')->getValue() as $tag) {
                    $tabTags[] = $tag['target_id'];
                }
                $query = \Drupal::entityQuery('node');
                $query-->condition('field_tags', $tabTags, 'IN')
                    ->condition('status', 1)
                    ->condition('nid', $node->id(), '!=');

                $nids = $query->sort('field_date', 'DESC')
                    ->sort('created', 'DESC')
                    ->execute();

                if (count($nids) > 0) {
                    foreach ($nids as $nid) {
                        $nodeContent = Node::load($nid);
                        $tabTagsNode = $nodeContent->get('field_tags')->getValue();
                        $countTags = 0;
                        if (count($tabTagsNode) > 0) {
                            foreach ($tabTagsNode as $tabTagNode) {
                                if (in_array($tabTagNode['target_id'], $tabTags)) {
                                    $countTags++;
                                }
                            }
                        }
                        $tabNodes[$countTags][$nid] = $nodeContent;
                    }
                    arsort($tabNodes);

                    $result = [];
                    if (count($tabNodes) > 0) {
                        foreach ($tabNodes as $key => $tabNode) {
                            $result = array_merge($result, $tabNode);
                        }

                        for ($i = 0; $i < 4; $i++) {
                            if (!empty($result[$i])) {
                                $build = \Drupal::entityTypeManager()->getViewBuilder('node')->view($result[$i], 'slider');
                                if (!empty($build)) {
                                    $contents[] = \Drupal::service('renderer')->render($build);
                                }
                            }
                        }
                    }
                }
            }
        }

        if(count($contents) > 0){
            $build = [
                '#theme' => 'sametag',
                '#data' => $contents,
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
