<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/icons/templates/IconsSiteAdmin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'gallery:modules/icons/templates/IconsSiteAdmin.tpl', 23, false),array('modifier', 'replace', 'gallery:modules/icons/templates/IconsSiteAdmin.tpl', 52, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Icon Settings'), $this);?>
 </h2>
</div>
<?php if (isset ( $this->_tpl_vars['status']['saved'] )): ?>
<div class="gbBlock"><h2 class="giSuccess">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Settings saved successfully'), $this);?>

</h2></div>
<?php endif; ?>
<div class="gbBlock">
<?php if (empty ( $this->_tpl_vars['IconsSiteAdmin']['iconpacks'] )): ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "No icon packs are available."), $this);?>

</p>
<?php else: ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Select an icon pack to use for this Gallery."), $this);?>

</p><p>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[iconpack]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['IconsSiteAdmin']['iconpacks'],'selected' => $this->_tpl_vars['form']['iconpack']), $this);?>

</select>
</p>
</div>
<div class="gbBlock gcBackground1">
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][save]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Save'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][reset]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Reset'), $this);?>
"/>
<?php endif; ?>
</div>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Icon Pack Browser'), $this);?>
 </h2>
</div>
<div class="gbBlock">
<table class="gbDataTable">
<tr>
<th>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Link ID'), $this);?>

</th>
<?php $_from = $this->_tpl_vars['IconsSiteAdmin']['packs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dir'] => $this->_tpl_vars['pack']):
?>
<th>
<?php echo $this->_tpl_vars['pack']['name']; ?>

</th>
<?php endforeach; endif; unset($_from); ?>
</tr>
<?php $_from = $this->_tpl_vars['IconsSiteAdmin']['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class'] => $this->_tpl_vars['ignored']):
?>
<tr>
<td>
<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['class'])) ? $this->_run_mod_handler('replace', true, $_tmp, '_', ".") : smarty_modifier_replace($_tmp, '_', ".")))) ? $this->_run_mod_handler('replace', true, $_tmp, "-", ' ') : smarty_modifier_replace($_tmp, "-", ' ')); ?>

</td>
<?php $_from = $this->_tpl_vars['IconsSiteAdmin']['packs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dir'] => $this->_tpl_vars['pack']):
?>
<td>
<?php if (isset ( $this->_tpl_vars['pack']['map'][$this->_tpl_vars['class']] )): ?>
<img src="<?php echo $this->_reg_objects['g'][0]->url(array('href' => "modules/icons/iconpacks/".($this->_tpl_vars['dir'])."/".($this->_tpl_vars['pack']['map'][$this->_tpl_vars['class']])), $this);?>
"/>
<?php endif; ?>
</td>
<?php endforeach; endif; unset($_from); ?>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</div>