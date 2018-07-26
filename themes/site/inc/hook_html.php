<?php

function site_preprocess_html(&$variables){
    //Balise no-index/no-follow
    $optionsRobots = theme_get_setting('site_options.site_robots');
    if($optionsRobots == 1) {
        $noindex = [
            '#tag' => 'meta',
            '#attributes' => [
                'name' => 'robots',
                'content' => 'noindex, nofollow',
            ],
        ];
        $variables['page']['#attached']['html_head'][] = [$noindex, 'noindex'];
    }
}