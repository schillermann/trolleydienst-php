"use strict"

export default class BookingButton {
   #template

    /**
     * @param {Element} template
     */
     constructor(template) {
        this.#template = template
    }

    /**
     * @returns {Node}
     */
     node() {
        const cloneNode = this.#template.content.cloneNode(true)
        return cloneNode
     }
}