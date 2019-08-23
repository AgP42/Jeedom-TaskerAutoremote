Présentation et principe de fonctionnement
==========================================

Ce plugin vous permet de communiquer avec votre téléphone Android (ou autre équipement compatible) via le service AutoRemote.

Vous pourrez ainsi envoyer des messages et les utiliser pour déclencher des actions sur votre équipement distant, grâce à Tasker,  ou vous pourrez directement envoyer une notification complètement personnalisée incluant des boutons d'actions.

Pour plus d'information à propos d'AutoRemote : <a href="http://joaoapps.com/autoremote/what-it-is/" target="_blank">AutoRemote</a>, et de Tasker : <a href="https://tasker.joaoapps.com/" target="_blank">Tasker</a>

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Notif_1.jpg)
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Notif_2.jpg)

Le principe de fonctionnement du plugin est le suivant : 

- Chaque client contient les commandes "Envoyer un message" et "Envoyer une notification" avec des options spécifiques. 
- Chaque client peut adresser ces messages à jusqu'à 3 destinataires pour chaque commande.
- Les options peuvent être considerées comme des "valeurs par défaut", permettant de ne pas devoir les redéfinir à chaque fois qu'on utilise la commande (message ou notification) de ce client. 
- A chaque utilisation d'une commande, il est possible "d'écraser" les valeurs par défaut en utilisant la synthaxe d'AutoRemote directement dans le champ "message" (voir les exemples à la fin)
- Il est évidemment possible de définir une multitude de clients, chacun pouvant utiliser la même clef API pour envoyer des messages aux mêmes destinaires, mais avec des options pré-définies différentes.

Dans les messages et dans les notifications, il est possible de définir des actions à "écouter" par Tasker pour générer des actions en retour, par exemple effacer les messages du centre de messages Jeedom.


Installation du plugin via Github
=================================

1. Télécharger le zip contenant les sources sur github : <a href="https://github.com/AgP42/Jeedom-TaskerAutoremote/archive/master.zip" target="_blank">https://github.com/AgP42/Jeedom-TaskerAutoremote/archive/master.zip</a> 
2. Il faut ensuite créer un dossier "TaskerAutoRemote" (les majuscules sont importantes) dans le dossier plugin de votre Jeedom, pour celà plusieurs possibilités : 
   - En FTP ou SSH, le dossier plugin se trouve dans /var/www/html/plugins (sur un RPI en tout cas...)
   - En utilisant le plugin "JeeXplorer" téléchargeable sur le market Jeedom, puis naviguer dans "plugin", créer le dossier et copier/coller les sources (dézippées)
3. Dans Jeedom, aller dans "plugin"/"gestion des plugins", trouver TaskerAutoremote et activez le

Configuration du plugin
========================

Après téléchargement du plugin, il vous faut l’activer, celui-ci ne nécessite aucune autre configuration.

Configuration des équipements (clients AutoRemote)
=================================================

Une fois le plugin activé, il est visible dans le menu "plugin"/"communication".

Vous pouvez alors définir plusieurs "clients Autoremote".

Chaque client doit avoir au moins une clef API définie, permettant de cibler l'appareil de réception. Il est possible de définir jusqu'à 3 appareils de destination pour une même commande.

Chaque client contient aussi ses options pour "Envoyer un message" ou "Envoyer une notification" qui sont propre à chacun.


Onglet Equipement
-----------------

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Equipement.png)

Pour trouver la clef API il vous suffit de naviguer vers l'URL donné par AutoRemote sur votre équipement Android.

Il est possible d'utiliser la même clef sur plusieurs clients.

Par exemple vous pouvez définir un client vers votre téléphone avec les options "URL après un clic" pour ouvrir votre Jeedom au clique sur la notification reçue et un autre client vers le même téléphone avec l'option "Action après un clic" permettant de supprimer les messages de Jeedom (voir ci-dessous). A l'usage, choisissez le client dont les options correspondent à votre besoin.

Vous pouvez aussi définir plusieurs clients selon le son ou l'icône voulue sur la notification.

Onglet Commandes
-----------------
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Commandes.png)

