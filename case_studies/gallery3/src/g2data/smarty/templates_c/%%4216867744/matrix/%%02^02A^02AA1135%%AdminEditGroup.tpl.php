<?php /* Smarty version 2.6.20, created on 2015-10-30 03:09:17
         compiled from gallery:modules/core/templates/AdminEditGroup.tpl */ ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Edit a group'), $this);?>
 </h2>
</div>
<div class="gbBlock">
<h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Group Name'), $this);?>

<span class="giSubtitle"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "(required)"), $this);?>
 </span>
</h4>
<input type="text" id="giFormGroupname"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[groupName]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['groupName']; ?>
"/>
<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => 'groupId'), $this);?>
" value="<?php echo $this->_tpl_vars['AdminEditGroup']['group']['id']; ?>
"/>
<script type="text/javascript">
document.getElementById('siteAdminForm')['<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[groupName]"), $this);?>
'].focus();
</script>
<?php if (isset ( $this->_tpl_vars['form']['error']['groupName']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'You must enter a group name'), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['groupName']['exists'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Group '%s' already exists",'arg1' => $this->_tpl_vars['form']['groupName']), $this);?>

</div>
<?php endif; ?>
</div>
<div class="gbBlock gcBackground1">
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][save]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Save'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][undo]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Reset'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][cancel]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Cancel'), $this);?>
"/>
</div>