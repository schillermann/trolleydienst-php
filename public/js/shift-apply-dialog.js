const shiftApplyDialog = document.getElementById("shift-apply-dialog")
const shiftApplyButton = shiftApplyDialog.querySelector("#shift-apply-button")

/**
 * @param {Element} button 
 */
function openShiftApplyDialog(button) {
	shiftApplyButton.setAttribute("data-shift-day-id", button.getAttribute("data-shift-day-id"))
	shiftApplyButton.setAttribute("data-shift-id", button.getAttribute("data-shift-id"))
	shiftApplyDialog.showModal()
}

function f() {
	shiftApplyDialog.close()
}

/**
 * @param {Element} button 
 */
async function applyShift(button) {

	const publisherId = button.parentElement.querySelector("[name=publishers]").value
	if (!publisherId) {
		return
	}

	const body = {
		shiftDayId: parseInt(button.getAttribute("data-shift-day-id")),
		shiftId: parseInt(button.getAttribute("data-shift-id")),
		publisherId: parseInt(publisherId)
	}

	console.log(body)

	const apiUrl = '/api/shift/register-publisher-for-shift'
	const response = await fetch(
		apiUrl,
		{
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(body)
		}
	)

	if (response.status === 201) {
		alert('WUrde angelegt')
	} else {
		alert('Error')
	}
}