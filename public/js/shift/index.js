"use strict"

import ShiftCalendar from "./shift-calendar.js"
import ShiftTable from "./shift-table.js"
import ShiftRow from "./shift-row.js"
import PublisherButton from "./publisher-button.js"
import BookingButton from "./booking-button.js"
import AdditionPublisherButton from "./addition-publisher-button.js"

const shiftCalendar = new ShiftCalendar(
    new ShiftTable(
        document.querySelector("template#shift-table"),
        new ShiftRow(
            document.querySelector("template#shift-row"),
            new PublisherButton(
                document.querySelector("template#publisher-button")
            ),
            new BookingButton(
                document.querySelector("template#booking-button")
            ),
            new AdditionPublisherButton(
                document.querySelector("template#addition-publisher-button")
            )
        )
    ),
    new Date(),
    1,
    5
)

const tableContainer = document.querySelector(".table-container")
const numberOfPages = document.querySelector("div.number-of-pages p")
const loading = document.querySelector(".loading")

async function loadShiftDays() {
    loading.classList.add('show');

    await shiftCalendar.loadNextDays()
    for (const day of shiftCalendar.days()) {
        tableContainer.appendChild(day)
    }
    numberOfPages.textContent = shiftCalendar.numberOfDays()

    loading.classList.remove('show');
}

await loadShiftDays()

window.addEventListener('scroll', async () => {
    if(window.scrollY + window.innerHeight >= document.documentElement.scrollHeight) {
        await loadShiftDays()
    }
})