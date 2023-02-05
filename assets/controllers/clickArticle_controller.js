import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    showBandLink(event) {
        window.location.assign(`/band/show/${event.target.closest("article").dataset.slug}`);
}
    connect() {
    }
}
