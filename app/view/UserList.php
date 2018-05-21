<?php if (isset($message)): ?>
    <div class="alert alert-success" role="alert">
        <?=$message[0]?>
        <button type="button" class="close" onclick="this.parentElement.remove();">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<div class="col-md-6 col-md-offset-3">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Grupos</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $data) : ?>
        <tr>
            <td><?=$data['name']?></td>
            <td><?=$data['lastName']?></td>
            <td>
                <?php foreach ($data['groups'] as $group) : ?>
                    <span class="label label-primary"><?=$group?></span>
                <?php endforeach; ?>
            </td>
            <td>
                <a class="btn btn-xs btn-default" href="/?action=edit&id=<?=$data['id']?>"><span class="glyphicon glyphicon-pencil"></span></a>
                <a class="btn btn-xs btn-danger" href="/?action=remove&id=<?=$data['id']?>"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a class="btn btn-success pull-right" href="/?action=new"><span class="glyphicon glyphicon-plus"></span> Novo</a>
</div>