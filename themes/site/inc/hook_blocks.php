<?php

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