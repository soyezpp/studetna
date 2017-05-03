<?php echo form_open(current_url(), array("class" => "form")); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $title ?></h1>
            <?php echo validation_errors(); ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">E-mail :</label>
                        <input class="form-control" type="text" name="mail" id="mail" value="<?= set_value('mail'); ?> <?= (isset($admin) ? $admin->mail : '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input class="form-control" type="password" name="mdp" id="mdp" value="" <?php if (isset($admin->mdp)) echo 'placeholder="Laisser vide pour ne pas le modifier"'; ?> >
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <a href="<?= site_url("/admin/listing") ?>" class="btn btn-warning">Retour</a>
                    <?php if (isset($admin)) : ?>
                        <a href="<?= site_url("admin/del/".$admin->id) ?>" class="btn btn-danger del_confirm">Supprimer</a>
                    <?php endif; ?>
                </div>
            </div> 
        </div>
    </div>
</div>
<?php echo form_close(); ?>
