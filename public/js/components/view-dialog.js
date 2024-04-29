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
    button {
      transition: box-shadow 0.28s;
      padding: 6px 12px;
      line-height: 1.4;
      font-size: 1rem;
      vertical-align: middle;
      touch-action: manipulation;
      cursor: pointer;
      user-select: none;
      border: 1px solid rgba(189, 183, 181, 0.5);
      margin-bottom: 4px;
      background-color: var(--td-background-element);
      border-radius: var(--td-radius);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 180px;
      color: var(--td-text-primary);
      width: 100%;
    }

    button[type="submit"] {
      color: var(--td-background-secondary);
      background-color: var(--td-primar);
    }

    button:hover {
      filter: brightness(var(--td-focus));
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
