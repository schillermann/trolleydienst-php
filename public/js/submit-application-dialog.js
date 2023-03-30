"use strict"

/**
 * @param {Element} button 
 */
async function submitApplication(button) {

	const publisherId = button.parentElement.querySelector("[name=publishers]").value
	if (!publisherId) {
		return
	}

	const body = {
		shiftDayId: parseInt(button.getAttribute("data-shift-day-id")),
		shiftId: parseInt(button.getAttribute("data-shift-id")),
		publisherId: parseInt(publisherId)
	}

	const apiUrl = '/api/shift/register-publisher-for-shift'
	const response = await fetch(
		apiUrl,
		{
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(body)
		}
	)

	// TODO: display error message in dialog
	if (response.status !== 201) {
		alert('Error')
	}

	// submitApplicationDialog.close()
}