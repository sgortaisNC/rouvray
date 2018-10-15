<?php
namespace Drupal\nc_options\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Option de thème' Block.
 *
 * @Block(
 *   id = "nc_options",
 *   admin_label = @Translation("Option de thème - Bloc"),
 * )
 */

class OptionsBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        $form['nc_options_option'] = [
            '#type' => 'select',
            '#options' => [
                'site_options.telephone' => 'Numéro de téléphone',
                'site_options.coordonnees' => 'Coordonnées',
                'site_options.logo_footer' => 'Logo du pied de page',
                'site_options.urgence' => 'Bouton Urgence',
                'site_options.contact' => 'Bouton Contactez-nous',
                'site_options.copyright' => 'Copyright',
            ],
            '#title' => 'Liste des options',
            '#default_value' => isset($config['nc_options_option']) ? $config['nc_options_option'] : '',
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['nc_options_option'] = $values['nc_options_option'];
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $config = $this->getConfiguration();
        $data = [];

        //OPTION
        if (!empty($config['nc_options_option'])) {
            switch($config['nc_options_option']){
                case 'site_options.coordonnees':
                    $data['option']['value'] = theme_get_setting($config['nc_options_option'])['value'];
                    break;

                case 'site_options.contact':
                    $data['option']['value'] = theme_get_setting($config['nc_options_option'].'.url');
                    break;

                case 'site_options.urgence':
                    break;

                default:
                    $data['option']['value'] = theme_get_setting($config['nc_options_option']);
                    break;
            }
        }

        if(count($data) > 0){
            $build = [
                '#theme' => 'option',
                '#data' => $data,
                '#type' => $config['nc_options_option'],
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

