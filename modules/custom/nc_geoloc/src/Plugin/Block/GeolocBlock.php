<?php
namespace Drupal\nc_geoloc\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Géolocalisation, carte' Block.
 *
 * @Block(
 *   id = "nc_geoloc",
 *   admin_label = @Translation("Géolocalisation, carte - Bloc"),
 * )
 */

class GeolocBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $data = [
            'lat' => theme_get_setting('site_options.geoloc.lat'),
            'long' => theme_get_setting('site_options.geoloc.long'),
            'coordonnees' => urlencode(strip_tags(theme_get_setting('site_options.coordonnees')['value'])),
        ];

        if(count($data) > 0){
            $build = [
                '#theme' => 'geoloc',
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
