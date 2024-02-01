import { ShiftNavButtonCreate, ShiftCardCalendar, ShiftDialogApplication, ShiftDialogCreation, ShiftDialogPublisherContact } from "./shift/index"

customElements.get("sub-nav-button-create") || window.customElements.define("sub-nav-button-create", ShiftNavButtonCreate)
customElements.get('shift-card-calendar') || window.customElements.define('shift-card-calendar', ShiftCardCalendar)
customElements.get('shift-dialog-application') || window.customElements.define('shift-dialog-application', ShiftDialogApplication)
customElements.get('shift-dialog-creation') || window.customElements.define('shift-dialog-creation', ShiftDialogCreation)
customElements.get('shift-dialog-publisher-contact') || window.customElements.define('shift-dialog-publisher-contact', ShiftDialogPublisherContact)

window.addEventListener(
    "open-shift-dialog-application",
    function(event: CustomEvent) {
        const dialog = document.querySelector("shift-dialog-application")
        dialog.setAttribute("open", "true")
        dialog.setAttribute("shift-id", event.detail.shiftId)
        dialog.setAttribute("shift-position", event.detail.shiftPosition)
    }
)

window.addEventListener(
    "open-shift-dialog-publisher",
    async function(event: CustomEvent) {
        const apiUrl = '/api/me'
        const response = await fetch(
            apiUrl,
            {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            }
        )

        if (response.status !== 200) {
            console.error('Can not read the details of the logged in publisher')
            return
        }

        const loggedInPublisher = await response.json()

        if (loggedInPublisher.id === event.detail.publisherId) {
            const dialog = document.querySelector("shift-dialog-publisher")
            dialog.setAttribute("open", "true")
            dialog.setAttribute("shift-id", event.detail.shiftId)
            dialog.setAttribute("shift-type-id", event.detail.shiftTypeId)
            dialog.setAttribute("shift-position", event.detail.shiftPosition)
            dialog.setAttribute("publisher-id", event.detail.publisherId)
            return
        }

        const dialog = document.querySelector("shift-dialog-publisher-contact")
        dialog.setAttribute("open", "true")
        dialog.setAttribute("publisher-id", event.detail.publisherId)
    }
)

document.getElementById("create-shift-button").addEventListener(
    "click",
    function(event) {
        const dialog = document.querySelector("shift-dialog-creation")
        dialog.setAttribute("open", "true")
    },
    true
)