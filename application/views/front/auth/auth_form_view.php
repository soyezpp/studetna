<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-lg-4 col-sm-12 col-xs-12">   
            <h1 class="text-center"> Identification </h1> 

            <?php echo form_open(current_url(), array("class" => "form")); ?>

            <?php echo validation_errors(); ?>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <?php echo $this->session->flashdata('message'); ?>

            <div class="form-group">
                <label for="email">Identifiant :</label>
                <input class="form-control" type="text" name="mail" id="mail" value="" placeholder="Votre email ici...">            
            </div>
            <div class="form-group">           
                <label for="mdp">Mot de passe :</label>
                <input class="form-control" type="password" name="mdp" id="mdp" value="" placeholder="Votre mot de passe ici...">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Connexion</button>
            </div>
            <div class="form-group">
                <a href="<?= site_url("auth/get_new_password") ?>">Mot de passe oublié ?</a>
            </div>
        </div>    
        <?php echo form_close(); ?>
    </div>       
</div>           
