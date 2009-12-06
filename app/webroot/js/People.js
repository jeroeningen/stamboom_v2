//modalbox form submit event
if ($('person_submit') != null) {
	$('person_submit').observe('click', function(e) {
		Event.stop(e);
		Modalbox.show(this.form.action, {title: this.title, width: 600, params: Form.serialize(this.form), method: 'post'});
	});
}

//set focus on first formelement in modalbox
if ($('person_form') != null) {
	$('person_form').getElements()[1].focus();
}

//modalbox complain_link event
if ($('complain_link') != null) {
	$('complain_link').observe('click', function(e) {
		Event.stop(e);
		Modalbox.show(this.href);
	});
}

//closing mdalbox event
if ($$('.modalbox_close').length > 0) {
	for (i = 0; i < $$('.modalbox_close').length; i++) {
		$$('.modalbox_close')[i].observe('click', function(e) {
			Event.stop(e);
			Modalbox.hide();
		});
	}
}

//bind modalbox to links in 'modalbox' itself
if ($$('.modalbox_link').length > 0) {
    bind_modalbox_links()
}

//bind events to links on 'normal page'
document.observe('dom:loaded', function() {
	if ($('picture_link') != null) {
		$('picture_link').observe('click', function(e) {
			Event.stop(e);
			Modalbox.show(this.href, {title: this.title, afterHide: function() {location.href = document.location}, width: 600, method: 'post', autoFocusing: true});
		});
	}
	if ($('picture_delete') != null) {
		$('picture_delete').observe('click', function(e) {
			if (!confirm("Wil je je foto echt verwijderen??")) {
				Event.stop(e);
			}
		});
	}
	
	//collapse or fold whole tree
	if ($('toggle_tree') != null) {
    	$('toggle_tree').observe('click', function(e) {
            if ($('toggle_tree').text == 'Alles inklappen') {
                $('toggle_tree').update('Alles uitklappen');
                $('toggle_tree').next().select('ul').each(function(child) {
                    hideLeaf(child);
                });
            } else {
                $('toggle_tree').update('Alles inklappen');
                $('toggle_tree').next().select('ul').each(function(child) {
                    displayLeaf(child);
                });
            }
            Event.stop(e);
    	});
	}
	
	//collapse or fold a single leaf
	$$('.fold').each(function(el) {
	    el.observe('click', function(e) {
	        toggleDisplay(el.up().up().next());
	        Event.stop(e);
	    });
	});

	//set class for last childnode in tree
	$$('ul').each(function(list) {
	    if ($($(list.immediateDescendants()).last()).classNames() == 'collapse') {
            $($(list.immediateDescendants()).last()).removeClassName('collapse');
	        $($(list.immediateDescendants()).last()).addClassName('lastcollapse');
	    } else {
	        $($(list.immediateDescendants()).last()).toggleClassName('last');
	    }
	});
});

/** Bind modalbox to links
 * Very slow function
 */
function bind_modalbox_links() {
	if ($$('.modalbox_link').length > 0) {
		for (i = 0; i < $$('.modalbox_link').length; i++) {
			$$('.modalbox_link')[i].observe('click', function(e) {
				Event.stop(e);
				Modalbox.show(this.href, {title: this.title, afterHide: function() {location.href = document.location}, width: 600, params: null, autoFocusing: true});
			});
		}
	}
}

function toggleDisplay(el) {
   if (el.hasClassName('nodisplay')) {
       displayLeaf(el);
   } else {
       hideLeaf(el);
   }
}

//hide a single leaf
function hideLeaf(el) {
    el.addClassName('nodisplay');
    img = el.previous().select('img')[0];
    img.writeAttribute('src', img.src.replace('collapse', 'fold'));
}

//display a single leaf
function displayLeaf(el) {
    el.removeClassName('nodisplay');
    img = el.previous().select('img')[0];
    img.writeAttribute('src', img.src.replace('fold', 'collapse'));
}