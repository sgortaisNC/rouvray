<?php
namespace Drupal\nc_site\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Database\Database;

/**
 * Provides a 'Home - Consultations Form' Block.
 *
 * @Block(
 *   id = "nc_site_consultations_form",
 *   admin_label = @Translation("Home - Consultations Form - Bloc"),
 * )
 */

class ConsultationsBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $tabPatients = [];
        $patients = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('types_patient');
        foreach ($patients as $patient) {
            $tabPatients[$patient->tid] = $patient->name;
        }

        $tabVilles = [];
        $connection = Database::getConnection();
        $query = $connection->select('nc_villes', 'v')
            ->fields('v', array('id', 'ville', 'cp'))
            ->orderBy('ville', 'ASC');
        $result = $query->execute();
        foreach ($result as $record) {
            $tabVilles[$record->id] = $record->ville.' ('.$record->cp.')';
        }

        $data = [
            'form1' =>[
                'title' => 'Où consulter ?',
                'action' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/107'),
                'form' => [
                    'lieu' => [
                        '#type' => 'select',
                        '#title' => 'Choisir votre commune',
                        '#attribute' => [
                            'class' => 'form-control',
                            'name' => 'ville',
                        ],
                        '#options' => $tabVilles,
                    ],
                    'type' => [
                        '#type' => 'select',
                        '#title' => 'Type de patient',
                        '#attribute' => [
                            'class' => 'form-control',
                            'name' => 'type',
                        ],
                        '#options' => $tabPatients,
                    ],
                ],
            ],
            'form2' =>[
                'title' => 'Consultation spécialisée',
                'action' => \Drupal::service('path.alias_manager')->getAliasByPath('/node/1'),
                'form' => [
                    'pathologie' => [
                        '#type' => 'textfield',
                        '#title' => 'Pathologie',
                        '#attribute' => [
                            'class' => 'form-control',
                            'name' => 'pathologie',
                        ],
                    ],
                ],
            ],
        ];

        if(count($data) > 0){
            $build = [
                '#theme' => 'consultationsform',
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
