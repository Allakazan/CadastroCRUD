<script src="../../public/js/validate.js"></script>

<form class="form-horizontal" action='/?action=<?php echo $action[0] == 'edit'?'update':'insert';?>' method="POST" onsubmit="return validateUserForm();">
    <fieldset>
        <div id="legend">
            <legend class=""><?php echo $action[0] == 'edit'?'Editar':'Cadastrar';?></legend>
        </div>
        <input type="text" id="id" name="id" hidden value="<?php echo $action[0] == 'edit' ? $userData['id'] : '';?>">
        <div class="control-group">
            <label class="control-label"  for="name">Nome</label>
            <div class="controls">
                <input type="text" id="name" name="name" placeholder="" class="input-xlarge"
                       pattern=".{3,50}" required title="Nome deve ter no minimo 3 caracteres, e no maximo 50"
                       value="<?php echo $action[0] == 'edit' ? $userData['name'] : '';?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="lastName">Sobrenome</label>
            <div class="controls">
                <input type="text" id="lastName" name="lastName" placeholder="" class="input-xlarge"
                       pattern=".{3,100}" required title="Sobrenome deve ter no minimo 3 caracteres, e no maximo 100"
                       value="<?php echo $action[0] == 'edit' ? $userData['lastName'] : '';?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="userGroups">Grupos</label>
            <div id="userGroups" class="controls">
                <?php foreach ($allGroupsChecked as $keyGroupChecked => $groupChecked) : ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="groups[]" value="<?=$keyGroupChecked?>" <?php echo $groupChecked['checked'] ? 'checked' : ''?> >
                            <?=$groupChecked['label']?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="control-group">
            <!-- Button -->
            <div class="controls">
                <a class="btn btn-danger" href="/?action=list">Voltar</a>
                <button class="btn btn-success" type="submit">Salvar</button>
            </div>
        </div>
    </fieldset>
</form>
