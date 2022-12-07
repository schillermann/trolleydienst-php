<?php
$active_page = include '../templates/helpers/active_page.php';
?>
<!DOCTYPE html>
<html lang="<?= include('../helpers/get_language.php') ?>">

<head>
    <meta charset="utf-8">
    <title><?= APPLICATION_NAME ?> - <?= CONGREGATION_NAME ?></title>
    <meta name="description" content="Trolleydienst Verwaltung">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/global.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="144x144" href="images/apple-touch-icon-ipad-retina.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="images/apple-touch-icon-iphone.png" />
</head>

<body>
    <div id="loading-screen" class="fade-in">
        <div id="loading-screen-center">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <header>
        <div>
            <div class="wrapper-center">
                <a href="/" id="logo"><img src="images/logo-trolleydienst.png"></a>
            </div>
        </div>
        <div>
            <div id="site-header" class="wrapper-center">
                <h1 id="site-name"><?= APPLICATION_NAME ?> <span><?= CONGREGATION_NAME ?></span></h1>
                <?php if (!empty($_SESSION)) : ?>
                    <div class="menu-button" onclick="toggel()">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </header>
    <nav id="nav-main" class="hidden">
        <div class="wrapper-center">
            <ul>
                <?php if (!empty($_SESSION)) : ?>
                    <?php foreach ($placeholder['shift_types'] as $shift_type) : ?>
                        <?php $shift_class = ($_SERVER['REQUEST_URI'] == '/shift?id_shift_type=' . $shift_type['id_shift_type']) ? 'active' : ''; ?>
                        <li>
                            <a href="shift?id_shift_type=<?= $shift_type['id_shift_type']; ?>" class="<?= $shift_class; ?>">
                                <i class="fa fa-calendar"></i> <?= $shift_type['name']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <a href="report" class="<?= $active_page('report', 'submit-report'); ?>">
                            <i class="fa fa-list-alt"></i> <?= __('Report') ?>
                        </a>
                    </li>
                    <li>
                        <a href="info" class="<?= $active_page('info', 'upload-file', 'edit-file'); ?>">
                            <i class="fa fa-info"></i> <?= __('Info') ?>
                        </a>
                    </li>
                    <li>
                        <a href="publisher-profile" class="<?= $active_page('publisher-profile', 'change-publisher-password'); ?>">
                            <i class="fa fa-user"></i> <?= __('Profile') ?>
                        </a>
                    </li>
                    <?php if ($_SESSION['is_admin']) : ?>
                        <li>
                            <a href="shift-type" class="<?= $active_page('shift-type', 'add-shift-type', 'adjust-shift-type'); ?>">
                                <i class="fa fa-calendar"></i> <?= __('Shift Type') ?>
                            </a>
                        </li>
                        <li>
                            <a href="publishers" class="<?= $active_page('publishers', 'add-publisher', 'adjust-publisher'); ?>">
                                <i class="fa fa-users"></i> <?= __('Publisher') ?>
                            </a>
                        </li>
                        <li>
                            <a href="newsletter" class="<?= $active_page('newsletter', 'email-settings', 'email-templates'); ?>">
                                <i class="fa fa-envelope-o"></i> <?= __('Newsletter') ?>
                            </a>
                        </li>
                        <li>
                            <a href="shift-history" class="<?= $active_page('login-history', 'shift-history', 'system-history'); ?>">
                                <i class="fa fa-history"></i> <?= __('History') ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li id="logout">
                        <a href="./?logout">
                            <i class="fa fa-sign-out"></i> <?= __('Logout') ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="wrapper-center">
        <main>
            <?= $placeholder['template'] ?>
        </main>
        <footer>
            <nav>
                <ul id="nav-footer">
                    <li><a href="https://github.com/schillermann/trolleydienst-php" target="_blank" id="link-github">GitHub</a></li>
                    <li><a href="https://github.com/schillermann/trolleydienst-php/issues" target="_blank"><?= __('Issues') ?></a></li>
                    <?php if (!empty($_SESSION)) : ?><li><?= __('Version') ?> <?= include '../includes/get_version.php'; ?></li><?php endif; ?>
                </ul>
            </nav>
        </footer>
    </div>
    <script type="text/javascript" src="js/note_box.js"></script>
</body>
<script type="text/javascript">
    function toggel() {
        document.getElementById('nav-main').classList.toggle('hidden');
    }
</script>

</html>