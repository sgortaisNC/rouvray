<?php
namespace Drupal\nc_site\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Home - MultiSite' Block.
 *
 * @Block(
 *   id = "nc_site_multisite",
 *   admin_label = @Translation("Home - Multi Sites - Bloc"),
 * )
 */

class MultiSiteBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $data = [];
        $config = \Drupal::config('ncsite.config.multisite');

        $url1 = '';
        $file1 = File::load($config->get('multisite1.image')[0]);
        if(!empty($file1)){
            $path = $file1->getFileUri();
            $url1 = ImageStyle::load('multisite')->buildUrl($path);
        }
        $urlLogo1 = '';
        $fileLogo1 = File::load($config->get('multisite1.logo')[0]);
        if(!empty($fileLogo1)){
            $path = $fileLogo1->getFileUri();
            $urlLogo1 = ImageStyle::load('logo')->buildUrl($path);
        }

        $url2 = '';
        $file2 = File::load($config->get('multisite2.image')[0]);
        if(!empty($file2)){
            $path = $file2->getFileUri();
            $url2 = ImageStyle::load('multisite')->buildUrl($path);
        }
        $urlLogo2 = '';
        $fileLogo2 = File::load($config->get('multisite2.logo')[0]);
        if(!empty($fileLogo2)){
            $path = $fileLogo2->getFileUri();
            $urlLogo2 = ImageStyle::load('logo')->buildUrl($path);
        }

        $url3 = '';
        $file3 = File::load($config->get('multisite3.image')[0]);
        if(!empty($file3)){
            $path = $file3->getFileUri();
            $url3 = ImageStyle::load('multisite')->buildUrl($path);
        }
        $urlLogo3 = '';
        $fileLogo3 = File::load($config->get('multisite3.logo')[0]);
        if(!empty($fileLogo3)){
            $path = $fileLogo3->getFileUri();
            $urlLogo3 = ImageStyle::load('logo')->buildUrl($path);
        }

        $url4 = '';
        $file4 = File::load($config->get('multisite4.image')[0]);
        if(!empty($file4)){
            $path = $file4->getFileUri();
            $url4 = ImageStyle::load('multisite')->buildUrl($path);
        }
        $urlLogo4 = '';
        $fileLogo4 = File::load($config->get('multisite4.logo')[0]);
        if(!empty($fileLogo4)){
            $path = $fileLogo4->getFileUri();
            $urlLogo4 = ImageStyle::load('logo')->buildUrl($path);
        }

        $data = [
            'multisite1' => [
                'image' => $url1,
                'logo' => $urlLogo1,
                'title' => $config->get('multisite1.title'),
                'link' => $config->get('multisite1.link'),
            ],
            'multisite2' => [
                'image' => $url2,
                'logo' => $urlLogo2,
                'title' => $config->get('multisite2.title'),
                'link' => $config->get('multisite2.link'),
            ],
            'multisite3' => [
                'image' => $url3,
                'logo' => $urlLogo3,
                'title' => $config->get('multisite3.title'),
                'link' => $config->get('multisite3.link'),
            ],
            'multisite4' => [
                'image' => $url4,
                'logo' => $urlLogo4,
                'title' => $config->get('multisite4.title'),
                'link' => $config->get('multisite4.link'),
            ],
        ];

        if(count($data) > 0){
            $build = [
                '#theme' => 'multisites',
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
