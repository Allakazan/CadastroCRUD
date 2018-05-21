<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert">
        <?=$error?>
        <button type="button" class="close" onclick="this.parentElement.remove();">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endforeach; ?>