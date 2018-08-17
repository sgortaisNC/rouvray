<?php

use Drupal\Core\Messenger\MessengerInterface;

function site_preprocess_block(&$variables){
    $variables['isEmpty'] = false;
    if(isset($variables['content']) && isset($variables['content']['#type'])){
        if($variables['content']['#type'] == "markup" && empty($variables['content']['#markup'])){
            $variables['isEmpty'] = true;
        }
    }

    if(isset($variables['elements']['#id'])){
        switch($variables['elements']['#id']){
            case 'site_navigationprincipale_sidebar':
                $menu_tree = Drupal::menuTree();
                $parameters = $menu_tree->getCurrentRouteMenuTreeParameters('main');
                $parameters->setTopLevelOnly();
                $main_menu_top_level = $menu_tree->load('main', $parameters);
                foreach ($main_menu_top_level as $item) {
                    if ($item->inActiveTrail === true) {
                        $variables['label'] = $item->link->getTitle();
                    }
                }
                break;

            default:
                break;
        }

    }
}

function site_theme_suggestions_block_alter( array &$suggestions, array $variables ) {
	$node = \Drupal::routeMatch()->getParameter('node');
	if ($node) {
		// You can get nid and anything else you need from the node object.
		$bundle = $node->getType();
		$suggestions[] = 'block__' . $bundle.'__'.$variables["elements"]["#base_plugin_id"];
	}
}
