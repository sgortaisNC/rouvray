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
}
