<?php /* Smarty version 2.6.20, created on 2015-10-30 03:06:17
         compiled from gallery:modules/comment/templates/ChangeComment.js.tpl */ ?>
<script type="text/javascript">
//<![CDATA[
var changeUrlPattern = '<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=comment.CommentCallback",'arg2' => "command=__COMMAND__",'arg3' => "commentId=__COMMENT_ID__",'useAuthToken' => true,'htmlEntities' => false), $this);?>
';
var prompts = {
'delete' : {
ask: true,
undo: null,
title : '<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Delete this comment?",'forJavascript' => true), $this);?>
',
body : '<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Are you sure you want to delete this comment?",'forJavascript' => true), $this);?>
',
confirm: '<?php echo $this->_reg_objects['g'][0]->text(array('text' => "This comment has been deleted.",'forJavascript' => true), $this);?>
'
},
'despam' : {
ask: false,
undo: 'spam',
confirm: '<?php echo $this->_reg_objects['g'][0]->text(array('text' => "This comment has been marked as not spam. __UNDO__",'forJavascript' => true), $this);?>
'
},
'spam' : {
ask: false,
undo: 'despam',
confirm: '<?php echo $this->_reg_objects['g'][0]->text(array('text' => "This comment has been marked as spam. __UNDO__",'forJavascript' => true), $this);?>
'
},
'yes' : '<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Yes','forJavascript' => true), $this);?>
',
'no' : '<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Cancel','forJavascript' => true), $this);?>
',
'undo' : '<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Undo','forJavascript' => true), $this);?>
'
};
var errorPageUrl = '<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.ErrorPage",'htmlEntities' => false), $this);?>
';
<?php echo '
function handleSuccess(response) {
eval("var result = " + response.responseText);
if (result[\'status\'] == \'error\') {
document.location.href = errorPageUrl;
}
}
var handleFailure = function(response) {
}
function dimComment(id) {
var anim = new YAHOO.util.Anim(
\'comment-\' + id, { opacity: { to: 0.2 } }, 1,
YAHOO.util.Easing.easeIn);
anim.animate();
}
function brightenComment(id) {
var anim = new YAHOO.util.Anim(
\'comment-\' + id, { opacity: { to: 1.0 } }, 1,
YAHOO.util.Easing.easeOut);
anim.animate();
}
function undoChange(id, command) {
YAHOO.util.Connect.asyncRequest(
\'GET\', changeUrlPattern.replace(\'__COMMENT_ID__\', id).replace(\'__COMMAND__\', prompts[command][\'undo\']),
{ success: function(response) {
handleSuccess(response);
document.getElementById(\'gallery\').removeChild(
document.getElementById(\'comment-confirm-\' + id));
brightenComment(id);
},
failure: handleFailure, scope: this });
}
function showConfirmation(id, command) {
var commentEl = document.getElementById(\'comment-\' + id);
var region = YAHOO.util.Dom.getRegion(\'comment-\' + id);
var confirmEl = document.createElement(\'div\');
confirmEl.id = \'comment-confirm-\' + id;
confirmEl.innerHTML = (\'<div class="gbBlock gcBackground2" \' +
\'style="position: absolute; top: \' + (region.top + 20) + \'px; \' +
\'left: \' + (region.left + 100) + \'px;"><h2> \' +
prompts[command][\'confirm\'] + \'</h2></div>\').replace(
\'__UNDO__\',
\'<a href="#" style="cursor: pointer" onclick="undoChange(\' + id +
\', \\\'\' + command + \'\\\'); return false;">\' +
prompts[\'undo\'] + \'</a>\');
document.getElementById("gallery").appendChild(confirmEl);
}
function changeComment(id, command) {
var doChange = function() {
dimComment(id);
YAHOO.util.Connect.asyncRequest(
\'GET\', changeUrlPattern.replace(\'__COMMENT_ID__\', id).replace(\'__COMMAND__\', command),
{ success: function(response) { handleSuccess(response); showConfirmation(id, command); },
failure: handleFailure, scope: this });
}
if (prompts[command][\'ask\']) {
confirmChangeComment(id, command, doChange);
} else {
doChange();
}
}
function confirmChangeComment(id, command, callback) {
var dialog = new YAHOO.widget.SimpleDialog(
"gDialog", { width: "20em",
effect: { effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.25 },
fixedcenter: true,
modal: true,
draggable: false
});
dialog.setHeader(prompts[command][\'title\']);
dialog.setBody(prompts[command][\'body\']);
dialog.cfg.setProperty("icon", YAHOO.widget.SimpleDialog.ICON_WARN);
var handleYes = function() {
this.hide();
callback();
}
var handleNo = function() {
this.hide();
}
var myButtons = [
{ text: prompts[\'yes\'], handler: handleYes },
{ text: prompts[\'no\'], handler: handleNo, isDefault: true }
];
dialog.cfg.queueProperty("buttons", myButtons);
dialog.render(document.body);
}
//]]>
</script>
'; ?>
