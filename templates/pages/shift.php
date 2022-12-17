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

<template id="shift">
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

<template id="publisher">
    <span>
        <button class="enable" onclick="showDialog(this)" type="button">
            <i class="fa fa-check-circle-o"></i>{FIRSTNAME} {LASTNAME}
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
<script>
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
   
    function shiftDay(templateShiftDay, templateShift, templatePublisher, data) {
        const documentShiftDay = templateShiftDay.content.cloneNode(true)

        const date = new Date(data.date)

        const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

        const tableHead = documentShiftDay.querySelector('thead tr th')
        tableHead.textContent = tableHead.textContent.replace(/{DAY}/i, weekdays[date.getDay()])
        tableHead.textContent = tableHead.textContent.replace(/{DATE}/i, date.toLocaleDateString())
        tableHead.textContent = tableHead.textContent.replace(/{ROUTE_NAME}/i, data.routeName)

        for (const t of data.shifts) {
            documentShiftDay.querySelector("tbody").appendChild(shift(templateShift, templatePublisher, t))
        }

        const tableContainer = document.querySelector(".table-container")
        tableContainer.appendChild(documentShiftDay)
    }

    function shift(templateShift, templatePublisher, data) {
        const documentShift = templateShift.content.cloneNode(true)
        const elementPublishers = documentShift.querySelector(".shift-publishers")

        for (const t of data.publishers) {
            elementPublishers.prepend(publisher(templatePublisher, t))
        }
        
        return documentShift
    }

    function publisher(templatePublisher, data) {
        const documentPublishers = templatePublisher.content.cloneNode(true)

        const button = documentPublishers.querySelector("button")
        button.textContent = button.textContent.replace(/{FIRSTNAME}/i, data.firstname)
        button.textContent = button.textContent.replace(/{LASTNAME}/i, data.lastname)

        return documentPublishers
    }

    (async () => {
        const response = await fetch('/api/shift/list-shifts?start-time=2022-12-12&shift-type-id=1&page-number=1&page-items=10');
        const shiftDays = await response.json();

        const templateShiftDay = document.querySelector("template#shift-day")
        const templateShift = document.querySelector("template#shift")
        const templatePublisher = document.querySelector("template#publisher")


        for (const data of shiftDays) {
            shiftDay(templateShiftDay, templateShift, templatePublisher, data)
        }
    })();

    

    
</script>