Les commandes sont automatiquement créées à la sauvegarde de l'équipement.

Chaque équipement contient les 2 commandes suivantes :
- Envoyer message
- Envoyer notification

Il est possible de les renommer ou de les supprimer. Une fois supprimées elles ne peuvent pas être recréées. 

Il est possible de tester ces commandes avec le bouton "tester", attention, le retour de Jeedom concerne l'appel de l'exécution de la commande qui sera donc (quasi) toujours un succès. En cas d'erreur dans l'execution de la requête elle-même, un message sera donné dans les logs et dans les messages de Jeedom : 
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/erreur_clef.png)


Onglet Options
--------------

Il s'agit des options pour les 2 types de commandes, sauf pour le champ "cible".

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Opt_msg.png)

Onglet Options des notifications
--------------------------------
Il s'agit des options pour la commande "Envoyer une notification" uniquement.

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/opt_notif.png)

Exemple de rendu :
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Notif_app.jpg)

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/opt_notif_action.png)

Pour l'action Tasker, il s'agit en fait du champs "message" qui doit donc être "écouté" par Tasker pour lancer une action. Voir dans Tasker les événements "AutoRemote". (Voir exemple ci-dessous)

Si l'URL et Action sont remplies, "Action" sera prioritaire.
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/opt_notif_btn.png)

Il est possible d'ajouter jusqu'à 3 boutons d'actions dans le pied de la notification. Le champ "action associé" correspond à une action tasker, de même que les actions ci-dessus. 

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/opt_notif_config&autre.png)

Utilisez le champ "Autres" pour utiliser des options non détaillées ci-dessous. 
Liste des options AutoRemote disponibles et non détaillées dans le plugin (copier/coller de la doc AutoRemote) : 

- Dismiss On Touch - Fill any value to make the notification dismiss itself when touched - &dismissontouch=
- Vibration Pattern - Similar to Tasker's Vibration Pattern - &vibration=
- Led Color - Not supported on all devices. Supported formats are: #RRGGBB #AARRGGBB 'red', 'blue', 'green', 'black', 'white', 'gray', 'cyan', 'magenta', 'yellow', 'lightgray', 'darkgray'. - &led=
- Led On ms - Time in milliseconds the LED will be on during blinking - &ledon=
- Led Off ms - Time in milliseconds the LED will be off during blinking - &ledoff=
- Max Progress - Max value the progress can have - &maxprogress=
- Current Progress - Value from 0 to the value you set in Max Progress - &progess=
- Indeterminate Progress - If set, an indeterminate progress bar will be used - &indeterminateprogress=
- Ticker Text - Text to appear on the status bar when the notification is first created. Defaults to the text field above. - &ticker=
- Number - Number to appear on the lower right of the Notification - &number=
- Content Info - Small string to appear on the lower right of the Notification; overrides Number - &contentinfo=
- Share - Add Share button(s) on Jelly Bean Notifications. Input any value to show these buttons. Leave blank otherwise. - &share=
- Action Button Icon 1 (and 2 and 3) - In the Android app, go to the AutoRemote Notification action in Tasker and click the Button 1 Icon field. There you can see the possible values for this field. - &action1icon=
- Persistent - Fill in any value to make the notification persistent - &persistent=
- Cancel - Fill any value to cancel notification with the given Id. Must fill Id to cancel; All other settings besides Id will be ignored - &cancel=

Exemples d'utilisation
======================

Personaliser un champ pour une commande en particulier
------------------------------------------------------

Dans l'exemple ci-dessous, la seconde notification envoyé utilisera le son n°2, quelque soit le son par défaut défini dans les options du client "S7" :
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/exemple_overwrite.png)


Actualiser un widget Android à chaque changement d'état sur Jeedom ("Envoyer un message")
-------------------------------------------------------------------------------

1. Configurer un client AutoRemote avec la clef API de l'équipement de destination (aucune autre option nécessaire)
2. Créer un scénario Jeedom avec :
  - comme élément déclencheur le changement d'état que vous souhaitez recevoir
  - comme action la commande "Envoyer message" de votre client AutoRemote définie en 1.

