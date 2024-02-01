"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    h2 {
      text-align: left;
    }
  </style>
  <h2>
    <span id="date">Date</span> - <span id="route-name">Route Name</span>
  </h2>
`;

export class ShiftCardTitle extends HTMLElement {
  static observedAttributes = ["date", "route-name"]

  constructor() {
    super();

    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );
  }

  attributeChangedCallback(name: string, oldVal: string, newVal: string): void {
    if (name === "date") {
      (this.shadowRoot.querySelector("#date") as HTMLSpanElement).innerText = new Date(
        newVal,
      ).toDateString();
      return;
    }

    if (name === "route-name") {
      (this.shadowRoot.querySelector("#route-name") as HTMLSpanElement).innerText = newVal;
    }
  }
}
