import { LitElement, css, html } from "../../lit-all.min.js";
import { translate } from "../../translate.js";

export class CalendarRouteFilter extends LitElement {
  static styles = css`
    input {
      padding: 6px;
      margin: 2px 0;
      border: 1px solid #bdb7b5;
      box-sizing: border-box;
      min-height: 36px;
    }
    @media (prefers-color-scheme: dark) {
      input {
        color: #bfbfbf;
        background-color: #1f1f1f;
      }
    }
  `;

  static properties = {
    date: {
      /**
       * @param {string} value
       * @returns {Date}
       */
      converter(value) {
        return new Date(value);
      },
    },
  };

  constructor() {
    super();
    this.date = new Date();
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  _onChange(event) {
    this.dispatchEvent(
      new CustomEvent("filter-routes", {
        bubbles: true,
        composed: true,
        detail: {
          dateFrom: new Date(event.currentTarget.value),
        },
      })
    );
  }

  /**
   * @returns {string}
   */
  render() {
    return html`<label for="routes-from">${translate("Routes from")}:</label>
      <input
        type="date"
        name="routes-from"
        id="routes-from"
        value="${this.date.toISOString().split("T")[0]}"
        @change="${this._onChange}"
      />`;
  }
}

customElements.define("calendar-route-filter", CalendarRouteFilter);
