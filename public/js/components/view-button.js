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
      border: 1px solid;
      border-color: var(--td-secondary-grey-70);
      margin-bottom: 4px;
      background-color: var(--td-secondary-grey-90);
      border-radius: var(--td-border-radius);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 180px;
      color: var(--td-secondary-black);
    }

    button:hover {
      filter: brightness(var(--td-hover-brightness));
    }

    .danger {
      color: #fff;
      background-color: var(--td-secondary-red);
    }

    .primary {
      color: #fff;
      background-color: var(--td-brand-purple-40);
    }

    .active {
      color: #000;
      background-color: var(--td-secondary-green);
    }

    .wide {
      width: 100%;
    }

    .flex {
      width: auto;
    }

    @media (prefers-color-scheme: dark) {
      button {
        color: var(--td-secondary-white);
        background-color: var(--td-secondary-grey-20);
        border-color: var(--td-secondary-grey-35);
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
