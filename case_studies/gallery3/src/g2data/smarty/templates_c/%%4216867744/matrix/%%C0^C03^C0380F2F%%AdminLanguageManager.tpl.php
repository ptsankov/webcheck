<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/core/templates/AdminLanguageManager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'gallery:modules/core/templates/AdminLanguageManager.tpl', 95, false),array('function', 'cycle', 'gallery:modules/core/templates/AdminLanguageManager.tpl', 216, false),array('modifier', 'count', 'gallery:modules/core/templates/AdminLanguageManager.tpl', 173, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Language Settings'), $this);?>
 </h2>
</div>
<?php if (! empty ( $this->_tpl_vars['status']['error'] )): ?>
<div class="gbBlock">
<h2 class="giError">
<?php if (! empty ( $this->_tpl_vars['status']['error']['download'] )): ?>
<?php $_from = $this->_tpl_vars['status']['error']['download']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['error']):
?>
<?php echo $this->_tpl_vars['error']; ?>
<br/>
<?php endforeach; endif; unset($_from); ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Please make sure that your internet connection is set up properly or try again later."), $this);?>
<br/>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['error']['scanPlugin'] )): ?>
<?php $_from = $this->_tpl_vars['status']['error']['scanPlugin']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pluginId']):
?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Failed to scan status from plugin: %s.",'arg1' => $this->_tpl_vars['pluginId']), $this);?>
<br/>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['error']['repositoryInitErrorCount'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Your local copy of the repository was broken and has been fixed.  Please download the plugin list again."), $this);?>

<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['error']['failedToDeleteLanguage'] )): ?>
<?php $_from = $this->_tpl_vars['status']['error']['failedToDeleteLanguage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['language']):
?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Failed to delete the locale directory for %s.",'arg1' => $this->_tpl_vars['language']), $this);?>
 <br/>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</h2>
<?php if (! empty ( $this->_tpl_vars['status']['error']['failedToDownload'] )): ?>
<?php $_from = $this->_tpl_vars['status']['error']['failedToDownload']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pluginType'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pluginType']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pluginType'] => $this->_tpl_vars['plugins']):
        $this->_foreach['pluginType']['iteration']++;
?>
<?php $_from = $this->_tpl_vars['plugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['plugin'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['plugin']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pluginName'] => $this->_tpl_vars['failedFiles']):
        $this->_foreach['plugin']['iteration']++;
?>
<h2 class="giError"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "Failed to download the following language packages for the %s plugin:",'arg1' => $this->_tpl_vars['pluginName']), $this);?>
</h2>
<ul>
<?php $_from = $this->_tpl_vars['failedFiles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
<li class="giError"> <?php echo $this->_tpl_vars['file']; ?>
 </li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php if (! ($this->_foreach['pluginType']['iteration'] == $this->_foreach['pluginType']['total'])): ?><br/><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['error']['failedToInstall'] )): ?>
<?php $_from = $this->_tpl_vars['status']['error']['failedToInstall']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['plugin'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['plugin']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pluginName'] => $this->_tpl_vars['failedFiles']):
        $this->_foreach['plugin']['iteration']++;
?>
<?php $_from = $this->_tpl_vars['status']['error']['failedToInstall']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pluginType'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pluginType']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pluginType'] => $this->_tpl_vars['plugins']):
        $this->_foreach['pluginType']['iteration']++;
?>
<?php $_from = $this->_tpl_vars['plugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['plugin'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['plugin']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pluginName'] => $this->_tpl_vars['failedFiles']):
        $this->_foreach['plugin']['iteration']++;
?>
<h2 class="giError"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "Failed to install language packages for %s plugin because the following files/directories could not be modified:",'arg1' => $this->_tpl_vars['pluginName']), $this);?>
 </h2>
