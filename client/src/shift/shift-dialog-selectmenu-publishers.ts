"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    select {
      width: 100%;
    }
  </style>

  <select></select>
`;

export class ShiftDialogSelectmenuPublishers extends HTMLElement {
  static observedAttributes = ["selected-publisher-id"];

  constructor() {
    super();

    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );
  }

  onChangeMenu(event: Event) {
    this.dispatchEvent(
      new CustomEvent("selectmenu-change", {
        bubbles: true,
        composed: true,
        detail: {
          // @ts-ignore
          publisherId: event.target.value,
        },
      }),
    );
  }

  connectedCallback(): void {
    this.shadowRoot
      .querySelector("select")
      .addEventListener("change", this.onChangeMenu);
  }

  disconnectedCallback(): void {
    this.shadowRoot
      .querySelector("select")
      .removeEventListener("change", this.onChangeMenu);
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns {void}
   */
  async attributeChangedCallback(name: string, oldVal: string, newVal: string) {
    if (name !== "selected-publisher-id") {
      return;
    }

    const response = await fetch("/api/shift/publishers-enabled");

    for (const publisher of await response.json()) {
      const select = this.shadowRoot.querySelector("select");
      const option = document.createElement("option");
      option.value = publisher.id;
      option.innerHTML = publisher.name;
      if (publisher.id == newVal) {
        option.setAttribute("selected", "selected");
      }
      select.appendChild(option);
    }
  }
}
