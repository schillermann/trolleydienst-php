const timeFrom = document.getElementById("time_from");
const timeTo = document.getElementById("time_to");
const number = document.getElementById("number");
const hoursPerShift = document.getElementById("hours_per_shift");

function calculateShiftTimeTo() {
    const timeRangeInMinutes = number.value * (hoursPerShift.value * 60);
    const timeFromSplit = timeFrom.value.split(":");

    const dateFrom = new Date();
    dateFrom.setHours(timeFromSplit[0]);
    dateFrom.setMinutes(timeFromSplit[1]);

    const dateTo = new Date(dateFrom.getTime() + timeRangeInMinutes * 60000);
    timeTo.value = dateTo.getHours() + ":" + ("0" + dateTo.getMinutes()).substr(-2);
}