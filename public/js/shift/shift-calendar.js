"use strict"

export default class ShiftCalendar {
    #shiftTable
    #startDate
    #shiftTypeId
    #pageItems

    #endpoint
    #days
    #pageNumber
    #numberOfDaysFrom
    #numberOfDaysTo
    #numberOfDaysTotal

    /**
     * @param {import("./shift-table").default} shiftTable
     */
    constructor(shiftTable, startDate, shiftTypeId, pageItems) {
        this.#shiftTable = shiftTable
        this.#startDate = startDate
        this.#shiftTypeId = shiftTypeId
        this.#pageItems = pageItems

        this.#endpoint = "/api/shift/shift-days-created"
        this.#pageNumber = 0
        this.#numberOfDaysFrom = 0
        this.#numberOfDaysTo = 0
        this.#numberOfDaysTotal = 0
    }

    days() {
        return this.#days
    }

    async loadNextDays() {
        this.#pageNumber++
        this.#days = []

        const response = await fetch(
            this.#endpoint +
            "?start-date=" + this.#startDate.toISOString().split('T')[0] +
            "&shift-type-id=" + this.#shiftTypeId +
            "&page-number=" + this.#pageNumber +
            "&page-items=" + this.#pageItems
        )

        for (const shiftDay of await response.json()) {
            this.#days.push(
                await this.#shiftTable.node(
                    new Date(shiftDay.date),
                    shiftDay.id,
                    shiftDay.routeName,
                    shiftDay.publisherLimit,
                    shiftDay.shifts
                )
            )
        }

        if (this.#days.length === 0) {
            this.#pageNumber--
            return
        }

        const range = response.headers.get("Content-Range")
        const rangeSplit = range.split(/( |-|\/)+/)
        this.#numberOfDaysFrom = rangeSplit[2]
        this.#numberOfDaysTo = rangeSplit[4]
        this.#numberOfDaysTotal = rangeSplit[6]
    }

    /**
     * @returns {string}
     */
    numberOfDays() {
        return `${this.#numberOfDaysFrom}-${this.#numberOfDaysTo} / ${this.#numberOfDaysTotal}`
    }
}