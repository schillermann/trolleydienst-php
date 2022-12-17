"use strict"

export default class ShiftCalendar {
    /**
     * @param {Element} tableContainer
     * @param {ShiftTable} shiftTable
     * @param {ShiftApi} shiftApi
     */
    constructor(tableContainer, shiftTable, shiftApi) {
        this.tableContainer = tableContainer
        this.shiftTable = shiftTable
        this.shiftApi = shiftApi
    }

    async load() {
        const shiftDays = await this.shiftApi.shiftDays()
        for (const shiftDay of shiftDays) {
            this.tableContainer.appendChild(
                await this.shiftTable.node(
                    new Date(shiftDay.date),
                    shiftDay.routeName,
                    shiftDay.shifts
                )
            )
        }
    }
}