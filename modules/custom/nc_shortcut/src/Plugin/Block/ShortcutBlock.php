<?php
namespace Drupal\nc_shortcut\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Accès rapide' Block.
 *
 * @Block(
 *   id = "nc_shortcut",
 *   admin_label = @Translation("Accès rapide - Bloc"),
 * )
 */

class ShortcutBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $data = [];
        $config = \Drupal::config('ncshortcut.config');

        $url1 = '';
        $file1 = File::load($config->get('link1.image')[0]);
        if(!empty($file1)){
            $path = $file1->getFileUri();
            $url1 = ImageStyle::load('icone')->buildUrl($path);
        }

        $url2 = '';
        $file2 = File::load($config->get('link2.image')[0]);
        if(!empty($file2)){
            $path = $file2->getFileUri();
            $url2 = ImageStyle::load('icone')->buildUrl($path);
        }

        $url3 = '';
        $file3 = File::load($config->get('link3.image')[0]);
        if(!empty($file3)){
            $path = $file3->getFileUri();
            $url3 = ImageStyle::load('icone')->buildUrl($path);
        }

        $url4 = '';
        $file4 = File::load($config->get('link4.image')[0]);
        if(!empty($file4)){
            $path = $file4->getFileUri();
            $url4 = ImageStyle::load('icone')->buildUrl($path);
        }

        $data = [
            'link1' => [
                'image' => $url1,
                'title' => $config->get('link1.title'),
                'link' => $config->get('link1.link'),
                'hide' => $config->get('link1.hide'),
            ],
            'link2' => [
                'image' => $url2,
                'title' => $config->get('link2.title'),
                'link' => $config->get('link2.link'),
                'hide' => $config->get('link2.hide'),
            ],
            'link3' => [
                'image' => $url3,
                'title' => $config->get('link3.title'),
                'link' => $config->get('link3.link'),
                'hide' => $config->get('link3.hide'),
            ],
            'link4' => [
                'image' => $url4,
                'title' => $config->get('link4.title'),
                'link' => $config->get('link4.link'),
                'hide' => $config->get('link4.hide'),
            ],
        ];

        if(count($data) > 0){
            $build = [
                '#theme' => 'shortcut',
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
