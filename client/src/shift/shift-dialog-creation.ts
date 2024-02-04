"use strict";

import { DialogButton } from "../dialog/dialog-button.js";
import { DialogButtonPrimary } from "../dialog/dialog-button-primary.js";
import { Dictionary } from "../dictionary.js";

const template = document.createElement("template");
template.innerHTML = /*html*/`
  <style>
    input {
      width: 100%;
    }
  </style>
  <dialog>
    <form>
      <header>
        <h2>{Create Shift}</h2>
      </header>
      <div>
        <div>
          <label for="route">{Route} <small>({Required})</small></label>
          <input id="route" name="route" required placeholder="{Wie heißt die Route?}">
        </div>
        <div>
          <label for="date_from">{Date} <small>({Required})</small></label>
          <input id="date_from" type="date" name="date_from" required>
        </div>
        <div>
          <label for="time_from">{From} <small>({Required})</small></label>
          <input id="time_from" type="time" name="time_from" required>
        </div>
        <div>
          <label for="number_of_shifts">{Shifts} <small>({Required})</small></label>
          <input id="number_of_shifts" type="number" name="number_of_shifts" required value="2">
        </div>
        <div>
          <label for="hours_per_shift">{Shift Length in Hours} <small>({Required})</small></label>
          <input id="hours_per_shift" type="number" name="hours_per_shift" required="" value="2">
        </div>
        <div>
          <label for="time_to">{To}</label>
          <input id="time_to" type="time" name="time_to" disabled>
        </div>
        <div>
          <label for="shiftday_series_until">{End Date}</label>
          <input id="shiftday_series_until" type="date" name="shiftday_series_until">
        </div>
        <div>
          <label for="color_hex">{Colour}</label>
          <input id="color_hex" type="color" name="color_hex" value="#d5c8e4" maxlength="7" required>
        </div>
      </div>
      <div>
        <dialog-button-primary id="button-create">{Create}</dialog-button-primary>
        <dialog-button id="button-cancel">{Cancel}</dialog-button>
      </div>
    </form>
  </dialog>
`;

export class ShiftDialogCreation extends HTMLElement {
  dictionary: Dictionary
  shiftTypeId: number;

  static observedAttributes = ["open", "language-code", "shift-type-id"];

  constructor() {
    super();

    this.shiftTypeId = 0;
    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );

    this.dictionary = new Dictionary({
      "Create Shift": {
        de: "Schicht Anlegen",
      },
      Required: {
        de: "Pflichtfeld",
      },
      Route: {
        de: "Route",
      },
      Date: {
        de: "Datum",
      },
      From: {
        de: "Von",
      },
      Shifts: {
        de: "Schichten",
      },
      "Shift Length in Hours": {
        de: "Schichtlänge in Stunden",
      },
      "What is the name of this location?": {
        de: "Wie heißt die Route?",
      },
      To: {
        de: "Bis",
      },
      "End Date": {
        de: "Terminserie bis zum",
      },
      Colour: {
        de: "Farbe",
      },
      Create: {
        de: "Anlegen",
      },
      Cancel: {
        de: "Abbrechen",
      },
    });
  }

  onClickButtonCancel(event: Event): void {
    this.setAttribute("open", "false");
  }

  onClickButtonCreate(event: Event): void {
    (this as unknown as HTMLFormElement).requestSubmit();
  }

  async onSubmitForm(event: Event): Promise<void> {
    event.preventDefault();
    const response = await fetch("/api/shifts", {
      method: "POST",
      body: JSON.stringify({
        startDate:
          (this.shadowRoot.getElementById("date_from") as HTMLInputElement).value +
          " " +
          (this.shadowRoot.getElementById("time_from") as HTMLInputElement).value,
        shiftTypeId: this.shiftTypeId,
        routeName: (this.shadowRoot.getElementById("route") as HTMLInputElement).value,
        numberOfShifts: Number(
          (this.shadowRoot.getElementById("number_of_shifts") as HTMLInputElement).value,
        ),
        minutesPerShift:
          Number((this.shadowRoot.getElementById("hours_per_shift") as HTMLInputElement).value) * 60,
        color: (this.shadowRoot.getElementById("color_hex") as HTMLInputElement).value,
      }),
    });

    if (response.status === 201) {
      this.setAttribute("open", "false");
    }
  }

  calculateShiftTimeTo(event: Event): void {
    const numberOfShifts = this.shadowRoot.getElementById("number_of_shifts") as HTMLInputElement;
    const hoursPerShift = this.shadowRoot.getElementById("hours_per_shift") as HTMLInputElement;
    const timeFrom = this.shadowRoot.getElementById("time_from") as HTMLInputElement;
    const timeTo = this.shadowRoot.getElementById("time_to") as HTMLInputElement;

    const timeRangeInMinutes =
      Number(numberOfShifts.value) * (Number(hoursPerShift.value) * 60);
    const timeFromSplit = timeFrom.value.split(":");

    const dateFrom = new Date();
    dateFrom.setHours(Number(timeFromSplit[0]));
    dateFrom.setMinutes(Number(timeFromSplit[1]));

    const dateTo = new Date(dateFrom.getTime() + timeRangeInMinutes * 60000);
    timeTo.value =
      dateTo.getHours() + ":" + ("0" + dateTo.getMinutes()).slice(-2);
  }

  async connectedCallback() {
    customElements.get("dialog-button-primary") ||
      window.customElements.define(
        "dialog-button-primary",
        DialogButtonPrimary,
      );
    this.shadowRoot
      .getElementById("button-create")
      .addEventListener(
        "click",
        this.onClickButtonCreate.bind(this.shadowRoot.querySelector("form")),
      );

    customElements.get("dialog-button") ||
      window.customElements.define("dialog-button", DialogButton);
    this.shadowRoot
      .getElementById("button-cancel")
      .addEventListener("click", this.onClickButtonCancel.bind(this));

    this.shadowRoot
      .querySelector("form")
      .addEventListener("submit", this.onSubmitForm.bind(this));

    this.shadowRoot
      .getElementById("time_from")
      .addEventListener("change", this.calculateShiftTimeTo.bind(this));
    this.shadowRoot
      .getElementById("number_of_shifts")
      .addEventListener("change", this.calculateShiftTimeTo.bind(this));
    this.shadowRoot
      .getElementById("hours_per_shift")
      .addEventListener("change", this.calculateShiftTimeTo.bind(this));
  }

  disconnectedCallback() {
    this.shadowRoot
      .getElementById("button-create")
      .removeEventListener("click", this.onClickButtonCreate);
    this.shadowRoot
      .getElementById("button-cancel")
      .removeEventListener("click", this.onClickButtonCancel);

    this.shadowRoot
      .querySelector("form")
      .removeEventListener("submit", this.onSubmitForm);

    this.shadowRoot
      .getElementById("time_from")
      .removeEventListener("change", this.calculateShiftTimeTo);
    this.shadowRoot
      .getElementById("number_of_shifts")
      .removeEventListener("change", this.calculateShiftTimeTo);
    this.shadowRoot
      .getElementById("hours_per_shift")
      .removeEventListener("change", this.calculateShiftTimeTo);
  }

  attributeChangedCallback(name: string, oldVal: string, newVal: string) {
    if (name === "open") {
      const dialog = this.shadowRoot.querySelector("dialog");
      if (newVal === "true") {
        dialog.showModal();
        return;
      }
      dialog.close();
      return;
    }

    if (name === "language-code") {
      this.shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
        newVal,
        this.shadowRoot.innerHTML,
      );
      return;
    }

    if (name === "shift-type-id") {
      this.shiftTypeId = Number(newVal);
    }
  }
}
