"use strict"

export default class ApplyButton {
   #template

    /**
     * @param {Element} template
     */
     constructor(template) {
        this.#template = template
    }

    /**
     * @param {string} shiftId
     * @param {string} position
     * @returns {Node}
     */
     node(shiftDayId, shiftId) {
        const cloneNode = this.#template.content.cloneNode(true)

        const button = cloneNode.querySelector("button")
        button.setAttribute("data-shift-day-id", shiftDayId)
        button.setAttribute("data-shift-id", shiftId)

        return cloneNode
     }
}