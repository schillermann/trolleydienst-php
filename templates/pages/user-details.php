<header>
    <h2>Teilnehmer Kontaktdaten</h2>
</header>
<nav id="nav-sub">
    <a href="shift.php?id_shift_type=<?php echo (int)$_GET['id_shift_type'];?>" tabindex="1" class="button">
        <i class="fa fa-chevron-left" aria-hidden="true"></i> zurück
    </a>
</nav>
<div class="container-center">
    <fieldset>
        <legend><?php echo $placeholder['user']['name']; ?></legend>
        <dl>
            <dt>E-Mail</dt>
                <dd><a href="mailto:<?php echo $placeholder['user']['email'];?>?subject=Trolleydienst"><?php echo $placeholder['user']['email']; ?></a></dd>
            <dt>Handynr</dt>
            <?php if(empty($placeholder['user']['mobile'])): ?>
                <dd>fehlt</dd>
            <?php else: ?>
                <dd><a href="tel:<?php echo $placeholder['user']['mobile']; ?>"><?php echo $placeholder['user']['mobile']; ?></a></dd>
            <?php endif;?>
            <dt>Telefonnr</dt>
            <?php if(empty($placeholder['user']['phone'])): ?>
                <dd>fehlt</dd>
            <?php else: ?>
                <dd><a href="tel:<?php echo $placeholder['user']['phone']; ?>"><?php echo $placeholder['user']['phone']; ?></a></dd>
            <?php endif;?>
            <dt>Versammlung</dt>
            <?php if(empty($placeholder['user']['congregation_name'])): ?>
                <dd>fehlt</dd>
            <?php else : ?>
                <dd><?php echo $placeholder['user']['congregation_name']; ?></dd>
            <?php endif; ?>
            <dt>Sprache</dt>
            <?php if(empty($placeholder['user']['language'])): ?>
                <dd>fehlt</dd>
            <?php else : ?>
                <dd><?php echo $placeholder['user']['language']; ?></dd>
            <?php endif; ?>
        </dl>
    </fieldset>
</div>