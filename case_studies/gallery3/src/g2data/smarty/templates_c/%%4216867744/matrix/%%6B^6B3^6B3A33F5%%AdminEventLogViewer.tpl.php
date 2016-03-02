<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/core/templates/AdminEventLogViewer.tpl */ ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Recent Events'), $this);?>
 </h2>
</div>
<div id="eventBlock" class="gbBlock" style="display: none">
<table class="gbDataTable">
<thead>
<tr>
<th>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Date'), $this);?>

</th>
<th>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Type'), $this);?>

</th>
<th>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Location'), $this);?>

</th>
<th>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Client'), $this);?>

</th>
<th>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Summary'), $this);?>

</th>
</tr>
</thead>
<tbody id="eventTableBody">
</tbody>
</table>
<div style="margin-bottom: 10px" class="gcBackground1">
<span id="pageMessage" style="display: none"></span>
<span id="previousPage" style="display: none; margin: 10px"><a href="#" onclick="javascript:changePage(-1)"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "&laquo; back"), $this);?>
</a></span>
<span id="nextPage" style="display: none; padding: 10px"><a href="#" onclick="javascript:changePage(+1)"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "next &raquo;"), $this);?>
</a></span>
</div>
</div>
<div class="gbBlock" id="noEventsBlock" style="display: none">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "No events have been reported yet."), $this);?>
 </h2>
</div>
<div id="eventDetails" class="gbBlock" style="display: none">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Event Details'), $this);?>
 </h2>
<table class="gbDataTable">
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Date'), $this);?>
 </td> <td class="gbEven" id="dateDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Type'), $this);?>
 </td> <td class="gbEven" id="typeDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Location'), $this);?>
 </td> <td class="gbEven" id="locationDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'User Id'), $this);?>
 </td> <td class="gbEven" id="userIdDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Client'), $this);?>
 </td> <td class="gbEven" id="clientDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Summary'), $this);?>
 </td> <td class="gbEven" id="summaryDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Referer'), $this);?>
 </td> <td class="gbEven" id="refererDetails"> </td> </tr>
<tr> <td class="gbOdd"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Details'), $this);?>
 </td> <td class="gbEven"> <pre> <span id="detailsDetails"> </span></pre> </td> </tr>
</table>
</div>
<script type="text/javascript">
// <![CDATA[
var getRecordsUrl = '<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.AdminEventLogViewerCallback",'arg2' => "command=getRecords",'arg3' => "pageNumber=__PAGE_NUMBER__",'arg4' => "pageSize=__PAGE_SIZE__",'useAuthToken' => 1,'htmlEntities' => 0), $this);?>
';
var getRecordDetailsUrl = '<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.AdminEventLogViewerCallback",'arg2' => "command=getRecordDetails",'arg3' => "id=__ID__",'useAuthToken' => 1,'htmlEntities' => 0), $this);?>
';
var pageNumber = 1;
var pageSize = 20;
var totalPages = 1;
var noSummaryText = '<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'no summary','forJavascript' => 1), $this);?>
';
var locationLink = '<a href="__PLACEHOLDER__"><?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Link','forJavascript' => 1), $this);?>
</a>';
var failureMessage = '<?php echo $this->_reg_objects['g'][0]->text(array('text' => "An error occurred while retrieving the event log entry details.",'forJavascript' => 1), $this);?>
';
<?php echo '
var eventTableBody = document.getElementById("eventTableBody");
function setRecord(index, record) {
var row;
if (eventTableBody.rows.length <= index) {
row = eventTableBody.appendChild(document.createElement("tr"));
YAHOO.util.Dom.addClass(row, index % 2 ? "gbOdd" : "gbEven");
for (var i = 0; i < 5; i++) {
row.appendChild(document.createElement("td"));
}
} else {
row = eventTableBody.rows[index];
}
var i = 0;
row.childNodes[i++].innerHTML = record[\'date\'].replace(/ /g, \'&nbsp;\');
row.childNodes[i++].innerHTML = record[\'type\'].replace(/ /g, \'&nbsp;\');
row.childNodes[i++].innerHTML = locationLink.replace(\'__PLACEHOLDER__\', record[\'location\']);
row.childNodes[i++].innerHTML = record[\'client\'];
var summary = record[\'summary\'] ? record[\'summary\'] : \'<i>\' + noSummaryText + \'</i>\';
row.childNodes[i++].innerHTML =
\'<a href="javascript:getRecordDetails(\' + record[\'id\'] + \')">\' + summary + \'</a>\';
}
function changePage(deltaPages) {
var newPageNumber = Math.min(Math.max(pageNumber + deltaPages, 1), totalPages);
if (newPageNumber != pageNumber) {
pageNumber = newPageNumber;
getRecords();
}
}
function getRecordDetails(id) {
var url = getRecordDetailsUrl.replace(\'__ID__\', id);
YAHOO.util.Connect.asyncRequest(\'GET\', url, {
"success": displayRecordDetails,
"failure": function() { alert(failureMessage); }
});
}
function displayRecordDetails(response) {
var data = eval("(" + response.responseText + ")");
for (var key in data) {
var el = document.getElementById(key + "Details");
if (el) {
el.innerHTML = data[key];
}
}
document.getElementById("eventDetails").style.display = "block";
}
function getRecords() {
var url = getRecordsUrl.replace(\'__PAGE_NUMBER__\', pageNumber).replace(\'__PAGE_SIZE__\', pageSize);
YAHOO.util.Connect.asyncRequest(\'GET\', url, {"success":  displayRecords});
}
function displayRecords(response) {
var data = eval("(" + response.responseText + ")");
for (var i = 0; i < data.records.length; i++) {
setRecord(i, data.records[i]);
}
while (eventTableBody.rows.length > data.records.length) {
eventTableBody.removeChild(eventTableBody.rows[eventTableBody.rows.length - 1]);
}
document.getElementById("pageMessage").innerHTML = data.pageMessage;
totalPages = data.totalPages;
document.getElementById("previousPage").style.display = (pageNumber == 1) ? "none" : "inline";
document.getElementById("nextPage").style.display = (pageNumber == totalPages) ? "none" : "inline";
document.getElementById("eventBlock").style.display = totalPages > 0 ? "block" : "none";
document.getElementById("noEventsBlock").style.display = totalPages > 0 ? "none" : "block";
}
getRecords();
'; ?>

// ]]>
</script>