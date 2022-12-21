"use strict"

import ShiftCalendar from "./shift-calendar.js"
import ShiftTable from "./shift-table.js"
import ShiftRow from "./shift-row.js"
import PublisherButton from "./publisher-button.js"
import ShiftApi from "./shift-api.js"
import BookingButton from "./booking-button.js"
import AdditionPublisherButton from "./addition-publisher-button.js"

const shiftCalendar = new ShiftCalendar(
    document.querySelector(".table-container"),
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
    new ShiftApi("/api/shift/list-shifts", new Date(), 1, 10)
)

await shiftCalendar.load()