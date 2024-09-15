import { LitElement, css, html } from "../lit-all.min.js";
import { translate } from "../translate.js";

export class ViewSearch extends LitElement {
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

  /**
   * @param {Event} event
   * @returns {void}
   */
  async _click(event) {
    this.dispatchEvent(
      new CustomEvent("search", {
        bubbles: true,
        composed: true,
        detail: {
          search: this.renderRoot.querySelector("input").value,
        },
      })
    );
  }

  /**
   * @returns {string}
   */
  render() {
    return html`<link rel="stylesheet" href="css/fontawesome.min.css" />
      <input type="search" placeholder="${translate("Search Publishers")}" />
      <view-button type="flex" @click="${this._click}">
        <i class="fa-solid fa-search"></i>
      </view-button>`;
  }
}

customElements.define("view-search", ViewSearch);
