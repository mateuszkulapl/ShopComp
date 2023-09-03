let compareAddElement=document.getElementById('compare-add')
if(compareAddElement)
{
    compareAddElement.addEventListener('click', function () {
        var ean = this.getAttribute('data-ean');
        var compare = JSON.parse(localStorage.getItem('compare')) || [];
        compare.push(ean);
        var unique = [...new Set(compare)];
        localStorage.setItem('compare', JSON.stringify(unique));
        var compareLinkWrapper = document.getElementById('compare-link-wrapper');
        
        var compareLink = document.createElement('a');
        compareLink.setAttribute('href', '/koszyk/' + unique.join(','));
        compareLink.innerHTML = 'Przejdź do porównania (' + unique.length + ')';
        
        compareLinkWrapper.innerHTML = '';
        compareLinkWrapper.appendChild(compareLink);
        this.parentNode.removeChild(this);
        
    });
}

compareRemoveElements=document.getElementsByClassName('compareremove')
if(compareRemoveElements)
{
    for (var i = 0; i < compareRemoveElements.length; i++) {
        compareRemoveElements[i].addEventListener('click', function () {
            var ean = this.getAttribute('data-ean');
            var compare = JSON.parse(localStorage.getItem('compare')) || [];
            compare = compare.filter(function (value, index, arr) {
                return value != ean;
            });
            compare = compare.sort();
            localStorage.setItem('compare', JSON.stringify(compare));
            var element = document.getElementById('group-' + ean);
            element.parentNode.removeChild(element);
            var newUrl = window.location.protocol + "//" + window.location.host + '/koszyk/' + compare.join(',')
            location.href=newUrl;
        });
    }
}