<ul>
<?php $_from = $this->_tpl_vars['failedFiles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
<li class="giError"> <?php echo $this->_tpl_vars['file']; ?>
 </li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php if (! ($this->_foreach['pluginType']['iteration'] == $this->_foreach['pluginType']['total'])): ?><br/><?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status'] )): ?>
<div class="gbBlock"><h2 class="giSuccess">
<?php if (isset ( $this->_tpl_vars['status']['indexUpdated'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "The repository index has been successfully refreshed."), $this);?>

<?php else: ?>
<?php if (! empty ( $this->_tpl_vars['status']['languageSettingsSaved'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "The language settings have been saved."), $this);?>

<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['languagePacksInstalled'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "%d language pack upgraded or downloaded.",'many' => "%d language packs upgraded or downloaded.",'count' => $this->_tpl_vars['status']['languagePacksInstalled'],'arg1' => $this->_tpl_vars['status']['languagePacksInstalled']), $this);?>

<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['languagePacksDeleted'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "%d language pack deleted.",'many' => "%d language packs deleted.",'count' => $this->_tpl_vars['status']['languagePacksDeleted'],'arg1' => $this->_tpl_vars['status']['languagePacksDeleted']), $this);?>

<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['status']['allLanguagesCurrent'] )): ?>
<br />
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'All the language packages for the selected languages are current'), $this);?>

<?php endif; ?>
<?php endif; ?>
</h2></div>
<?php endif; ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'General'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Select language defaults for Gallery. Individual users can override this setting in their personal preferences or via the language selector block if available. Gallery will try to automatically detect the language preference of each user if the browser preference check is enabled."), $this);?>

</p>
<?php if (! empty ( $this->_tpl_vars['AdminLanguages']['canTranslate'] )): ?>
<table class="gbDataTable"><tr>
<td>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Default language'), $this);?>

</td><td>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[default][language]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['AdminLanguages']['languageList'],'selected' => $this->_tpl_vars['form']['default']['language']), $this);?>

</select>
</td>
</tr><tr>
<td>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Check Browser Preference'), $this);?>

</td><td>
<input type="checkbox" <?php if ($this->_tpl_vars['form']['language']['useBrowserPref']): ?>checked="checked" <?php endif; ?>
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[language][useBrowserPref]"), $this);?>
"/>
</td>
</tr></table>
<?php else: ?>
<div class="giWarning">
<?php ob_start(); ?>
<a href="http://php.net/gettext"><?php echo $this->_reg_objects['g'][0]->text(array('text' => 'gettext'), $this);?>
</a>
<?php $this->_smarty_vars['capture']['gettext'] = ob_get_contents(); ob_end_clean(); ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Your webserver does not support localization.  Please instruct your system administrator to reconfigure PHP with the %s option enabled.",'arg1' => $this->_smarty_vars['capture']['gettext']), $this);?>

</div>
<?php endif; ?>
</div>
<div class="gbBlock gcBackground1">
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[save]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Save'), $this);?>
"/>
</div>
<?php if (! $this->_tpl_vars['AdminLanguages']['writeable']['modules'] || ! $this->_tpl_vars['AdminLanguages']['writeable']['themes']): ?>
<div class="gbBlock">
<h3><?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Configure your Gallery'), $this);?>
</h3>
<?php if ($this->_tpl_vars['AdminLanguages']['OS'] == 'unix'): ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Before you can proceed, you have to change some permissions so that Gallery can install plugins for you.  It's easy.  Just execute the following in a shell or via your ftp client:"), $this);?>

</p>
<p class="gcBackground1" style="border-width: 1px; border-style: dotted; padding: 4px">
<b>
cd <?php echo $this->_tpl_vars['AdminLanguages']['basePath']; ?>
<br/>
<?php if (! $this->_tpl_vars['AdminLanguages']['writeable']['modules']): ?>chmod -R 777 modules/*/po<br/><?php endif; ?>
<?php if (! $this->_tpl_vars['AdminLanguages']['writeable']['themes']): ?>chmod -R 777 themes/*/po<br/><?php endif; ?>
</b>
</p>
<?php else: ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Before you can proceed, please insure the following directories and sub-directories are writable, so that Gallery can install plugins for you:"), $this);?>

