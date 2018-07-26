<?php
namespace Drupal\nc_download\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Téléchargement' Block.
 *
 * @Block(
 *   id = "nc_download",
 *   admin_label = @Translation("Téléchargement - Bloc"),
 * )
 */

class DownloadBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $files = [];
        $node = '';

        $route_name = \Drupal::routeMatch()->getRouteName();
        if ($route_name == 'entity.node.canonical' || $route_name == 'entity.node.latest_version') {
            $node = \Drupal::routeMatch()->getParameter('node');
        } elseif ($route_name == 'entity.node.preview') {
            $node = \Drupal::routeMatch()->getParameter('node_preview');
        }

        if (is_object($node)) {
            if ($node->hasField('field_files') && count($node->get('field_files')->getValue()) > 0) {
                foreach ($node->get('field_files')->getValue() as $fichier) {
                    $file = \Drupal\file\Entity\File::load($fichier['target_id']);
                    if (!empty($file)) {
                        $files[] = [
                            'label' => (!empty($fichier['description'])) ? $fichier['description'] : str_replace("_", " ", $file->getFilename()),
                            'url' => file_create_url($file->getFileUri()),
                            'icon' => $this->getIconContentType($file->getMimeType()),
                        ];
                    }
                }
            }
        }

        if(count($files) > 0){
            $build = [
                '#theme' => 'downloadlist',
                '#data' => $files,
            ];
        }else{
            $build = [];
        }

        return $build;
    }

    private function getIconContentType($type){
        $mime_types = array(

            'text/plain' => 'file-text-o',
            'text/html' => 'file-code-o',
            'text/css' => 'file-code-o',
            'application/javascript' => 'file-code-o',
            'application/json' => 'file-code-o',
            'application/xml' => 'file-code-o',
            'application/x-shockwave-flash' => 'file-code-o',
            'video/x-flv' => 'file-video-o',

            // images
            'image/png' => 'file-image-o',
            'image/jpeg' => 'file-image-o',
            'image/gif' => 'file-image-o',
            'image/bmp' => 'file-image-o',
            'image/vnd.microsoft.icon' => 'file-image-o',
            'image/tiff' => 'file-image-o',
            'image/svg+xml' => 'file-image-o',

            // archives
            'application/zip' => 'file-archive-o',
            'application/x-rar-compressed' => 'file-archive-o',
            'application/x-msdownload' => 'file-code-o',
            'application/vnd.ms-cab-compressed' => 'file-archive-o',

            // audio/video
            'audio/mpeg' => 'file-audio-o',
            'video/quicktime' => 'file-video-o',

            // adobe
            'application/pdf' => 'file-pdf-o',
            'image/vnd.adobe.photoshop' => 'file-image-o',
            'application/postscript' => 'file-image-o',

            // ms office
            'application/msword' => 'file-word-o',
            'application/rtf' => 'file-word-o',
            'application/vnd.ms-excel' => 'file-excel-o',
            'application/vnd.ms-powerpoint' => 'file-powerpoint-o',

            // open office
            'application/vnd.oasis.opendocument.text' => 'file-word-o',
            'application/vnd.oasis.opendocument.spreadsheet' => 'file-excel-o',
        );

        if(isset($mime_types[$type]))
            return $mime_types[$type];
        else
            return 'file-code-o';
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