Puis suivre le tuto suivant que j'avais rédigé il y a plusieurs années mais reste applicable : http://www.touteladomotique.com/index.php?option=com_content&view=article&id=1841:tuto-faire-des-widgets-avec-retour-detat-jeedom-zooper
(Zooper n'est plus disponible sur le Play Store mais son APK est facilement téléchargeable sur internet, testé ok sous Android 9)

Recevoir une notification à chaque message Jeedom ("Envoyer une notification")
-------------------------------------------------------------------------------

Les messages Jeedom avertissement des erreurs d'exécution ou de mises à jour disponibles.

1. Configurer un client AutoRemote avec la clef API de l'équipement de destination
2. Dans la configuration de Jeedom, onglet "logs" :
   - cocher "Ajouter un message à chaque erreur dans les logs",
   - puis "Action sur message : Ajouter"
   - dans le champ de l'action, sélectionner votre client AutoRemote et choisir "Envoyer une notification"
   - personnaliser votre message, par exemple : titre : "Maison - Message de #plugin#" et message : "#jour# #smois# #annee# - formatTime(#time#) : #message#"
   - sauvegarder

![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/message_logs.png)

Avec ceci vous recevrez une notification "standard" d'AutoRemote contenant uniquement le titre et le message. 

Personnalisons-la un peu ! :

3. Retourner dans le plugin AutoRemote, choisir le client précédemment créé puis aller dans l'onglet "Options des notifications" :
   - Choisir une nouvelle icône et le son voulu
   - "URL après un clic" : saisir l'URL de votre jeedom pour y accéder au clique sur la notification reçue

Et si je veux purger les messages jeedom en cliquant sur la notification ?

(bonus) Utiliser Tasker pour purger vos messages Jeedom
-------------------------------------------------------

Dans Jeedom :
1. Dans la configuration du plugin AutoRemote, dans le champ "Action après un clic", saisir "purgeMsg" (ou autre chose tant que ça reste cohérent par la suite). Remarque : idem avec "Action à la réception" si vous voulez que ca s'exécute à la réception de la notification et non pas au clique dessus.
2. Créer un scenario en mode provoqué. Ajouter un bloc de "code" dans lequel vous écrivez "message::removeAll();". Sauvegarder. Noter l'ID du scénario (dans le titre de l'onglet "Général")

Sur votre Android :
3. Aller dans Tasker et créer un nouveau "Profils", appelez-le comme vous voulez, choisir "Evenement" comme déclencheur puis "Plugin" puis "AutoRemote" et encore "AutoRemote". Dans "configuration" (cliquer sur le crayon) choisir "Message Filter" et saisir "purgeMsg". Puis retour jusqu'à ce que Tasker propose la tâche à assigner.
4. Choisir de créer une nouvelle tâche, la nommer comme vous voulez. Cliquer sur le + pour ajouter une action, filtrer avec "http" et choisir "HTTP Request". Remplir le champ "URL" avec la requête pour déclencher le scenario précédemment créé (requête GET), c'est à dire : "http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY#&type=scenario&id=#ID#&action=start". Remplacer #IP_JEEDOM#, #APIKEY# et #ID# par les valeurs correspondants à votre jeedom. #ID# est l'ID du scenario qui est donné dans le titre de l'onglet "Général" du scénario.
5. Eventuellement, ajouter un pop-up dans cette tâche pour avoir un retour comme quoi la commande est bien passée : "+" puis filtrer sur "flash" et saisir le text à afficher dans le pop-up : "Purge des messages Jeedom demandée" par exemple.

Testons tout ça :
- Créer un scénario générant un message (action/message puis saisir un message). Sauvegarder et exécuter le scénario.
- Vous devez recevoir sur votre téléphone une ou plusieurs notifications (une notification par nouveau message) avec le message de Jeedom
- Cliquez sur la notification : vous devez voir un pop-up indiquant "Purge des messages Jeedom demandée" et sur Jeedom, les messages sont vides.

Evidemment si vous purgez un message "redondant", il reviendra constamment...
