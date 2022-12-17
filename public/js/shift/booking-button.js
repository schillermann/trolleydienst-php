"use strict"

export default class BookingButton {
    /**
     * @param {Element} template
     */
     constructor(template) {
        this.template = template
    }

    /**
     * @returns {Node}
     */
     node() {
        const cloneNode = this.template.content.cloneNode(true)

        const button = cloneNode.querySelector("button")
        button.textContent = button.textContent.replace(/{AVAILABLE}/i, "Available")

        return cloneNode
     }
}