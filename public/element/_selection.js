window._selection = {
    inc        : 0,
    elements   : [],
    type       : undefined,
    select     : function (type, element, data) {
        if (type !== _selection.type) {
            _selection.type = type;
            _selection.reset();
        }
        const item = {};
        const row  = _selection.inc + 1;
        element.setAttribute('selection-id', id);
        item['element'] = element;
        item['data']    = data;
        item['id']      = row;
        _selection.elements.push(item);
        _selection.inc  = row;
    },
    deselect   : function (element) {
        const elements = _selection.elements;
        let iter, item;
        for (let i = 0; i < elements.length; i++) {
            if (elements[i].element === element) {
                iter = i;
                item = elements[i];
                break;
            }
        }
        item.element.removeAttribute('selection-id');
        _selection.elements.splice(iter, 1);
    },
    isSelected : function (element) {
        return element.getAttribute('selection-id') != null;
    },
    reset      : function () {
        const els           = document.querySelectorAll('[selection-id]');
        for (let i = 0; i < els.length; i++) {
            els[i].removeAttribute('selection-id');
        }
        _selection.inc      = 0;
        _selection.elements = [];
    },
    get        : function () {
        const data = [];
        const els  = _selection.elements;
        for (let i = 0; i < els.length; i++) {
            data.push(els.data);
        }

        return data;
    },
};

//SAMPLE CODE
//_selection.select('album-image', DOMElement, data);
//_selection.isSelected(DOMElement);
//_selection.deselect(DOMElement);