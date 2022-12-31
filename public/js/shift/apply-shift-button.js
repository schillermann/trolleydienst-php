"use strict"

export default class ApplyShiftButton {
    #template
    #dialog

    /**
     * @param {HTMLElement} template
     * @param {HTMLElement} dialog
     */
    constructor(template, dialog) {
        this.#template = template
        this.#dialog = dialog
    }

    /**
     * 
     * @param {HTMLElement} dialog 
     * @returns {Object}
     */
    openDialog(dialog) {
        return function() {
            const shiftApplyButton = dialog.querySelector("#apply-shift-button")
            shiftApplyButton.setAttribute("data-shift-day-id", this.getAttribute("data-shift-day-id"))
            shiftApplyButton.setAttribute("data-shift-id", this.getAttribute("data-shift-id"))
            dialog.showModal()
         }
    }

    /**
     * @param {string} shiftDayId
     * @param {string} shiftId
     * @returns {Node}
     */
    node(shiftDayId, shiftId) {
        const cloneNode = this.#template.content.cloneNode(true)

        const button = cloneNode.querySelector("button")
        button.setAttribute("data-shift-day-id", shiftDayId)
        button.setAttribute("data-shift-id", shiftId)
        button.addEventListener("click", this.openDialog(this.#dialog))

        return cloneNode
    }
}