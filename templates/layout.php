<?php $active_page = include 'templates/helpers/active_page.php'; ?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title><?php echo APPLICATION_NAME; ?> - <?php echo CONGREGATION_NAME; ?></title>
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
                    <h1 id="site-name"><?php echo APPLICATION_NAME; ?> <span><?php echo CONGREGATION_NAME; ?></span></h1>
                </div>
            </div>
        </header>
        <nav id="nav-main">
            <div class="wrapper-center">
                <ul>
                    <?php if(!empty($_SESSION)) : ?>
                    <?php foreach ($placeholder['shift_types'] as $shift_type): ?>
                        <?php $shift_class = ($_SERVER['REQUEST_URI'] == '/shift.php?id_shift_type=' . $shift_type['id_shift_type'])? 'active':'';?>
                        <li>
                            <a href="shift.php?id_shift_type=<?php echo $shift_type['id_shift_type'];?>" class="<?php echo $shift_class;?>">
                                <i class="fa fa-calendar"></i> <?php echo $shift_type['name'];?>
                            </a>
                        </li>
                    <?php endforeach;?>
                    <li>
                        <a href="report.php" class="<?php echo $active_page('report.php', 'report-submit.php');?>">
                            <i class="fa fa-list-alt"></i> Bericht
                        </a>
                    </li>
                    <li>
                        <a href="info.php" class="<?php echo $active_page('info.php', 'info-add.php', 'info-edit.php');?>">
                            <i class="fa fa-info"></i> Info
                        </a>
                    </li>
                    <li>
                        <a href="profile.php" class="<?php echo $active_page('profile.php', 'profile-password.php');?>">
                            <i class="fa fa-user"></i> Profil
                        </a>
                    </li>
                    <?php if($_SESSION['is_admin']) : ?>
                    <li>
                        <a href="shifttype.php" class="<?php echo $active_page('shifttype.php', 'shifttype-add.php', 'shifttype-edit.php');?>">
                            <i class="fa fa-calendar"></i> Schichtart</a>
                    </li>
                    <li>
                        <a href="user.php" class="<?php echo $active_page('user.php', 'user-add.php', 'user-edit.php', 'user-add-mail.php');?>">
                            <i class="fa fa-users"></i> Teilnehmer
                        </a>
                    </li>
                    <li>
                        <a href="email.php" class="<?php echo $active_page('email.php', 'email-settings.php', 'email-templates.php');?>">
                            <i class="fa fa-envelope-o"></i> E-Mail
                        </a>
                    </li>
                    <li>
                        <a href="history-shift.php" class="<?php echo $active_page('history-login.php', 'history-shift.php', 'history-system.php');?>">
                            <i class="fa fa-history"></i> Verlauf
                        </a>
                    </li>
                    <?php endif;?>
                    <li id="logout">
                        <a href="./?logout">
                            <i class="fa fa-sign-out"></i> Abmelden
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </nav>
        <div class="wrapper-center">
            <main>
                <?php echo $placeholder['template']; ?>
            </main>
            <footer>
                <nav>
                    <ul id="nav-footer">
                        <li><a href="licence.php">Licence</a></li>
                        <li><a href="https://github.com/schillermann/trolleydienst-php" target="_blank" id="link-github">GitHub</a></li>
                        <li><a href="https://github.com/schillermann/trolleydienst-php/issues" target="_blank">Issues</a></li>
                        <?php if(!empty($_SESSION)):?><li>Version <?php echo include 'includes/get_version.php';?></li><?php endif;?>
                    </ul>
                </nav>
            </footer>
        </div>
        <script type="text/javascript" src="js/note_box.js"></script>
    </body>
</html>