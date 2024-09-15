import { LitElement, css, html } from "../lit-all.min.js";
import { translate } from "../translate.js";

export class ViewDialog extends LitElement {
  static properties = {
    _errorMessage: { type: String, state: true },
    title: { type: String },
    open: { type: Boolean },
  };

  static styles = css`
    dialog {
      color: var(--td-text-default-color);
      background-color: var(--td-background-content-color);
    }
    dialog::backdrop {
      background: rgba(0, 0, 0, 0.6);
    }
    footer {
      margin-top: 10px;
    }
  `;

  constructor() {
    super();
    this.__errorMessage = "";
    this.title = "Dialog Box";
    this.open = false;
  }

  /**
   * @param {boolean} val
   */
  set open(val) {
    if (this.renderRoot) {
      const dialog = this.renderRoot.querySelector("dialog");
      val ? dialog.showModal() : dialog.close();
    }
    this._errorMessage = "";
    this._open = val;
  }

  /**
   * @returns {boolean}
   */
  get open() {
    return this._open;
  }

  _clickClose(e) {
    this.open = false;
    this._closed();
  }

  /**
   * @returns {void}
   */
  _closed() {}

  contentTemplate() {
    return "";
  }

  render() {
    return html`
      <dialog>
        <header>
          <h2>${translate(this.title)}</h2>
        </header>
        <div>${this.contentTemplate()}</div>
        <footer>
          <view-button type="wide" @click="${this._clickClose}">
            <i class="fa fa-times-circle"></i>
            ${translate("Close")}
          </view-button>
        </footer>
      </dialog>
    `;
  }
}
customElements.define("view-dialog", ViewDialog);
