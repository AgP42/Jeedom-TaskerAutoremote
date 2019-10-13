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

/* Update aout 2019 par AgP42 - Jeedom 3.3.29 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

define('AUTOREMOTEADDRMSG', 'autoremotejoaomgcd.appspot.com/sendmessage');
define('AUTOREMOTEADDRNOTIF', 'autoremotejoaomgcd.appspot.com/sendnotification');

class TaskerAutoRemote extends eqLogic {
  /*     * *************************Attributs****************************** */



  /*     * ***********************Methode static*************************** */

  /*
   * Fonction exécutée automatiquement toutes les minutes par Jeedom
    public static function cron() {

    }
   */


  /*
   * Fonction exécutée automatiquement toutes les heures par Jeedom
    public static function cronHourly() {

    }
   */

  /*
   * Fonction exécutée automatiquement tous les jours par Jeedom
    public static function cronDaily() {

    }
   */

    public function buildMessageUrl($key, $message) {

      // config options messages
      $target = $this->getConfiguration('target');

      // config option messages ET notifications
      $sender = $this->getConfiguration('sender');
      $password = $this->getConfiguration('password');
      $ttl = $this->getConfiguration('ttl');
      $collapseKey = $this->getConfiguration('collapseKey');

      // check if http or https
      if ($this->getConfiguration('https', 0) == 1) {
        $http_https = 'http://';
      } else {
        $http_https = 'https://';
      }

      return $url = $http_https . AUTOREMOTEADDRMSG . '?key=' . trim($key) . '&message=' . $message . '&target=' . $target . '&sender=' . $sender . '&password=' . $password . '&ttl=' .$ttl . '&collapseKey=' . $collapseKey;

    }

    public function buildNotificationUrl($key, $title, $message) {

      // config option messages ET notifications
      $sender = $this->getConfiguration('sender');
      $password = $this->getConfiguration('password');
      $ttl = $this->getConfiguration('ttl');
      $collapseKey = $this->getConfiguration('collapseKey');

      // config option des notifications
      $sound = $this->getConfiguration('sound');
      $status_bar_icon = $this->getConfiguration('status_bar_icon');
      $icon = $this->getConfiguration('icon');
      $picture = $this->getConfiguration('picture');

      $subtext = rawurlencode($this->getConfiguration('subtext')); // il est necessaire d'encoder ce champ car il peut y avoir des espaces ou des caractéres speciaux

      $url_on_tap = $this->getConfiguration('url_on_tap');
      $action_on_tap = $this->getConfiguration('action_on_tap');
      $action_on_receive = $this->getConfiguration('action_on_receive');
      $action_on_dismiss = $this->getConfiguration('action_on_dismiss');

      $priority = $this->getConfiguration('priority');
      $notif_id = $this->getConfiguration('notif_id');

      $action1name = rawurlencode($this->getConfiguration('action1name')); // à encoder car peut avoir des espaces ou des caractéres speciaux
      $action1 = $this->getConfiguration('action1');
      $action2name = rawurlencode($this->getConfiguration('action2name')); // à encoder car peut avoir des espaces ou des caractéres speciaux
      $action2 = $this->getConfiguration('action2');
      $action3name = rawurlencode($this->getConfiguration('action3name')); // à encoder car peut avoir des espaces ou des caractéres speciaux
      $action3 = $this->getConfiguration('action3');

      $other = rawurlencode($this->getConfiguration('other')); // à encoder car peut avoir des espaces ou des caractéres speciaux
      $other = str_replace("%26", "&", $other); // mais il faut sortir les & et = pour pouvoir les utiliser dans l'url
      $other = str_replace("%3D", "=", $other);

      // check if http or https
      if ($this->getConfiguration('https', 0) == 1) {
        $http_https = 'http://';
      } else {
        $http_https = 'https://';
      }

      // construction et retour de l'url selon l'api autoremote
      return $url = $http_https . AUTOREMOTEADDRNOTIF . '?key=' . trim($key) . '&text=' . $message . $other . '&title=' . $title . '&subtext=' . $subtext
              . '&sound=' . $sound . '&statusbaricon=' . $status_bar_icon . '&icon=' . $icon .'&picture=' . $picture
              . '&id=' . $notif_id . '&priority=' . $priority
              . '&url=' . $url_on_tap . '&action=' . $action_on_tap . '&message=' . $action_on_receive . '&actionondismiss=' . $action_on_dismiss
              . '&sender=' . $sender . '&password=' . $password . '&ttl=' .$ttl . '&collapseKey=' . $collapseKey
              . '&action1=' . $action1 . '&action1name=' . $action1name . '&action2=' . $action2 . '&action2name=' . $action2name . '&action3=' . $action3 . '&action3name=' . $action3name;

    }

    public function sendUrl($url) {
      // s'il y a des problèmes d'executions avec plusieurs recepteurs, voir pour charger le code avec curl-multi-exec
      // https://www.php.net/manual/fr/function.curl-multi-exec.php

      log::add('TaskerAutoRemote','debug',print_r('Url à envoyer: '. $url ,true));

      // create curl resource
      $ch = curl_init();

      // set url
      curl_setopt($ch, CURLOPT_URL, $url);

      //return the transfer as a string
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      // $output contains the output string
      $output = curl_exec($ch);
      log::add('TaskerAutoRemote','debug',print_r('Réponse execution: '. $output ,true));

      if ($output != 'OK') { // si le retour est pas ok, on log une erreur, ce qui va aussi generer un message
        log::add('TaskerAutoRemote','error',print_r('Erreur execution: '. $output ,true));
      }

      // close curl resource to free up system resources
      curl_close($ch);

    }

  /*     * *********************Méthodes d'instance************************* */

  /*
  // preInsert ⇒ Méthode appellée avant la création de votre objet
  public function preInsert() {

  }
  */
  // postInsert ⇒ Méthode appellée après la création de votre objet
  public function postInsert() {
  // ici on va créer les 2 commandes

    $notification = $this->getCmd(null, 'notification');

    if (!is_object($notification)) {
			$notification = new TaskerAutoRemoteCmd();
		}
		$notification->setLogicalId('notification');
		$notification->setIsVisible(1);
		$notification->setName(__('Envoyer notification', __FILE__));
		$notification->setType('action');
		$notification->setSubType('message');
    // $notification->setDisplay('message_placeholder', __('Texte', __FILE__));
		$notification->setEventOnly(1);
		$notification->setEqLogic_id($this->getId());
		$notification->save();

    $message = $this->getCmd(null, 'message');
		if (!is_object($message)) {
			$message = new TaskerAutoRemoteCmd();
		}
		$message->setLogicalId('message');
		$message->setIsVisible(1);
		$message->setName(__('Envoyer message', __FILE__));
		$message->setType('action');
		$message->setSubType('message');
    $message->setDisplay('title_disable', 1);
    $message->setDisplay('message_placeholder', __('Message', __FILE__));
		$message->setEventOnly(1);
		$message->setEqLogic_id($this->getId());
		$message->save();

  }

  /*
  // preSave ⇒ Méthode appellée avant la sauvegarde (creation et mise à jour donc) de votre objet
  public function preSave() {

  }
  */

  // postSave ⇒ Méthode appellée après la sauvegarde de votre objet
  public function postSave() {

  }

  // preUpdate ⇒ Méthode appellée avant la mise à jour de votre objet
  // ici on vérifie la présence de nos champs de config obligatoire
  public function preUpdate() {

      if ($this->getConfiguration('key') == '') {
          throw new Exception(__('Le champs clé du récepteur 1 ne peut être vide',__FILE__));
      }

  }

  /*
  // postUpdate ⇒ Méthode appellée après la mise à jour de votre objet
  public function postUpdate() {

  }

  // preRemove ⇒ Méthode appellée avant la supression de votre objet
  public function preRemove() {

  }

  // postRemove ⇒ Méthode appellée après la supression de votre objet
  public function postRemove() {

  }
  */

  /*
   * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
    public function toHtml($_version = 'dashboard') {

    }
   */

  /*
   * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
  public static function postConfig_<Variable>() {
  }
   */

  /*
   * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
  public static function preConfig_<Variable>() {
  }
   */

  /*     * **********************Getteur Setteur*************************** */

}

class TaskerAutoRemoteCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

    public function execute($_options = null) {

        $autoremote = $this->getEqLogic();
        $cmd_logical = $this->getLogicalId();

        $key = $autoremote->getConfiguration('key');
        $key2 = $autoremote->getConfiguration('key2');
        $key3 = $autoremote->getConfiguration('key3');

        $message = rawurlencode($_options['message']);
        $message = str_replace("%26", "&", $message);
        $message = str_replace("%3D", "=", $message);
        $message = str_replace("&apos", "'", $message); // va laisser un ; mais c'est le moins pire que j'ai trouvé... sinon ca tronque le msg !

        if( $cmd_logical == 'message'){

          // message ne peut pas etre vide, sinon exception autoremote. (pas de probleme pour notification)
          if ($message == '') {
            $message = "-";
          }

          log::add('TaskerAutoRemote','debug',print_r('Envoi du message au recepteur 1 : '.$_options['message'],true));

          $url = $autoremote->buildMessageUrl($key, $message);
          $autoremote->sendUrl($url);

          // si un second recepteur est configuré
          if ($key2 != '') {

            log::add('TaskerAutoRemote','debug',print_r('Envoi du message au recepteur 2 : '.$_options['message'],true));

            $url = $autoremote->buildMessageUrl($key2, $message);
            $autoremote->sendUrl($url);
          }

          // si un troisieme recepteur est configuré
          if ($key3 != '') {

            log::add('TaskerAutoRemote','debug',print_r('Envoi du message au recepteur 3 : '.$_options['message'],true));

            $url = $autoremote->buildMessageUrl($key3, $message);
            $autoremote->sendUrl($url);
          }

        }else{

            $title = rawurlencode($_options['title']);
            $title = str_replace("%26", "&", $title);
            $title = str_replace("%3D", "=", $title);
            $title = str_replace("&apos", "'", $title); // va laisser un ; mais c'est le moins pire que j'ai trouvé... sinon ca tronque le msg !


            log::add('TaskerAutoRemote','debug',print_r('Envoi de la notification au recepteur 1 : '. $_options['title']. ' - ' . $_options['message'] ,true));

            $url = $autoremote->buildNotificationUrl($key, $title, $message);
            $autoremote->sendUrl($url);

            // si un second recepteur est configuré
            if ($key2 != '') {

            log::add('TaskerAutoRemote','debug',print_r('Envoi de la notification au recepteur 2 : '. $_options['title']. ' - ' . $_options['message'] ,true));

            $url = $autoremote->buildNotificationUrl($key2, $title, $message);
            $autoremote->sendUrl($url);

            }

            // si un troisieme recepteur est configuré
            if ($key3 != '') {

            log::add('TaskerAutoRemote','debug',print_r('Envoi de la notification au recepteur 3 : '. $_options['title']. ' - ' . $_options['message'] ,true));

            $url = $autoremote->buildNotificationUrl($key3, $title, $message);
            $autoremote->sendUrl($url);

            }

        }
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>
