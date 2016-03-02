<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:29
         compiled from gallery:modules/core/templates/ItemEditRotateAndScalePhoto.tpl */ ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Rotate'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You can only rotate the photo in 90 degree increments."), $this);?>

</p>
<?php if ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['can']['rotate']): ?>
<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => 'mode'), $this);?>
" value="editPhoto"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][rotate][counterClockwise]"), $this);?>
"
value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => "CC 90&deg;"), $this);?>
"/>
&nbsp;
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][rotate][flip]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => "180&deg;"), $this);?>
"/>
&nbsp;
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][rotate][clockwise]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => "C 90&deg;"), $this);?>
"/>
<?php else: ?>
<b>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "There are no graphics toolkits enabled that support this type of photo, so we cannot rotate it."), $this);?>

<?php if ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['isAdmin']): ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminPlugins"), $this);?>
">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'site admin'), $this);?>

</a>
<?php endif; ?>
</b>
<?php endif; ?>
</div>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Scale'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Shrink or enlarge the original photo.  When Gallery scales a photo, it maintains the same aspect ratio (height to width) of the original photo to avoid distortion.  Your photo will be scaled until it fits inside a bounding box with the size you enter here."), $this);?>

</p>
<?php if ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['can']['resize']): ?>
<?php echo $this->_reg_objects['g'][0]->dimensions(array('formVar' => "form[resize]",'width' => $this->_tpl_vars['form']['resize']['width'],'height' => $this->_tpl_vars['form']['resize']['height']), $this);?>

<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][resize]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Scale'), $this);?>
"/>
<?php else: ?>
<b>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "There are no graphics toolkits enabled that support this type of photo, so we cannot scale it."), $this);?>

<?php if ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['isAdmin']): ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminPlugins"), $this);?>
">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'site admin'), $this);?>

</a>
<?php endif; ?>
</b>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['form']['error']['resize']['size']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'You must enter a size'), $this);?>

</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['form']['error']['resize']['size']['invalid'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You must enter a number (greater than zero)"), $this);?>

</div>
<?php endif; ?>
</div>
<?php $_from = $this->_tpl_vars['ItemEdit']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:".($this->_tpl_vars['option']['file']), 'smarty_include_vars' => array('l10Domain' => $this->_tpl_vars['option']['l10Domain'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['can']['rotate'] || $this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['can']['resize']): ?>
<div class="gbBlock">
<?php if (empty ( $this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['hasPreferredSource'] )): ?>
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Preserve Original'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Gallery does not modify your original photo when rotating and scaling. Instead, it duplicates your photo and works with copies.  This requires a little extra disk space but prevents your original from getting damaged.  Disabling this option will cause any actions (rotating, scaling, etc) to modify the original."), $this);?>

</p>
<?php if ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['isLinked']): ?>
<b>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "This is a link to another photo, so you cannot change the original"), $this);?>

</b>
<?php elseif ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['isLinkedTo']): ?>
<b>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "There are links to this photo, so you cannot change the original"), $this);?>

</b>
<?php elseif ($this->_tpl_vars['ItemEditRotateAndScalePhoto']['editPhoto']['noToolkitSupport']): ?>
<b>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'There is no toolkit support to modify the original so operations may only be applied to the copies'), $this);?>

</b>
<?php else: ?>
<input type="checkbox" id="cbPreserve" <?php if ($this->_tpl_vars['form']['preserveOriginal']): ?>checked="checked" <?php endif; ?>
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[preserveOriginal]"), $this);?>
"/>
<label for="cbPreserve">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Preserve Original Photo'), $this);?>

</label>
<?php endif; ?>
<?php else: ?>
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Modified Photo'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You are using a copy of the original photo that has been scaled or rotated.  The original photo is still available, but is no longer being used.  Any changes you make will be applied to the copy instead."), $this);?>

</p>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][revertToOriginal]"), $this);?>
"
value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Restore original'), $this);?>
"/>
<?php endif; ?>
</div>
<?php endif; ?>