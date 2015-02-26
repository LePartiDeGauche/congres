var $collectionHolder;

// setup an "add a role" link
var $addRoleLink = $('<a href="#" class="add_role_link">Add a role</a>');
var $newLinkLi = $('<li></li>').append($addRoleLink);

function addRoleForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a role" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}


jQuery(document).ready(function() {
    // Get the ul that holds the collection of role
    $collectionHolder = $('ul.roles');

    // add the "add a role" anchor and li to the roles ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addRoleLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new role form (see next code block)
        addRoleForm($collectionHolder, $newLinkLi);
    });
});


