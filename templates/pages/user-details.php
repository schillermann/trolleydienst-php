<header>
    <h2><?= __('Publisher Contact Details') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./shift.php?id_shift_type=<?= (int)$_GET['id_shift_type'];?>" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <fieldset>
        <legend><?= $placeholder['user']['first_name'] . " " . $placeholder['user']['last_name'] ?></legend>
        <dl>
            <dt><?= __('Email') ?></dt>
                <dd><a href="mailto:<?= $placeholder['user']['email'];?>?subject=Trolleydienst"><?= $placeholder['user']['email'] ?></a></dd>
            <dt><?= __('Mobile Number') ?></dt>
            <?php if(empty($placeholder['user']['mobile'])): ?>
                <dd><?= __('N/A') ?></dd>
            <?php else: ?>
                <dd><a href="tel:<?= $placeholder['user']['mobile'] ?>"><?= $placeholder['user']['mobile'] ?></a></dd>
            <?php endif;?>
            <dt><?= __('Phone Number') ?></dt>
            <?php if(empty($placeholder['user']['phone'])): ?>
                <dd><?= __('N/A') ?></dd>
            <?php else: ?>
                <dd><a href="tel:<?= $placeholder['user']['phone'] ?>"><?= $placeholder['user']['phone'] ?></a></dd>
            <?php endif;?>
            <dt><?= __('Congregation') ?></dt>
            <?php if(empty($placeholder['user']['congregation_name'])): ?>
                <dd><?= __('N/A') ?></dd>
            <?php else : ?>
                <dd><?= $placeholder['user']['congregation_name'] ?></dd>
            <?php endif ?>
            <dt><?= __('Language') ?></dt>
            <?php if(empty($placeholder['user']['language'])): ?>
                <dd><?= __('N/A') ?></dd>
            <?php else : ?>
                <dd><?= $placeholder['user']['language'] ?></dd>
            <?php endif ?>
        </dl>
    </fieldset>
</div>