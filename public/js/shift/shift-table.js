"use strict"

export default class ShiftTable {
    #template
    #shiftRow

    /**
     * @param {Element} template
     * @param {import("./shift-row").default} shiftRow
     */
    constructor(template, shiftRow) {
        this.#template = template
        this.#shiftRow = shiftRow
    }

    /**
     * @param {Date} date
     * @param {string} routeName
     * @param {Object[]} shifts
     * @returns {Node}
     */
    async node(date, routeName, publisherLimit, shifts) {
        const cloneNode = this.#template.content.cloneNode(true)

        const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

        const tableHead = cloneNode.querySelector('thead tr th')
        tableHead.textContent = tableHead.textContent.replace(/{DAY}/i, weekdays[date.getDay()])
        tableHead.textContent = tableHead.textContent.replace(/{DATE}/i, date.toLocaleDateString())
        tableHead.textContent = tableHead.textContent.replace(/{ROUTE_NAME}/i, routeName)

        for (const shift of shifts) {
            cloneNode.querySelector("tbody").appendChild(
                this.#shiftRow.node(shift.publishers, publisherLimit)
            )
        }

        return cloneNode
    }
}