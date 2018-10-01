<?php

/**
 * @file
 * Contains \Drupal\nc_share\Controller\NcShareController.
 */

namespace Drupal\nc_share\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class NcShareController extends ControllerBase {

    public function sendEmail() {
        $config = \Drupal::config('nc_share.settings');

        $data['response'] = false;
        $name = \Drupal::request()->request->get('name');
        $email = \Drupal::request()->request->get('email');
        $link = \Drupal::request()->request->get('link');
        $subject = $config->get('subject');
        $message = $config->get('message')['value'];

        $message = str_replace("[share_link]", $link, $message);
        $message = str_replace("[name]", $name, $message);

        if (!empty($name) && !empty($email) && !empty($message)) {
            $params = [
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'subject' => $subject,
            ];
            $sendFunction = $this->send($params);
            $data['response'] = $sendFunction;
        } else {
            $data['response'] = 'Error 3 : '.$name . '-' . $email . '-' . $subject . '-' . $message;
        }

        return new JsonResponse($data);
    }

    private function send($data = NULL) {
        if (!is_null($data)) {
            $mailManager = \Drupal::service('plugin.manager.mail');
            $module = 'nc_share';
            $key = 'share_node';

            $to = $data['email'];
            $params['subject'] = $data['subject'];
            $params['message'] = $data['message'];
            $params['name'] = $data['name'];

            $langcode = \Drupal::currentUser()->getPreferredLangcode();
            $send = true;

            $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
            if ($result['result'] == "1") {
                return true;
            } else {
                return 'Error 1 - Email non-envoyé';
            }
        } else {
            return 'Error 2 - Data vide';
        }
    }
}
