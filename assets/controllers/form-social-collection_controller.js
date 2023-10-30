import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["collectionContainer", "field"];

    static values = {
        index: Number,
        prototype: String,
    };

    addCollectionElement(event) {
        const item = document.createElement("p");
        item.setAttribute("id", this.indexValue);
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        this.collectionContainerTarget.appendChild(item);
        this.indexValue++;
    }

    removeElement(event) {

        this.fieldTargets.forEach((element) => {
            if (element.contains(event.target)) {
                element.remove();
            }
        });
    }
}
