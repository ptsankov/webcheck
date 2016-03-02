<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/keyalbum/templates/KeywordAlbumSiteAdmin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'gallery:modules/keyalbum/templates/KeywordAlbumSiteAdmin.tpl', 29, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Keyword Album Settings'), $this);?>
 </h2>
</div>
<?php if (! empty ( $this->_tpl_vars['status'] ) || ! empty ( $this->_tpl_vars['form']['error'] )): ?>
<div class="gbBlock">
<?php if (isset ( $this->_tpl_vars['status']['saved'] )): ?>
<h2 class="giSuccess">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Settings saved successfully'), $this);?>

</h2>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['form']['error'] )): ?>
<h2 class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "There was a problem processing your request."), $this);?>

</h2>
<?php endif; ?>
</div>
<?php endif; ?>
<div class="gbBlock">
<table class="gbDataTable"><tr>
<td colspan="2"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "Select where to include links in item summary info, usually shown next to thumbnails.  You can also add the Keyword Albums block in theme settings."), $this);?>
 </td>
</tr><tr>
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Keyword Links'), $this);?>
 </td>
<td>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[summaryLinks]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['KeywordAlbumSiteAdmin']['summaryList'],'selected' => $this->_tpl_vars['form']['summaryLinks']), $this);?>

</select>
</td>
</tr><tr>
<td style="vertical-align:top;padding-top:6px"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Split keywords on'), $this);?>
 </td>
<td>
<input type="checkbox" id="splitSemicolon" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[split][semicolon]"), $this);?>
"
<?php if (! empty ( $this->_tpl_vars['form']['split']['semicolon'] )): ?> checked="checked"<?php endif; ?>/>
<label for="splitSemicolon">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Semicolons'), $this);?>

</label>
&nbsp;
<input type="checkbox" id="splitComma" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[split][comma]"), $this);?>
"
<?php if (! empty ( $this->_tpl_vars['form']['split']['comma'] )): ?> checked="checked"<?php endif; ?>/>
<label for="splitComma">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Commas'), $this);?>

</label>
&nbsp;
<input type="checkbox" id="splitSpace" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[split][space]"), $this);?>
"
<?php if (! empty ( $this->_tpl_vars['form']['split']['space'] )): ?> checked="checked"<?php endif; ?>/>
<label for="splitSpace">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Spaces'), $this);?>

</label>
<?php if (isset ( $this->_tpl_vars['form']['error']['split'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Select at least one separator'), $this);?>

</div>
<?php endif; ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Use any of the selected characters to separate multiple keywords in an item's keywords field."), $this);?>

</p>
</td>
</tr><tr>
<td colspan="2"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Display of Keyword Albums'), $this);?>
 </td>
</tr><tr>
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Sort order'), $this);?>
 </td>
<td>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[orderBy]"), $this);?>
" onchange="pickOrder()">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['KeywordAlbumSiteAdmin']['orderByList'],'selected' => $this->_tpl_vars['form']['orderBy']), $this);?>

</select>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[orderDirection]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['KeywordAlbumSiteAdmin']['orderDirectionList'],'selected' => $this->_tpl_vars['form']['orderDirection']), $this);?>

</select>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'with'), $this);?>

<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[presort]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['KeywordAlbumSiteAdmin']['presortList'],'selected' => $this->_tpl_vars['form']['presort']), $this);?>

</select>
<script type="text/javascript">
// <![CDATA[
function pickOrder() {
var list = '<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[orderBy]"), $this);?>
';
var frm = document.getElementById('siteAdminForm');
var index = frm.elements[list].selectedIndex;
list = '<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[orderDirection]"), $this);?>
';
frm.elements[list].disabled = (index <= 1) ?1:0;
list = '<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[presort]"), $this);?>
';
frm.elements[list].disabled = (index <= 1) ?1:0;
}
pickOrder();
// ]]>
</script>
</td>
</tr><tr>
<td style="vertical-align: top; padding-top: 6px"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Description'), $this);?>
 </td>
<td>
<textarea rows="4" cols="60"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[description]"), $this);?>
"><?php echo $this->_tpl_vars['form']['description']; ?>
</textarea>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Text for theme to display with all Keyword Albums."), $this);?>

</p>
</td>
</tr><tr>
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Theme'), $this);?>
 </td>
<td>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[themeId]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['KeywordAlbumSiteAdmin']['themeList'],'selected' => $this->_tpl_vars['form']['themeId']), $this);?>

</select>
</td>
</tr></table>
</div>
<?php ob_start(); ?><?php echo $this->_reg_objects['g'][0]->text(array('text' => "Settings for %s theme in Keyword Albums",'arg1' => $this->_tpl_vars['ThemeSettingsForm']['theme']['name']), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('message', ob_get_contents());ob_end_clean(); ?>
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.ThemeSettingsForm",'class' => 'gbBlock','message' => $this->_tpl_vars['message'],'formId' => 'siteAdminForm'), $this);?>

<div class="gbBlock gcBackground1">
<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[currentThemeId]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['themeId']; ?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][save]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Save'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][reset]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Reset'), $this);?>
"/>
</div>