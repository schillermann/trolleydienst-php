<header>
    <h2><?php echo __("Teilnehmer Kontaktdaten"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./shift.php?id_shift_type=<?php echo (int)$_GET['id_shift_type'];?>" class="button">
        <i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?>
    </a>
</nav>
<div class="container-center">
    <fieldset>
        <legend><?php echo $placeholder['user']['name']; ?></legend>
        <dl>
            <dt><?php echo __("E-Mail"); ?></dt>
                <dd><a href="mailto:<?php echo $placeholder['user']['email'];?>?subject=Trolleydienst"><?php echo $placeholder['user']['email']; ?></a></dd>
            <dt><?php echo __("Handynr"); ?></dt>
            <?php if(empty($placeholder['user']['mobile'])): ?>
                <dd><?php echo __("fehlt"); ?></dd>
            <?php else: ?>
                <dd><a href="tel:<?php echo $placeholder['user']['mobile']; ?>"><?php echo $placeholder['user']['mobile']; ?></a></dd>
            <?php endif;?>
            <dt><?php echo __("Telefonnr"); ?></dt>
            <?php if(empty($placeholder['user']['phone'])): ?>
                <dd><?php echo __("fehlt"); ?></dd>
            <?php else: ?>
                <dd><a href="tel:<?php echo $placeholder['user']['phone']; ?>"><?php echo $placeholder['user']['phone']; ?></a></dd>
            <?php endif;?>
            <dt><?php echo __("Versammlung"); ?></dt>
            <?php if(empty($placeholder['user']['congregation_name'])): ?>
                <dd><?php echo __("fehlt"); ?></dd>
            <?php else : ?>
                <dd><?php echo $placeholder['user']['congregation_name']; ?></dd>
            <?php endif; ?>
            <dt><?php echo __("Sprache"); ?></dt>
            <?php if(empty($placeholder['user']['language'])): ?>
                <dd><?php echo __("fehlt"); ?></dd>
            <?php else : ?>
                <dd><?php echo $placeholder['user']['language']; ?></dd>
            <?php endif; ?>
        </dl>
    </fieldset>
</div>