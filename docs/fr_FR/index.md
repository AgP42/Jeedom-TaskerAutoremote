Présentation
============

Ce plugin vous permet de communiquer avec votre téléphone Android (ou autre équipement compatible) via le service AutoRemote.

Vous pourrez ainsi envoyer des messages et les utiliser pour déclencher des actions sur votre équipement distant (grâce à Tasker) ou vous pourrez directement envoyer une notification complètement personnalisée.

Pour plus d'information à propos d'AutoRemote : http://joaoapps.com/autoremote/what-it-is/

Configuration du plugin
========================

Après téléchargement du plugin, il vous faut l’activer, celui-ci ne nécessite aucune autre configuration.

Configuration des équipements (clients AutoRemote)
=================================================

Une fois le plugin activé, il est visible dans le menu "plugin"/"communication".

Vous pouvez alors définir plusieurs "clients Autoremote".

Chaque client doit avoir une clef API définie, permettant de cibler l'appareil de réception.

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

Il est possible de tester ces commandes avec le bouton "tester", attention, le retour de Jeedom sur cette page sera "OK{"state":"ok","result":""}" en rouge, ce qui peut laisser croire à une erreur. Vérifier sur votre Android de réception si le message ou la notification a bien été reçu.

Onglet Options des messages
--------------------------
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/Opt_msg.png)

Il s'agit des options pour la commande "Envoyer un message" uniquement.

Le champ "cible" permet de définir le champ "Target" d'AutoRemote qui permet au receveur de filtrer les messages selon la cible sans avoir besoin d'analyser le message en lui-même.

Onglet Options des notifications
--------------------------------
![](https://raw.githubusercontent.com/AgP42/Jeedom-AutoRemote/master/docs/assets/images/opt_notif.png)

Il s'agit des options pour la commande "Envoyer une notification" uniquement.

Apparence :
- Son de notification : Choisir entre 1 et 10. Permet de choisir un des 10 son définis au niveau de l'application AutoRemote
- Icone de la notification : Permet de choisir l'icône de notification qui sera affichée. Pour voir la liste des icônes disponibles et leur nom, aller dans Tasker, puis créer une tâche ayant en action "AutoRemote Notification", dans configuration, chercher le champ "Status Bar Icon". Par exemple :
   - "action_about_dark" : affiche un i dans un cercle
   - "action_settings" : affiche 3 sliders
   - "edit" : crayon
   - "eye" : un oeil
   - "ic_action_dialog" : logo "chat"

Action après un clic :

Il s'agit de choisir l'action qui sera réalisée lors de l'appui sur la notification reçue : ouvrir un url, ou lancer une action Tasker.

Pour l'action Tasker, il s'agit en fait du champs "message" qui doit donc être "écouté" par Tasker pour lancer une action. Voir dans Tasker les événements "AutoRemote". (Voir exemple ci-dessous)

Si l'URL et Action sont remplies, "Action" sera prioritaire.

Action à la réception :

Il s'agit d'une action Tasker qui sera exécutée dès la réception de la notification.
La configuration au niveau du récepteur est la même que pour "Action après un clic".

Exemples d'utilisation
======================

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
