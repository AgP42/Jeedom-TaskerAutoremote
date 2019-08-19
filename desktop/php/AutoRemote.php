<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$plugin = plugin::byId('AutoRemote');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">

	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoPrimary" data-action="add">
				<i class="fas fa-plus-circle"></i>
				<br>
				<span>{{Ajouter}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
				<i class="fas fa-wrench"></i>
				<br>
				<span>{{Configuration}}</span>
			</div>
		</div>

		<legend><i class="fas fa-table"></i> {{Mes clients AutoRemote}}</legend>
		<input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />
		<div class="eqLogicThumbnailContainer">
			<?php
		foreach ($eqLogics as $eqLogic) {
			$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
			echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
			echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
			echo '<br>';
			echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
			echo '</div>';
		}
		?>
		</div>
	</div>

  <div class="col-xs-12 eqLogic" style="display: none;">

		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
			<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>

		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
      <li role="presentation"><a href="#msgoptiontab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-cog"></i> {{Options}}</a></li>
      <li role="presentation"><a href="#notifoptiontab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-comment"></i> {{Options des notifications}}</a></li>
		</ul>

		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
			  <br/>
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Nom de l'équipement AutoRemote}}</label>
							<div class="col-sm-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement AutoRemote}}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" >{{Objet parent}}</label>
							<div class="col-sm-3">
								<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
									<option value="">{{Aucun}}</option>
									<?php
			foreach (jeeObject::all() as $object) {
				echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
			}
			?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Catégorie}}</label>
							<div class="col-sm-9">
							<?php
								foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
								echo '<label class="checkbox-inline">';
								echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
								echo '</label>';
								}
							?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
							</div>
						</div>
          </fieldset>
        </form>
        <br>
        <form class="form-horizontal">
          <fieldset>
            <legend>Clés API des équipements récepteurs</legend>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Récepteur 1}}</label>
							<div class="col-sm-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="key" placeholder="{{Clé api d'AutoRemote}}" />
							</div>
              <div class="col-sm-3">{{<strong>Obligatoire</strong>}}</div>
						</div>

            <div class="form-group">
              <label class="col-sm-3 control-label">{{Récepteur 2}}</label>
              <div class="col-sm-3">
                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="key2" placeholder="{{Clé api d'AutoRemote}}" />
              </div>
              <div class="col-sm-3">{{<em>Optionnel</em>}}</div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">{{Récepteur 3}}</label>
              <div class="col-sm-3">
                <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="key3" placeholder="{{Clé api d'AutoRemote}}" />
              </div>
              <div class="col-sm-3">{{<em>Optionnel</em>}}</div>
            </div>

					</fieldset>
				</form>
			</div>


			<div role="tabpanel" class="tab-pane" id="commandtab">
        </br>
				<!--a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Commandes}}</a><br/><br/-->
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Nom}}</th><th>{{Action}}</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>

      <div role="tabpanel" class="tab-pane" id="msgoptiontab">
        </br>
        <p>{{Tous les paramètres ci-dessous sont optionnels, si définis ils seront les valeurs par défaut pour <strong>Envoyer un message</strong> et <strong>Envoyer une notification</strong>. </br></br> Pour <em>écraser</em> ces valeurs par défaut pour une commande spécifique, utiliser la notation donnée dans "Ce champ correspond à" dans le message de la commande. <br>
        Voir la documentation pour un exemple.}}</p>
        <form class="form-horizontal">
          <legend>Options</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Cible (messages seulement)}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="target" />
            </div>
            <div class="col-sm-3">{{Permet au receveur de filtrer les messages selon la cible sans avoir besoin d'analyser le message en lui-même. Ce champ ne défini pas le destinataire du message (défini par l'API key)}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&target=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Emetteur}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="sender" />
            </div>
            <div class="col-sm-3">{{Permet de déclarer l'origine du message}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&sender=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Mot de passe}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="password" />
            </div>
            <div class="col-sm-3">{{Permet d'utiliser le mot de passe définis dans l'appli android. Attention, il est envoyé en clair dans la requête http et visible dans les logs.}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&password=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Durée de validité (en s)}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ttl" />
            </div>
            <div class="col-sm-3">{{Durée en secondes avant que le message soit considéré obsolète. Au bout de cette durée, si le message n'a pas été remis il est abandonné. Par défaut : 0 = illimité}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&ttl=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Groupe de message}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="collapseKey" />
            </div>
            <div class="col-sm-3">{{Si le destinataire n'est pas joignable pendant une certaine durée, seul le dernier message appartenant à ce "groupe" sera transmis à la reconnexion du destinataire.}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&collapseKey=</strong>}}</div>
          </div>
        </form>
      </div>

      <div role="tabpanel" class="tab-pane" id="notifoptiontab">
        </br>
        <p>{{Tous les paramètres ci-dessous sont optionnels, si définis ils seront les valeurs par défaut pour la commande <strong>Envoyer une notification</strong>. </br></br> Pour <em>écraser</em> ces valeurs par défaut pour une commande spécifique, utiliser la notation donnée dans "Ce champ correspond à" dans le message de la commande. <br> Voir la documentation pour un exemple.}}</p>

        <form class="form-horizontal">

          <legend>Apparence</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Son de notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="sound" />
            </div>
            <div class="col-sm-3">{{Valeur de 1 à 10. Correspond à l'un des 10 sons de notification choisis dans l'application Android.}}
            </div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&sound=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Icone de la barre de notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="status_bar_icon" />
            </div>
            <div class="col-sm-3">{{Dans Tasker, allez dans l'action "AutoRemote Notification" et cliquez sur le champ "Status Bar Icon". Vous y trouverez les valeurs possibles pour cette zone. Ex: "eye" ou "edit"}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&statusbaricon=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{URL icone dans la notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="icon" />
            </div>
            <div class="col-sm-3">{{URL d'une image qui sera affichée en icone dans le corps de la notification}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&icon=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{URL image dans la notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="picture" />
            </div>
            <div class="col-sm-3">{{URL d'une image qui sera affichée en déployant la notification, par exemple l'image d'une camera}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&picture=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Sous-texte}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="subtext" />
            </div>
            <div class="col-sm-3">{{Ligne de texte supplémentaire qui s'affiche dans le titre une fois la notification dépliée}}
            </div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&subtext=</strong>}}</div>
          </div>

          <legend>Actions</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{URL au clic}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="url_on_tap" />
            </div>
            <div class="col-sm-3">{{URL à ouvrir au clique sur la notification. Ce champ n'est pas pris en compte si "Action au clic" si-dessous est rempli. Ne pas oublier le "http://"}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&url=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action au clic}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action_on_tap" />
            </div>
            <div class="col-sm-3">{{Action AutoRemote (nécessite Tasker) à executer au clique sur la notification. Voir la documentation pour un exemple.}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action à la réception}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action_on_receive" />
            </div>
            <div class="col-sm-3">{{Action AutoRemote (nécessite Tasker) à executer dès la reception de la notification.}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&message=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action à la suppression}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action_on_dismiss" />
            </div>
            <div class="col-sm-3">{{Action AutoRemote (nécessite Tasker) à executer lors de la suppression de la notification.}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&actionondismiss=</strong>}}</div>
          </div>

          <legend>Boutons actions</legend>
          <p>Bouton N°1 :</p>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Nom du bouton}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action1name" />
            </div>
            <div class="col-sm-3">{{Action AutoRemote (nécessite Tasker) à executer au clique sur la notification. Voir la documentation pour un exemple.}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action1name=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action associée}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action1" />
            </div>
            <div class="col-sm-3">{{Action AutoRemote (nécessite Tasker) à executer au clique sur ce bouton."}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action1=</strong>}}</div>
          </div>
          <p>Bouton N°2 :</p>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Nom du bouton}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action2name" />
            </div>
            <div class="col-sm-3">{{}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action2name=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action associée}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action2" />
            </div>
            <div class="col-sm-3">{{}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action2=</strong>}}</div>
          </div>
          <p>Bouton N°3 :</p>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Nom du bouton}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action3name" />
            </div>
            <div class="col-sm-3">{{}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action3name=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action associée}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action3" />
            </div>
            <div class="col-sm-3">{{}}</div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&action3=</strong>}}</div>
          </div>

          <legend>Configuration</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Priorité}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="priority" />
            </div>
            <div class="col-sm-3">{{Values ranging from -2 (min priority) to 2 (max priority)}}
            </div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&priority=</strong>}}</div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ID de la notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="notif_id" />
            </div>
            <div class="col-sm-3">{{Notifications with different ids will not overlap eachother}}
            </div>
            <div class="col-sm-3">{{Ce champ correspond à <strong>&id=</strong>}}</div>
          </div>

          <legend>Autres</legend>
<!--             <div>
              <p>
                Options offertes par AutoRemote et non détaillées ci-dessus : <br>
              </p>
            </div> -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Autres paramètres par défaut}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="other" />
            </div>
            <div class="col-sm-3">{{Utiliser ce champ pour écrire du code brut des options AutoRemote à utiliser pour toutes les notifications}}</div>
            <div class="col-sm-3">{{par exemple "&dismissontouch=o&led=green"}}</div>
          </div>

        </form>
      </div>

    </div>

  </div>

</div>

<?php include_file('desktop', 'AutoRemote', 'js', 'AutoRemote'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
