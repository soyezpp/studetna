<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <h1><?php echo $title; ?></h1>
            <?php echo validation_errors(); ?>
            <?php echo form_open(current_url(), array("class" => "form")); ?>
            <div class="form-group">
                <label for="mail">E-mail :</label>
                <input class="form-control" type="text" name="email" id="email" value="<?php echo set_value('email'); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
            <a class="btn btn-default" href="<?= site_url("auth/login") ?>" >Retour</a>
            <?php echo form_close(); ?>

        </div>
    </div>
</div> 