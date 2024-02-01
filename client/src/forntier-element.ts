export class FrontierElement extends HTMLElement {
    constructor() {
        super();

        const template = document.createElement("template");
        template.innerHTML = this.render();
        template.content.cloneNode(true);
    }

    render(): string {
        return ''
    }
}