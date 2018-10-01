<?php

namespace Drupal\nc_share\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Block\BlockBase;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Share Button' Block.
 *
 * @Block(
 *   id = "nc_share_block",
 *   admin_label = @Translation("Share Button - Block"),
 * )
 */
class NcShareBlock extends BlockBase
{
    /**
     * {@inheritdoc}
     */

    public function build()
    {
        $rows = [];
        $config = \Drupal::config('nc_share.settings');

        $request = \Drupal::request();
        $title = '';
        if ($route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT)) {
            $title = \Drupal::service('title_resolver')->getTitle($request, $route);
        }

        $url = Url::fromRoute('<current>', [], ['absolute' => 'true'])->toString();
        if (!is_null($url)) {
            $rows = [
                'facebook' => [
                    'active' => $config->get('facebook'),
                    'url' => $url,
                    'titre' => $title,
                ],
                'twitter' => [
                    'active' => $config->get('twitter'),
                    'url' => $url,
                    'titre' => $title,
                ],
                'google' => [
                    'active' => $config->get('google'),
                    'url' => $url,
                    'titre' => $title,
                ],
                'linkedin' => [
                    'active' => $config->get('linkedin'),
                    'url' => $url,
                    'titre' => $title,
                ],
                'pinterest' => [
                    'active' => $config->get('pinterest'),
                    'url' => $url,
                    'titre' => $title,
                ],
                'email' => [
                    'active' => $config->get('mail'),
                    'url' => $url,
                    'titre' => $title,
                ],
                'rss' => [
                    'active' => $config->get('rss'),
                    'url' => $config->get('url_rss'),
                    'titre' => $title,
                ],
                'print' => [
                    'active' => $config->get('print'),
                    'url' => $url,
                    'titre' => $title,
                ],
            ];
        }

        if (count($rows) > 0) {
            $build = [
                '#theme' => 'nc_share_buttons',
                '#data' => $rows,
                '#attached' => [
                    'library' => [
                        'nc_share/share',
                    ],
                ],
            ];
        } else {
            $build = [];
        }

        return $build;
    }

    public function getCacheTags()
    {
        //With this when your node change your block will rebuild
        if ($node = \Drupal::routeMatch()->getParameter('node')) {
            //if there is node add its cachetag
            return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
        } else {
            //Return default tags instead.
            return parent::getCacheTags();
        }
    }

    public function getCacheContexts()
    {
        //if you depends on \Drupal::routeMatch()
        //you must set context of this block with 'route' context tag.
        //Every new route this block will rebuild
        return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
    }
}
