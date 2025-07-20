let compareAddElement = document.getElementById('compare-add')
if (compareAddElement) {
    compareAddElement.addEventListener('click', function () {
        const ean = this.getAttribute('data-ean');
        const compare = JSON.parse(localStorage.getItem('compare')) || [];
        compare.push(ean);
        const unique = [...new Set(compare)];
        localStorage.setItem('compare', JSON.stringify(unique));
        const compareLinkWrapper = document.getElementById('compare-link-wrapper');

        const compareLink = document.createElement('a');
        compareLink.setAttribute('href', '/koszyk/' + unique.join(','));
        compareLink.innerHTML = 'Przejdź do porównania (' + unique.length + ')';

        compareLinkWrapper.innerHTML = '';
        compareLinkWrapper.appendChild(compareLink);
        this.parentNode.removeChild(this);

    });
}

let compareRemoveElements = document.getElementsByClassName('compareremove')
if (compareRemoveElements) {
    for (let i = 0; i < compareRemoveElements.length; i++) {
        compareRemoveElements[i].addEventListener('click', function () {
            const ean = this.getAttribute('data-ean');
            let compare = JSON.parse(localStorage.getItem('compare')) || [];
            compare = compare.filter(function (value) {
                return value !== ean;
            });
            compare = compare.sort();
            localStorage.setItem('compare', JSON.stringify(compare));
            const element = document.getElementById('group-' + ean);
            element.parentNode.removeChild(element);
            location.href = window.location.protocol + "//" + window.location.host + '/koszyk/' + compare.join(',');
        });
    }
}


class HeaderSearchHandler {
    #isOpen = false;

    constructor({
                    headerSearchTriggerId = 'headerSearchTrigger',
                    headerSearchId = 'headerSearch',
                    searchInputId = 'search',
                    mainId = 'main'
                } = {}) {
        this.headerSearchTrigger = document.getElementById(headerSearchTriggerId);
        this.headerSearch = document.getElementById(headerSearchId);
        this.searchInput = document.getElementById(searchInputId);
        this.main = document.getElementById(mainId);

        if (!this.headerSearchTrigger || !this.headerSearch || !this.searchInput || !this.main) {
            throw new Error('HeaderSearchHandler DOM exception');
        }

        this.open = this.open.bind(this);
        this.close = this.close.bind(this);
        this.onDocumentClick = this.onDocumentClick.bind(this);
        this.onDocumentKey = this.onDocumentKey.bind(this);


        this.headerSearchTrigger.addEventListener('click', this.open);
    }

    open() {
        if (this.#isOpen) return;
        this.#isOpen = true;
        this.headerSearch.classList.remove('hidden');
        this.headerSearchTrigger.classList.add('hidden');
        this.main.style.filter = "blur(5px)";
        this.main.style.pointerEvents = "none";
        this.searchInput.focus();
        this.addCloseListeners();
    }

    addCloseListeners() {
        document.addEventListener('click', this.onDocumentClick, true);
        document.addEventListener('keydown', this.onDocumentKey, false);
    }

    removeCloseListeners() {
        document.removeEventListener('click', this.onDocumentClick, true);
        document.removeEventListener('keydown', this.onDocumentKey, false);

    }

    close() {
        if (!this.#isOpen) return;
        this.#isOpen = false;
        this.headerSearch.classList.add('hidden');
        this.headerSearchTrigger.classList.remove('hidden');
        this.main.style.filter = "";
        this.main.style.pointerEvents = "initial";
        this.removeCloseListeners();
    }

    onDocumentClick(event) {
        if (
            this.headerSearch.contains(event.target) ||
            this.headerSearchTrigger.contains(event.target)
        ) return;
        this.close();
    }

    onDocumentKey(event) {
        if (event.key === 'Escape') {
            this.close();
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new HeaderSearchHandler();
});
