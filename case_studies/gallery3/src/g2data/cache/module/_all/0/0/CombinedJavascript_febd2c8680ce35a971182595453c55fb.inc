|s:2200:"function search_HighlightResults(criteria) {
    criteria = criteria.replace(/([.*+?^${}()|[\]\/\\])/g, '\\$1')
    var regex = new RegExp("(" + criteria + ")", "ig");

    var spans = document.getElementsByTagName("span");
    for (var i = 0; i < spans.length; i++) {
	if (spans[i].className != "ResultData") {
	    continue;
	}
	for (j = 0; j < spans[i].childNodes.length; j++) {
	    if (spans[i].childNodes[j].nodeName == "#text") {
		node = spans[i].childNodes[j];
		result = node.nodeValue;
		/* Some browsers (Firefox) unescape the node value, so re-escape as necessary */
		result = result.replace(/</g, "&lt;");
		result = result.replace(/>/g, "&gt;");
		result = result.replace(/"/g, "&quot;");
		var spanEl = document.createElement("span");
		spanEl.innerHTML =
		    result.replace(regex, "<span class=\"giSearchHighlight\">$1</span>");
		node.parentNode.insertBefore(spanEl, node);
		node.parentNode.removeChild(node);
	    }
	}
    }
}
var search_SearchBlock_promptString, search_SearchBlock_input,
    search_SearchBlock_errorString, search_SearchBlock_inProgressString;
var search_submitted = false;

function search_SearchBlock_init(prompt, error, inProgress) {
    search_SearchBlock_promptString = prompt;
    search_SearchBlock_errorString = error;
    search_SearchBlock_inProgressString = inProgress;
    search_SearchBlock_input = document.getElementById('search_SearchBlock').searchCriteria;

    search_SearchBlock_input.value = prompt;
}

function search_SearchBlock_checkForm() {
    var sc = search_SearchBlock_input.value;
    if (search_submitted) {
	alert(search_SearchBlock_inProgressString);
	return false;
    } else if (sc == search_SearchBlock_promptString || sc == '') {
	alert(search_SearchBlock_errorString);
	return false;
    }
    document.getElementById('search_SearchBlock').submit();
    search_submitted = true;
    return true;
}

function search_SearchBlock_focus() {
    if (search_SearchBlock_input.value == search_SearchBlock_promptString) {
	search_SearchBlock_input.value = '';
    }
}

function search_SearchBlock_blur() {
    if (search_SearchBlock_input.value == '') {
	search_SearchBlock_input.value = search_SearchBlock_promptString;
    }
}
";