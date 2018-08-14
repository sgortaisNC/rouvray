<?php
namespace Drupal\nc_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Actualités' Block.
 *
 * @Block(
 *   id = "nc_news",
 *   admin_label = @Translation("Actualités - Bloc"),
 * )
 */

class NewsBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $contents = $nids = [];

        $page = 0;
        $num_per_page = 4;
        $offset = $num_per_page * $page;

        $query = \Drupal::entityQuery('node');
        $query->condition('type', ['article'], 'IN')
            ->condition('status', 1);

        $nids = $query->sort('field_date', 'DESC')
            ->sort('created', 'DESC')
            ->range($offset, $num_per_page)
            ->execute();

        if(count($nids) > 0) {
            foreach ($nids as $nid) {
                $nodeContent = Node::load($nid);
                if(!empty($nodeContent)){
                    //Dates
                    $date = '';
                    if(count($nodeContent->get('field_date')->getValue()) > 0){
                        $date = \Drupal::service('date.formatter')->format((int)strtotime($nodeContent->get('field_date')->getValue()[0]['value']), 'actualite');
                    }
                    $dateFin = '';
                    if(count($nodeContent->get('field_date_other')->getValue()) > 0){
                        $dateFin = \Drupal::service('date.formatter')->format((int)strtotime($nodeContent->get('field_date_other')->getValue()[0]['value']), 'actualite');
                    }

                    //Image
                    $urlImage = $altImage = '';
                    if(count($nodeContent->get('field_image')->getValue()) > 0){
                        $file = File::load($nodeContent->get('field_image')->getValue()[0]['target_id']);
                        if(!empty($file)){
                            $path = $file->getFileUri();
                            $urlImage = file_create_url(ImageStyle::load('detail')->buildUrl($path));
                            if(count($nodeContent->get('field_image')->getValue()) > 0){
                                $altImage = $nodeContent->get('field_image')->getValue()[0]['alt'];
                            }else{
                                $altImage =  $nodeContent->getTitle();
                            }
                        }
                    }else{
                        $fileUuid = $nodeContent->get('field_image')->getSetting('default_image')['uuid'];
                        $file = \Drupal::service('entity.repository')->loadEntityByUuid('file', $fileUuid);
                        if(!empty($file)){
                            $path = $file->getFileUri();
                            $urlImage = file_create_url(ImageStyle::load('detail')->buildUrl($path));
                            $altImage =  $nodeContent->getTitle();
                        }
                    }

                    $contents[] = [
                        'title' => $nodeContent->getTitle(),
                        'image' => [
                            'url' => $urlImage,
                            'alt' => $altImage,
                        ],
                        'date' => $date,
                        'dateFin' => $dateFin,
                        'type' => $nodeContent->get('field_affichage')->getValue()[0]['value'],
                        'url' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nodeContent->id()),
                    ];
                }
            }
        }

        if(count($contents) > 0){
            $build = [
                '#theme' => 'news',
                '#data' => $contents,
                '#url' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/112'),
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
