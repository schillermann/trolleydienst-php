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
        <shift-button-new-shift></shift-button-new-shift>
    </nav>
<?php endif ?>
<?php include '../templates/pagesnippets/note-box.php' ?>

<shift-dialog-application open="false" language-code="en" publisher-id="1"></shift-dialog-application>
<shift-dialog-new-shift open="false" language-code="en" shift-type-id="<?= $placeholder['id_shift_type'] ?>"></shift-dialog-new-shift>

<script type="module" src="./js/submit-application-dialog.js"></script>

<dialog id="contact-publisher-dialog">
    <header>
        <h2><?= __('Contact Publisher') ?></h2>
    </header>
    <div>
        <img src="images/gadgets.svg">
    </div>
    <div>
        <dl>
            <dt><?= __('Mobile Number') ?></dt>
            <dd><a href="tel:123-456-7890">123-456-7890</a></dd>

            <dt><?= __('Phone Number') ?></dt>
            <dd><a href="tel:123-456-7890">123-456-7890</a></dd>

            <dt><?= __('Email') ?></dt>
            <dd><a href="mailto:email@example.com">mail@gmx.de</a></dd>
        </dl>
    </div>
    <div>
        <button class="button close-button" style="width: 100%"><?= __('OK') ?></button>
    </div>
</dialog>

<dialog id="withdraw-application-dialog">
    <header>
        <h2><?= __('Withdraw Application') ?></h2>
    </header>
    <div>
        <img src="images/gadgets.svg">
    </div>
    <div>
        <p><?= __('Möchtest du die Bewerbung wirklick zurückziehen?') ?></p>
        <button class="button" id="withdraw-application-button" style="width: 100%" onclick="withdrawApplication(this)"><?= __('Yes') ?></button>
        <button class="button close-button" style="width: 100%"><?= __('No') ?></button>
    </div>
</dialog>
<script src="./js/withdraw-application-dialog.js"></script>

<shift-card-calendar language-code="en" shift-type-id="1"></shift-card-calendar>

<div class="number-of-pages">
    <p style="text-align: center"></p>
</div>
<div class="loading">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
</div>

<script type="module">
    import ShiftButtonNewShift from "./js/shift/shift-button-new-shift.js"
    import ShiftCardCalendar from "./js/shift/card/shift-card-calendar.js"
    import ShiftDialogApplication from "./js/shift/dialog/shift-dialog-application.js"
    import ShiftDialogNewShift from "./js/shift/dialog/shift-dialog-new-shift.js"

    customElements.get('shift-button-new-shift') || window.customElements.define('shift-button-new-shift', ShiftButtonNewShift)
    customElements.get('shift-card-calendar') || window.customElements.define('shift-card-calendar', ShiftCardCalendar)
    customElements.get('shift-dialog-application') || window.customElements.define('shift-dialog-application', ShiftDialogApplication)
    customElements.get('shift-dialog-new-shift') || window.customElements.define('shift-dialog-new-shift', ShiftDialogNewShift)

    window.addEventListener(
        "open-shift-dialog-application",
        function(event) {
            const dialog = document.querySelector("shift-dialog-application")
            dialog.setAttribute("open", "true")
            dialog.setAttribute("shift-id", event.detail.shiftId)
            dialog.setAttribute("shift-position", event.detail.shiftPosition)
        }
    )

    window.addEventListener(
        "open-shift-dialog-publisher",
        function(event) {
            const dialog = document.querySelector("shift-dialog-publisher")
            dialog.setAttribute("open", "true")
            dialog.setAttribute("shift-id", event.detail.shiftId)
            dialog.setAttribute("shift-type-id", event.detail.shiftTypeId)
            dialog.setAttribute("shift-position", event.detail.shiftPosition)
            dialog.setAttribute("publisher-id", event.detail.publisherId)
        }
    )

    window.addEventListener(
        "new-shift-click",
        function(event) {
            const dialog = document.querySelector("shift-dialog-new-shift")
            dialog.setAttribute("open", "true")
        },
        true
    )
</script>