</p>
<p class="gcBackground1" style="border-width: 1px; border-style: dotted; padding: 4px">
<b>
<?php if (! $this->_tpl_vars['AdminLanguages']['writeable']['modules']): ?><?php echo $this->_tpl_vars['AdminLanguages']['basePath']; ?>
modules<br/><?php endif; ?>
<?php if (! $this->_tpl_vars['AdminLanguages']['writeable']['themes']): ?><?php echo $this->_tpl_vars['AdminLanguages']['basePath']; ?>
themes<br/><?php endif; ?>
</b>
</p>
<?php endif; ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "If you have trouble changing permissions, ask your system administrator for assistance.  When you've fixed the permissions, click the Check Again button to proceed."), $this);?>

</p>
</div>
<div class="gbBlock gcBackground1">
<input class="inputTypeSubmit" type="button" onclick="document.location='<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminLanguageManager"), $this);?>
'" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Check Again'), $this);?>
" />
</div>
<?php else: ?>
<script type="text/javascript">
// <![CDATA[
<?php echo '
function toggleAll(thisAllButton, otherAllButton, checkBoxGroup, languageCount) {
var selectAllButtons = YAHOO.util.Dom.getElementsByClassName("selectAll");
for( var i in selectAllButtons) {
selectAllButtons[i].checked = \'\';
}
var currentButton = document.getElementById(thisAllButton);
var element = document.getElementById(otherAllButton);
currentButton.checked = element.checked = \'checked\';
for (var current = 1; current <= languageCount; current++) {
var element = document.getElementById(checkBoxGroup + current);
if (!element.disabled) {
element.checked = currentButton.checked;
}
}
}
'; ?>

// ]]>
</script>
<?php $this->assign('languageCount', count($this->_tpl_vars['AdminLanguages']['languageUpgradeInfo'])); ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Add or Remove Languages'), $this);?>
 </h3>
<?php if (! empty ( $this->_tpl_vars['languageCount'] )): ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Please click on the link below to go to 'Download Plugin List' and choose 'Update Plugin List' to get the latest language package information."), $this);?>
<br />
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminRepository"), $this);?>
"><?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Administer Repositories'), $this);?>
</a>
</p>
<table class="gbDataTable">
<tr>
<th> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Language'), $this);?>
 </th>
<th> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Upgrade'), $this);?>
 </th>
<th> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Remove'), $this);?>
 </th>
<th> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Download'), $this);?>
 </th>
<th> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'No Change'), $this);?>
 </th>
</tr>
<tr class="gbEven">
<td>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Select All'), $this);?>

</td>
<td style="text-align: center">
<input type="radio" id=selectAllUpgrade1 onclick="toggleAll('selectAllUpgrade1', 'selectAllUpgrade2', 'upgrade', <?php echo $this->_tpl_vars['languageCount']; ?>
)" 
<?php if (empty ( $this->_tpl_vars['AdminLanguages']['enableSelectAll']['upgrade'] )): ?>disabled="disabled" <?php endif; ?>
class="selectAll"/>
</td>
<td style="text-align: center">
<input type="radio" id=selectAllRemove1 onclick="toggleAll('selectAllRemove1', 'selectAllRemove2', 'remove', <?php echo $this->_tpl_vars['languageCount']; ?>
)" 
<?php if (empty ( $this->_tpl_vars['AdminLanguages']['enableSelectAll']['remove'] )): ?>disabled="disabled" <?php endif; ?>
class="selectAll"
/>
</td>
<td style="text-align: center">
<input type="radio" id=selectAllDownload1 onclick="toggleAll('selectAllDownload1', 'selectAllDownload2', 'download', <?php echo $this->_tpl_vars['languageCount']; ?>
)" 
<?php if (empty ( $this->_tpl_vars['AdminLanguages']['enableSelectAll']['download'] )): ?>disabled="disabled" <?php endif; ?>
class="selectAll"
/>
</td>
<td style="text-align: center">
&nbsp;
</td>
</tr>
<?php $_from = $this->_tpl_vars['AdminLanguages']['languageUpgradeInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['languages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['languages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language'] => $this->_tpl_vars['languageData']):
        $this->_foreach['languages']['iteration']++;
