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
      <li role="presentation"><a href="#msgoptiontab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-envelope"></i> {{Options des messages}}</a></li>
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
						<div class="form-group">
							<label class="col-sm-3 control-label">{{Clé AutoRemote}}</label>
							<div class="col-sm-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="key" placeholder="{{Clé api d'AutoRemote}}" />
							</div>
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
        <p>{{Tous les paramétres ci-dessous sont optionnels}}</p>
        <form class="form-horizontal">
          <legend>Option</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Cible (optionnel)}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="target" />
            </div>
            <span class="descpapp">{{Permet au receveur de filtrer les messages selon la cible sans avoir besoin d'analyser le message en lui-même.}}</span>
          </div>
        </form>
      </div>

      <div role="tabpanel" class="tab-pane" id="notifoptiontab">
        </br>
        <p>{{Tous les paramétres ci-dessous sont optionnels}}</p>

        <form class="form-horizontal">
          <legend>Apparence</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Son de notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="sound" />
            </div>
            <span class="descpapp">{{Value of 1 to 10. One of the 10 notification sounds chosen in AutoRemote's settings.}}</span>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Icone de la notification}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="status_bar_icon" />
            </div>
            <span class="descpapp">{{Status Bar Icon - In the Android app, go to the AutoRemote Notification action in Tasker and click the Status Bar Icon field. There you can see the possible values for this field.}}</span>
          </div>
          <legend>Action on tap</legend>
          <p>{{Choisir l'un ou l'autre, "Action" sera prioritaire}}</p>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{URL on tap}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="url_on_tap" />
            </div>
            <span class="descpapp">{{This Url will be opened when you touch the Notification body. The "Action" field will override this. Do not forget the "http://"}}</span>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action on tap}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action_on_tap" />
            </div>
            <span class="descpapp">{{AutoRemote action (can be in the param1 param2=:=command format) that will be executed on Notification touch}}</span>
          </div>
          <legend>Action à la reception</legend>
          <div class="form-group">
            <label class="col-sm-3 control-label">{{Action on receive}}</label>
            <div class="col-sm-3">
              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="action_on_receive" />
            </div>
            <span class="descpapp">{{AutoRemote action (can be in the param1 param2=:=command format) that will automatically execute when receiving this notification}}</span>
          </div>
        </form>
      </div>

    </div>

  </div>

</div>

<?php include_file('desktop', 'AutoRemote', 'js', 'AutoRemote'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
