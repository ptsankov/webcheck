<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/rating/templates/RatingSiteAdmin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'gallery:modules/rating/templates/RatingSiteAdmin.tpl', 61, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Rating Settings'), $this);?>
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
<td style="text-align:right">
<input type="checkbox" id="allowAlbumRating"
<?php if ($this->_tpl_vars['form']['allowAlbumRating']): ?> checked="checked" <?php endif; ?>
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[allowAlbumRating]"), $this);?>
"/>
</td><td>
<label for="allowAlbumRating">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Allow users to rate entire albums, in addition to individual items."), $this);?>

</label>
</td>
</tr><tr>
<td colspan="2">
<?php ob_start(); ?><a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=rating.RatingAlbum",'arg2' => "limit=3.5"), $this);?>
"><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('link', ob_get_contents());ob_end_clean(); ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "The settings below apply to the %sRating Album%s view, which shows highly rated items from across the Gallery.",'arg1' => $this->_tpl_vars['link'],'arg2' => "</a>"), $this);?>

</td>
</tr><tr>
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Query limit'), $this);?>
 </td>
<td>
<input type="text" id="minLimit" size="8"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[minLimit]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['minLimit']; ?>
"/>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Lowest value allowed for rating album threshold'), $this);?>
 <br/>
<?php if (isset ( $this->_tpl_vars['form']['error']['minLimit'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Invalid number'), $this);?>

</div>
<?php endif; ?>
</td>
</tr><tr>
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Description'), $this);?>
 </td>
<td>
<textarea rows="4" cols="60"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[description]"), $this);?>
"><?php echo $this->_tpl_vars['form']['description']; ?>
</textarea>
</td>
</tr><tr>
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Sort order'), $this);?>
 </td>
<td>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[orderBy]"), $this);?>
" onchange="pickOrder()">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['RatingSiteAdmin']['orderByList'],'selected' => $this->_tpl_vars['form']['orderBy']), $this);?>

</select>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[orderDirection]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['RatingSiteAdmin']['orderDirectionList'],'selected' => $this->_tpl_vars['form']['orderDirection']), $this);?>

</select>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'with'), $this);?>

<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[presort]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['RatingSiteAdmin']['presortList'],'selected' => $this->_tpl_vars['form']['presort']), $this);?>

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
<td> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Theme'), $this);?>
 </td>
<td>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[themeId]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['RatingSiteAdmin']['themeList'],'selected' => $this->_tpl_vars['form']['themeId']), $this);?>

</select>
</td>
</tr></table>
</div>
<?php ob_start(); ?><?php echo $this->_reg_objects['g'][0]->text(array('text' => "Settings for %s theme in Rating Album",'arg1' => $this->_tpl_vars['ThemeSettingsForm']['theme']['name']), $this);?>
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