<?php

function site_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = NULL) {
    // Work-around for a core bug affecting admin themes. See issue #943212.
    if (isset($form_id)) {
        return;
    }

    $form['site_options'] = [
        '#type' => 'fieldset',
        '#title' => "Options complèmentaires",
        '#tree' => TRUE,
    ];

        $form['site_options']['site_robots'] = array(
            '#type'          => 'checkbox',
            '#title'         => "Ne pas montrer mon site aux robots de référencement",
            '#default_value' => theme_get_setting('site_options.site_robots'),
            '#description'   => "Si la case est coché les balises no-index/no-follow s'afficheront sur le site",
        );
}