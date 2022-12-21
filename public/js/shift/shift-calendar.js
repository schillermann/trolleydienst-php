"use strict"

export default class ShiftCalendar {
    #tableContainer
    #shiftTable
    #shiftApi

    /**
     * @param {Element} tableContainer
     * @param {import("./shift-table").default} shiftTable
     * @param {import("./shift-api").default} shiftApi
     */
    constructor(tableContainer, shiftTable, shiftApi) {
        this.#tableContainer = tableContainer
        this.#shiftTable = shiftTable
        this.#shiftApi = shiftApi
    }

    async load() {
        const shiftDays = await this.#shiftApi.shiftDays()
        for (const shiftDay of shiftDays) {
            this.#tableContainer.appendChild(
                await this.#shiftTable.node(
                    new Date(shiftDay.date),
                    shiftDay.routeName,
                    shiftDay.publisherLimit,
                    shiftDay.shifts
                )
            )
        }
    }
}