"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <p>
    <span id="date-from">Date From</span> - <span id="date-to">Date To</span>
  </p>
`;

export class ShiftCardTime extends HTMLElement {
  static observedAttributes = ["date-from", "date-to"]

  constructor() {
    super();

    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );
  }

  attributeChangedCallback(name: string, oldVal: string, newVal: string): void {
    if (name === "date-from") {
      const dateFrom = new Date(newVal);
      if (dateFrom.toString() === "Invalid Date") {
        return;
      }
      const hours = dateFrom.getHours();
      const minutes = new String("0" + dateFrom.getMinutes()).slice(-2);
      (this.shadowRoot.querySelector(
        "#date-from",
      ) as HTMLSpanElement).innerText = `${hours}:${minutes}`;
      return;
    }

    if (name === "date-to") {
      const dateTo = new Date(newVal);
      if (dateTo.toString() === "Invalid Date") {
        return;
      }
      const hours = dateTo.getHours();
      const minutes = new String("0" + dateTo.getMinutes()).slice(-2);

      (this.shadowRoot.querySelector(
        "#date-to",
      ) as HTMLSpanElement).innerText = `${hours}:${minutes}`;
    }
  }
}
