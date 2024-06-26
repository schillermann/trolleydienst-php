import { LitElement, css, html, nothing } from "../lit-all.min.js";

export class ViewButton extends LitElement {
  static properties = {
    type: { type: String },
    tooltip: { type: String },
  };

  static styles = css`
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
    }

    button:hover {
      filter: brightness(var(--td-focus));
    }

    .danger {
      background-color: var(--td-danger);
    }

    .primary {
      color: #fff;
      background-color: var(--td-primar);
    }

    .active {
      color: #000;
      background-color: var(--td-success);
    }

    .wide {
      width: 100%;
    }

    .flex {
      width: auto;
    }
  `;

  constructor() {
    super();
    this.type = "";
    this.tooltip = "";
  }

  render() {
    return html`
      <button class="${this.type}" title="${this.tooltip || nothing}">
        <slot></slot>
      </button>
    `;
  }
}
customElements.define("view-button", ViewButton);
