<?php
namespace Drupal\nc_site\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Home - Livret' Block.
 *
 * @Block(
 *   id = "nc_site_livret",
 *   admin_label = @Translation("Home - Livret - Bloc"),
 * )
 */

class LivretBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $data = [];
        $config = \Drupal::config('ncsite.config.livret');

        $url = '';
        $file = File::load($config->get('image')[0]);
        if(!empty($file)){
            $path = $file->getFileUri();
            $url = file_create_url($path);
        }
        $urlPdf = '';
        $filePdf = File::load($config->get('file')[0]);
        if(!empty($filePdf)){
            $path = $filePdf->getFileUri();
            $urlPdf = file_create_url($path);
        }

        $data = [
            'image' => $url,
            'file' => $urlPdf,
            'code' => $config->get('code'),
            'url' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/170'),
        ];

        if(count($data) > 0){
            $build = [
                '#theme' => 'livret',
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

    public function getCacheMaxAge() {
	    return 0;
    }
}