?>
<?php $this->assign('i', $this->_foreach['languages']['iteration']); ?>
<tr class="<?php echo smarty_function_cycle(array('values' => "gbOdd, gbEven"), $this);?>
">
<td>
<?php echo $this->_tpl_vars['languageData']['description']; ?>

</td>
<td style="text-align: center">
<input type="radio" id=upgrade<?php echo $this->_tpl_vars['i']; ?>
 name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[languageAction][".($this->_tpl_vars['language'])."]"), $this);?>
" value='upgrade'
<?php if (empty ( $this->_tpl_vars['languageData']['upgrade'] )): ?>disabled="disabled" <?php endif; ?>
/>
</td>
<td style="text-align: center">
<input type="radio" id=remove<?php echo $this->_tpl_vars['i']; ?>
 name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[languageAction][".($this->_tpl_vars['language'])."]"), $this);?>
" value='remove'
<?php if (empty ( $this->_tpl_vars['languageData']['installed'] )): ?>disabled="disabled" <?php endif; ?>
/>
</td>
<td style="text-align: center">
<input type="radio" id=download<?php echo $this->_tpl_vars['i']; ?>
 name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[languageAction][".($this->_tpl_vars['language'])."]"), $this);?>
" value='download'
<?php if (! empty ( $this->_tpl_vars['languageData']['installed'] )): ?>disabled="disabled" <?php endif; ?>
/>
</td>
<td style="text-align: center">
<input type="radio" id=reset<?php echo $this->_tpl_vars['i']; ?>
 name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[languageAction][".($this->_tpl_vars['language'])."]"), $this);?>
" value='reset' checked='checked' />
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<tr class="<?php echo smarty_function_cycle(array('values' => "gbOdd, gbEven"), $this);?>
">
<td>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Select All'), $this);?>

</td>
<td style="text-align: center">
<input type="radio" id=selectAllUpgrade2 onclick="toggleAll('selectAllUpgrade2', 'selectAllUpgrade1', 'upgrade', <?php echo $this->_tpl_vars['languageCount']; ?>
)" 
<?php if (empty ( $this->_tpl_vars['AdminLanguages']['enableSelectAll']['upgrade'] )): ?>disabled="disabled" <?php endif; ?>
class="selectAll"
/>
</td>
<td style="text-align: center">
<input type="radio" id=selectAllRemove2 onclick="toggleAll('selectAllRemove2', 'selectAllRemove1', 'remove', <?php echo $this->_tpl_vars['languageCount']; ?>
)" 
<?php if (empty ( $this->_tpl_vars['AdminLanguages']['enableSelectAll']['remove'] )): ?>disabled="disabled" <?php endif; ?>
class="selectAll"
/>
</td>
<td style="text-align: center">
<input type="radio" id=selectAllDownload2 onclick="toggleAll('selectAllDownload2', 'selectAllDownload1', 'download', <?php echo $this->_tpl_vars['languageCount']; ?>
)" 
<?php if (empty ( $this->_tpl_vars['AdminLanguages']['enableSelectAll']['download'] )): ?>disabled="disabled" <?php endif; ?>
class="selectAll"
/>
</td>
<td style="text-align: center">
&nbsp;
</td>
</tr>
</table>
</div>
<div class="gbBlock gcBackground1">
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[save]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Save'), $this);?>
"/>
</div>
<?php else: ?>
<div class="giWarning">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'There are no local repository indices from which to determine language packages. Please click on the link below to go to "Download Plugin List" and choose "Update Plugin List" to get the latest language package information.'), $this);?>
<br />
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminRepository"), $this);?>
"><?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Administer Repositories'), $this);?>
</a>
</div>
<?php endif; ?> </div>
<?php endif; ?> 