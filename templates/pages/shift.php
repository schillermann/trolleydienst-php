<header>
    <h2><?= $placeholder['shift_type']['name']; ?> <?= __('Shifts') ?></h2>
    <?php if (!empty($placeholder['shift_type']['info'])) : ?>
        <div class="info-box">
            <p>
                <?= $placeholder['shift_type']['info']; ?>
            </p>
        </div>
    <?php endif; ?>
</header>

<?php if ($_SESSION['is_admin']) : ?>
    <nav id="nav_shift">
        <sub-nav-button-create id="create-shift-button">
          Create Shift
        </sub-nav-button-create>
    </nav>
<?php endif ?>
<?php include '../templates/pagesnippets/note-box.php' ?>

<shift-dialog-application language-code="en" open="false" logged-in-publisher-id="1"></shift-dialog-application>
<shift-dialog-creation language-code="en" open="false" shift-type-id="<?= $placeholder['id_shift_type'] ?>"></shift-dialog-creation>
<shift-card-calendar language-code="en" shift-type-id="1"></shift-card-calendar>
<shift-dialog-publisher language-code="en"></shift-dialog-publisher>
<shift-dialog-publisher-contact language-code="en"></shift-dialog-publisher-contact>

<div class="number-of-pages">
    <p style="text-align: center"></p>
</div>
<div class="loading">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
</div>

<script type="module" src="js/shift.js"></script>