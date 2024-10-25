$(document).ready(function() {
    var collectionHolder = $('ul.my-selector');
    var addNewItemButton = $('<button type="button">Add new item</button>');
    var newItemButtonLi = $('<li></li>').append(addNewItemButton);

    collectionHolder.append(newItemButtonLi);

    collectionHolder.data('index', collectionHolder.find(':input').length);

    addNewItemButton.on('click', function(e) {
        addNewForm(collectionHolder, newItemButtonLi);
    });

    function addNewForm(collectionHolder, newItemButtonLi) {
        var prototype = collectionHolder.data('prototype');
        var index = collectionHolder.data('index');

        var newForm = prototype.replace(/__name__/g, index);

        collectionHolder.data('index', index + 1);

        var newFormLi = $('<li></li>').append(newForm);
        newItemButtonLi.before(newFormLi);
    }
});
