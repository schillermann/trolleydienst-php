import { LitElement, css, html } from "../lit-all.min.js";
import { translate } from "../translate.js";

export class ViewDialog extends LitElement {
  static properties = {
    title: { type: String },
    open: { type: Boolean },
  };

  static styles = css`
    dialog {
      color: var(--td-text-primary);
      background-color: var(--td-background-secondary);
    }
    dialog::backdrop {
      background: rgba(0, 0, 0, 0.6);
    }
  `;

  constructor() {
    super();
    this.title = "Dialog Box";
    this.open = false;
  }

  set open(val) {
    if (this.renderRoot) {
      const dialog = this.renderRoot.querySelector("dialog");
      val ? dialog.showModal() : dialog.close();
    }

    this._open = val;
  }

  get open() {
    return this._open;
  }

  _clickClose(e) {
    this.open = false;
  }

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
