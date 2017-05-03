<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Accueil</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    </head>
    <body>
        <?php if ($this->authcheck->is_admin() == true) : ?>

            <nav class="navbar navbar-inverse navbar-default ">
                <div class="container">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#melosend-navbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>              
                        <a class="navbar-brand" href="<?= site_url() ?>">Melosend</a>
                    </div>

                    <div class="collapse navbar-collapse" id="melosend-navbar">
                        <ul class="nav navbar-nav">
                            <li<?= ($this->uri->segment(1) == "resident" ? ' class="active"' : '') ?>><a href="<?= site_url("resident/listing/ASC") ?>">Gestion des résidents</a></li>
                            <li<?= ($this->uri->segment(1) == "admin" ? ' class="active"' : '') ?>><a href="<?= site_url("admin/listing") ?>">Gestion des administrateurs</a></li>
                            <li<?= ($this->uri->segment(1) == "admin" ? ' class="active"' : '') ?>><a href="<?= site_url("reglages/edit") ?>">Réglages</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?= site_url("auth/logout") ?>">Se déconnecter</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

        <?php endif; ?>