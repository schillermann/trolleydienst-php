<template id="shift-day">
    <table id="id_shift_1">
        <thead>
            <tr>
                <th colspan="2" style="background-color: red">{DAY}, {DATE} - {ROUTE_NAME}</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="background-color: red">
                    <p>
                         <!-- if admin -->
                        <a href="./shift-edit.php?id_shift_type=1&id_shift=1" class="button">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<template id="shift-row">
    <tr>
        <td class="shift-time">08:00 - 10:00</td>
        <td class="shift-publishers">
            <span>
                <button class="enable user-plus" name="user-plus" type="button" onclick="showDialog(this)" style="float: right;">
                    <i class="fa fa-user-plus"></i>
                </button>
            </span>

        </td>
    </tr>
</template>

<template id="publisher-button">
    <span>
        <button class="enable" onclick="showDialog(this)" type="button">
            <i class="fa fa-check-circle-o"></i>{FIRSTNAME} {LASTNAME}
        </button>
    </span>
</template>

<template id="booking-button">
    <span>
        <button class="button promote" onclick="showDialog(this)" type="button">
            <i class="fa fa-hand-o-right">{AVAILABLE}
        </button>
    </span>
</template>

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
        <a href="./add-shift?id_shift_type=<?= $placeholder['id_shift_type'] ?>" class="button active">
            <i class="fa fa-plus"></i> <?= __('New Shifts') ?>
        </a>
    </nav>
<?php endif ?>
<?php include '../templates/pagesnippets/note-box.php' ?>

<div class="table-container">
    
</div>
<script type="module">
    import ShiftCalendar from "./js/shift/shift-calendar.js"
    import ShiftTable from "./js/shift/shift-table.js"
    import ShiftRow from "./js/shift/shift-row.js"
    import PublisherButton from "./js/shift/publisher-button.js"
    import ShiftApi from "./js/shift/shift-api.js"

    async function submitForm(dropDownPublisherList) {
        const form = dropDownPublisherList.form

        const body = {
            shiftDayId: form.querySelector("input[name='id_shift']").value,
            shiftId: form.querySelector("input[name='position']").value,
            publisherId: dropDownPublisherList.value
        }

        const apiUrl = '/api/shift/register-publisher'
        const response = await fetch(
            apiUrl,
            {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            }
        )

        if (response.status === 201) {
            alert('WUrde angelegt')
        } else {
            alert('Error')
        }
    }

    function showDialog(dialog) {
        const form = dialog.closest('span').children[1];
        form.showModal();
    }

    function closeDialog(dialog) {
        const form = dialog.closest('span').children[1];
        form.close();
    }

    // window.addEventListener('scroll', () => {
    //     console.log(window.scrollY) //scrolled from top
    //     console.log(window.innerHeight) //visible part of screen
    //     if(window.scrollY + window.innerHeight >= document.documentElement.scrollHeight){
    //       console.log('Load new stuff...')
    //     }
    // })

    (async () => {
        const shiftCalendar = new ShiftCalendar(
            document.querySelector(".table-container"),
            new ShiftTable(
                document.querySelector("template#shift-day"),
                new ShiftRow(
                    document.querySelector("template#shift-row"),
                    new PublisherButton(
                        document.querySelector("template#publisher-button")
                    )
                )
            ),
            new ShiftApi("/api/shift/list-shifts", new Date("2022-12-17"), 1, 10)
        )

        await shiftCalendar.load()
        
    })();

    

    
</script>