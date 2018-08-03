<?php
namespace Drupal\nc_node_banniere\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Bannière' Block.
 *
 * @Block(
 *   id = "nc_node_banniere",
 *   admin_label = @Translation("Bannière - Bloc"),
 * )
 */

class BanniereBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {

	    $node = \Drupal::routeMatch()->getParameter('node');
	    if ($node) {
		    // You can get nid and anything else you need from the node object.
		    $image = "";
		    if  (!empty($node->get("field_background")->getValue()[0]["target_id"])){
			    $fid = $node->get("field_background")->getValue()[0]["target_id"];
			    $file = File::Load($fid);
			    $image = Url::fromUri($file->getFileUri());
		    }else{
			    $fileUuid = $node->get('field_background')->getSetting('default_image')['uuid'];
			    $file = \Drupal::service('entity.repository')->loadEntityByUuid('file', $fileUuid);
			    if(!empty($file)){
				    $image = ImageStyle::load('background')->buildUrl($file->getFileUri());
			    }
		    }

		    $data = [
		        "titre"	=> $node->getTitle(),
			    "image" => [
			    	"url" => $image,
				    "alt" => $node->getTitle()
			    ]
		    ];

		    $build = [
			    '#theme' => 'banniere',
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
