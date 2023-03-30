"use strict"

const withdrawApplicationDialog = document.getElementById("withdraw-application-dialog")
const withdrawApplicationButton = withdrawApplicationDialog.querySelector("#withdraw-application-button")

function openWithdrawApplicationDialog(button) {
	withdrawApplicationButton.setAttribute("data-shift-day-id", button.getAttribute("data-shift-day-id"))
	withdrawApplicationButton.setAttribute("data-shift-id", button.getAttribute("data-shift-id"))
	withdrawApplicationButton.setAttribute("data-publisher-id", button.getAttribute("data-publisher-id"))
	withdrawApplicationDialog.showModal()
}

function closeWithdrawApplicationDialog() {
	withdrawApplicationDialog.close()
}

/**
 * @param {Element} button 
 */
async function withdrawApplication(button) {

	const shiftDayId = parseInt(button.getAttribute("data-shift-day-id"))
	const shiftId = parseInt(button.getAttribute("data-shift-id"))
	const publisherId = parseInt(button.getAttribute("data-publisher-id"))

	const body = {
		shiftDayId,
		shiftId,
		publisherId
	}

	const apiUrl = '/api/shift/withdraw-shift-application'
	const response = await fetch(
		apiUrl,
		{
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(body)
		}
	)

	// TODO: display error message in dialog
	if (response.status !== 204) {
		alert('Error')
	}

	
	const ApplyShiftButton = require("./shift/apply-shift-button.js")
	const applyShiftButton = new ApplyShiftButton(
		document.querySelector("template#apply-shift-button")
	)

	const withdrawApplicationButton = document.querySelector('[data-shift-day-id="' + shiftDayId + '"][data-shift-id="' + shiftId + '"][data-publisher-id="' + publisherId + '"]')
	withdrawApplicationButton.replaceWith(
		applyShiftButton.node(shiftDayId, shiftId)
	)

	withdrawApplicationDialog.close()
}