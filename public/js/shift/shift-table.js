"use strict"

export default class ShiftTable {
    /**
     * @param {Element} template
     * @param {ShiftRow} shiftRow
     */
    constructor(template, shiftRow, shiftApi) {
        this.template = template
        this.shiftRow = shiftRow
    }

    /**
     * @param {Date} date
     * @param {string} routeName
     * @param {Object[]} shifts
     * @returns {Node}
     */
    async node(date, routeName, shifts) {
        const cloneNode = this.template.content.cloneNode(true)

        const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

        const tableHead = cloneNode.querySelector('thead tr th')
        tableHead.textContent = tableHead.textContent.replace(/{DAY}/i, weekdays[date.getDay()])
        tableHead.textContent = tableHead.textContent.replace(/{DATE}/i, date.toLocaleDateString())
        tableHead.textContent = tableHead.textContent.replace(/{ROUTE_NAME}/i, routeName)

        for (const shift of shifts) {
            cloneNode.querySelector("tbody").appendChild(
                this.shiftRow.node(shift)
            )
        }

        return cloneNode
    }
}