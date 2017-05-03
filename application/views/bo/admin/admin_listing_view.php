<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $title ?></h1>
            <?= isset($errors) ? $errors : "" ?>
            <p class="text-right"><a href="<?= site_url("admin/add") ?>" class="btn btn-info">Ajouter un administrateur</a></p>

            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_admin as $admin) : ?>
                        <tr>
                            <td class="mail"><?= $admin->mail ?></td>
                            <td>
                                <a href="<?= site_url("admin/edit/".$admin->id) ?>" class="btn btn-default btn-xs">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>