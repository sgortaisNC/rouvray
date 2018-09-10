<?php
namespace Drupal\nc_shortcut\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Accès rapide - Latéral' Block.
 *
 * @Block(
 *   id = "nc_shortcut_lateral",
 *   admin_label = @Translation("Accès rapide - Latéral - Bloc"),
 * )
 */

class LateralBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $data = [
            /*'link1' => [
                'icon' => '/themes/site/img/agenda_ico.png',
                'title' => 'Prendre rendez-vous',
                'link' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/1'),
            ],*/
            'link2' => [
                'icon' => '/themes/site/img/notepad_ico.png',
                'title' => 'Préparer son hospitalisation',
                'link' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/1'),
            ],
            'link3' => [
                'icon' => '/themes/site/img/pharm_ico.png',
                'title' => 'Urgences',
                'link' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/1'),
            ],
            'link4' => [
                'icon' => '/themes/site/img/map_ico.png',
                'title' => 'Plan d\'accès',
                'link' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/1'),
            ],
            'link5' => [
                'icon' => '/themes/site/img/mail_ico.png',
                'title' => 'Contactez-nous',
                'link' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/1'),
            ],
        ];

        if(count($data) > 0){
            $build = [
                '#theme' => 'lateral',
                '#data' => $data,
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
