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
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link href="css/global.css" rel="stylesheet">
    <?php if (@$_SESSION['is_admin']) : ?>
        <link rel="stylesheet" href="css/coloris.min.css" />
        <script src="js/coloris.min.js"></script>
    <?php endif ?>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="144x144" href="images/apple-touch-icon-ipad-retina.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="images/apple-touch-icon-iphone.png" />
    <style>
        :root {
            /** color palette */
            --td-brand-purple-40: hsl(267, 25%, 40%);
            --td-brand-purple-70: hsl(267, 25%, 70%);

            --td-secondary-grey-94: hsl(0 0% 94%);
            --td-secondary-grey-90: hsl(0 0% 90%);
            --td-secondary-grey-70: hsl(0 0% 70%);
            --td-secondary-grey-35: hsl(0 0% 35%);
            --td-secondary-grey-20: hsl(0 0% 20%);
            --td-secondary-grey-16: hsl(0 0% 16%);
            --td-secondary-grey-7: hsl(0 0% 7%);
            --td-secondary-red: hsl(0 100% 40%);
            --td-secondary-green: hsl(80 100% 40%);
            --td-secondary-black: hsl(0, 0%, 0%);
            --td-secondary-white: hsl(0, 0%, 100%);

            /** scope */
            --td-font: Helvetica Light, Helvetica, Arial;
            --td-background-body-color: var(--td-secondary-grey-94);
            --td-background-content-color: var(--td-secondary-white);
            --td-background-content-accent-color: var(--td-secondary-grey-90);
            --td-text-default-color: var(--td-secondary-black);
            --td-text-accent-color: var(--td-brand-purple-40);
            --td-hover-brightness: 0.85;
            --td-border-radius: 5px;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --td-background-body-color: var(--td-secondary-black);
                --td-background-content-color: var(--td-secondary-grey-7);
                --td-background-content-accent-color: var(--td-secondary-grey-16);
                --td-text-default-color: var(--td-secondary-white);
                --td-text-accent-color: var(--td-brand-purple-70);
            }
        }

        body {
            font-family: var(--td-font);
            color: var(--td-text-default-color);
            background-color: var(--td-background-body-color);
        }

        main {
            background-color: var(--td-background-content-color);
        }
    </style>
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
                    <div class="menu-button" onclick="toggle()">
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
                    <?php if ($_SESSION['admin']) : ?>
                        <li>
                            <a href="shift-type" class="<?= $active_page('shift-type', 'add-shift-type', 'edit-shift-type'); ?>">
                                <i class="fa fa-calendar"></i> <?= __('Calendar Settings') ?>
                            </a>
                        </li>
                        <li>
                            <a href="publishers" class="<?= $active_page('publishers', 'add-publisher', 'edit-publisher'); ?>">
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
</body>
<script type="text/javascript">
    window.litDisableBundleWarning = true

    function toggle() {
        document.getElementById('nav-main').classList.toggle('hidden');
    }
</script>

</html>