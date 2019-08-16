<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

define('AUTOREMOTEADDRMSG', 'https://autoremotejoaomgcd.appspot.com/sendmessage');
define('AUTOREMOTEADDRNOTIF', 'https://autoremotejoaomgcd.appspot.com/sendnotification');

class AutoRemote extends eqLogic {

  public function preUpdate() {

      if ($this->getConfiguration('key') == '') {
          throw new Exception(__('Le champs clé ne peut être vide',__FILE__));
      }

      if ($this->getConfiguration('target') == '') {
        $this->setConfiguration('target', "");
      }

  }

  public function postSave() {

    $notification = $this->getCmd(null, 'notification');

    if (!is_object($notification)) {
			$notification = new AutoRemoteCmd();
			$notification->setLogicalId('notification');
			$notification->setIsVisible(1);
			$notification->setName(__('Envoyer notification', __FILE__));
		}
		$notification->setType('action');
		$notification->setSubType('message');
		$notification->setEventOnly(1);
		$notification->setEqLogic_id($this->getId());
		$notification->save();

    $message = $this->getCmd(null, 'message');
		if (!is_object($message)) {
			$message = new AutoRemoteCmd();
			$message->setLogicalId('message');
			$message->setIsVisible(1);
			$message->setName(__('Envoyer message', __FILE__));
		}
		$message->setType('action');
		$message->setSubType('message');
    $message->setDisplay('title_disable', 1);
    $message->setDisplay('message_placeholder', __('Message', __FILE__));
		$message->setEventOnly(1);
		$message->setEqLogic_id($this->getId());
		$message->save();

    }
}

class AutoRemoteCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    public function preSave() {
    }

    public function execute($_options = null) {
//        if ($_options === null) {
//            throw new Exception(__('Les options de la fonction ne peuvent etre null', __FILE__));
//        }
//        if ($_options['message'] == '') {
//            throw new Exception(__('Le message ne peut être vide', __FILE__));
//        }
//
//        $_options['message'] = rawurlencode($_options['message']);
//        $_options['message'] = str_replace("%26", "&", $_options['message']);
//        $_options['message'] = str_replace("%3D", "=", $_options['message']);
//
//        if ($_options['title'] == '') {
//        $url = AUTOREMOTEADDR . '?key=' . trim($this->getConfiguration('key')) . '&message=' . $_options['message'];
//        $ch = curl_init($url);
//        curl_exec($ch);
//        curl_close($ch);
//        }else{
//        $url = AUTOREMOTEADDR2 . '?key=' . trim($this->getConfiguration('key')) .  '&title=' . $_options['title'] . $_options['message'];
//        $ch = curl_init($url);
//        curl_exec($ch);
//        curl_close($ch);
//        }

        $autoremote = $this->getEqLogic();
        $key = $autoremote->getConfiguration('key');
        $target = $autoremote->getConfiguration('target');
        $cmd_logical = $this->getLogicalId();

        $message = rawurlencode($_options['message']);
        $message = str_replace("%26", "&", $message);
        $message = str_replace("%3D", "=", $message);

        if( $cmd_logical == 'message'){

            // $url ='https://autoremotejoaomgcd.appspot.com/sendmessage?key=' . trim($key) .  '&message=' . $message;
            $url = AUTOREMOTEADDRMSG . '?key=' . trim($key) . '&message=' . $message . '&target=' . $target;
            log::add('AutoRemote','debug',print_r('Envoi du message : '.$_options['message'],true));
            $ch = curl_init($url);
            curl_exec($ch);
            curl_close($ch);

        }else{

            $title = rawurlencode($_options['title']);
            $title = str_replace("%26", "&", $title);
            $title = str_replace("%3D", "=", $title);

            $url = AUTOREMOTEADDRNOTIF . '?key=' . trim($key) .  '&title=' . $title . '&text=' . $message;
            log::add('AutoRemote','debug',print_r('Envoi de la notification : '.$_options['title'],true));
            $ch = curl_init($url);
            curl_exec($ch);
            curl_close($ch);

        }
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>
