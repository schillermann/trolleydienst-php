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
        <nav-sub-button-create id="create-shift-button">
          Create Shift
        </nav-sub-button-create>
    </nav>
<?php endif ?>
<?php include '../templates/pagesnippets/note-box.php' ?>

<shift-dialog-application language-code="en" open="false" publisher-id="1"></shift-dialog-application>
<shift-dialog-create-shift language-code="en" open="false" shift-type-id="<?= $placeholder['id_shift_type'] ?>"></shift-dialog-create-shift>
<shift-card-calendar language-code="en" shift-type-id="1"></shift-card-calendar>
<shift-dialog-publisher language-code="en"></shift-dialog-publisher>
<shift-dialog-publisher-partner language-code="en"></shift-dialog-publisher-partner>

<div class="number-of-pages">
    <p style="text-align: center"></p>
</div>
<div class="loading">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
</div>

<script type="module">
    import NavSubButtonCreate from "./js/nav/sub/button-create.js"
    import ShiftCardCalendar from "./js/shift/card/shift-card-calendar.js"
    import ShiftDialogApplication from "./js/shift/dialog/application.js"
    import ShiftDialogCreateShift from "./js/shift/dialog/create-shift.js"
    import ShiftDialogPublisher from "./js/shift/dialog/publisher.js"
    import ShiftDialogPublisherPartner from "./js/shift/dialog/shift-dialog-publisher-partner.js"

    customElements.get("nav-sub-button-create") || window.customElements.define("nav-sub-button-create", NavSubButtonCreate)
    customElements.get('shift-card-calendar') || window.customElements.define('shift-card-calendar', ShiftCardCalendar)
    customElements.get('shift-dialog-application') || window.customElements.define('shift-dialog-application', ShiftDialogApplication)
    customElements.get('shift-dialog-create-shift') || window.customElements.define('shift-dialog-create-shift', ShiftDialogCreateShift)
    customElements.get('shift-dialog-publisher') || window.customElements.define('shift-dialog-publisher', ShiftDialogPublisher)
    customElements.get('shift-dialog-publisher-partner') || window.customElements.define('shift-dialog-publisher-partner', ShiftDialogPublisherPartner)

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
        async function(event) {
            const apiUrl = '/api/me'
            const response = await fetch(
                apiUrl,
                {
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json' }
                }
            )

            if (response.status !== 200) {
                console.error('Can not read the details of the logged in publisher')
                return
            }

            const loggedInPublisher = await response.json()

            if (loggedInPublisher.id === event.detail.publisherId) {
                const dialog = document.querySelector("shift-dialog-publisher")
                dialog.setAttribute("open", "true")
                dialog.setAttribute("shift-id", event.detail.shiftId)
                dialog.setAttribute("shift-type-id", event.detail.shiftTypeId)
                dialog.setAttribute("shift-position", event.detail.shiftPosition)
                dialog.setAttribute("publisher-id", event.detail.publisherId)
                return
            }

            const dialog = document.querySelector("shift-dialog-publisher-partner")
            dialog.setAttribute("open", "true")
            dialog.setAttribute("shift-id", event.detail.shiftId)
            dialog.setAttribute("shift-type-id", event.detail.shiftTypeId)
            dialog.setAttribute("shift-position", event.detail.shiftPosition)
            dialog.setAttribute("publisher-id", event.detail.publisherId)
        }
    )

    document.getElementById("create-shift-button").addEventListener(
        "click",
        function(event) {
            const dialog = document.querySelector("shift-dialog-create-shift")
            dialog.setAttribute("open", "true")
        },
        true
    )
</script>
