|s:2609:"/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
function BlockToggle(objId, togId, display) {
    var o = document.getElementById(objId), t = document.getElementById(togId);
    if (o.style.display == 'none') {
	if (!display) display = 'block';
	if (display == 'table-row') {   /* No table-row for IE */
	    var agent = navigator.userAgent.toLowerCase();
	    if (agent.indexOf('msie') >= 0 && agent.indexOf('opera') < 0) display = 'block';
	}
	o.style.display = display;
	if (t) t.innerHTML = '-';
    } else {
	o.style.display = 'none';
	if (t) t.innerHTML = '+';
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