"use strict"

export default class ShiftRow {
    /**
     * @param {Element} template
     * @param {PublisherButton} publisherButton
     */
    constructor(template, publisherButton) {
        this.template = template
        this.publisherButton = publisherButton
    }

    /**
     * @returns {Node}
     */
    node(shift) {
        const cloneNode =  this.template.content.cloneNode(true)
        const row = cloneNode.querySelector(".shift-publishers")

        for (const publisher of shift.publishers) {
            row.prepend(this.publisherButton.node(publisher.firstname, publisher.lastname))
        }
        
        return cloneNode
    }
}