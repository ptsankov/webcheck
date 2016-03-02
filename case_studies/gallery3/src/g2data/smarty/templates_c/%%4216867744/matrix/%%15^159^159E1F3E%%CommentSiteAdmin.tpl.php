<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/comment/templates/CommentSiteAdmin.tpl */ ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Comments'), $this);?>
 </h2>
</div>
<?php if (! empty ( $this->_tpl_vars['status'] )): ?>
<div class="gbBlock"><h2 class="giSuccess">
<?php if (! empty ( $this->_tpl_vars['status']['saved'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Settings saved successfully'), $this);?>

<?php else: ?>
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "Checked %d comment.",'many' => "Checked %d comments.",'count' => $this->_tpl_vars['status']['checked']['total'],'arg1' => $this->_tpl_vars['status']['checked']['total']), $this);?>

<?php echo $this->_reg_objects['g'][0]->text(array('one' => "Found %d spam comment.",'many' => "Found %d spam comments.",'count' => $this->_tpl_vars['status']['checked']['spamCount'],'arg1' => $this->_tpl_vars['status']['checked']['spamCount']), $this);?>

<?php endif; ?>
</h2></div>
<?php endif; ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'General Settings'), $this);?>
 </h3>
<table class="gbDataTable"><tr>
<td>
<label for="cbLatest">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Show link for Latest Comments:"), $this);?>

</label>
</td><td>
<input type="checkbox" id="cbLatest" <?php if ($this->_tpl_vars['form']['latest']): ?>checked="checked" <?php endif; ?>
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[latest]"), $this);?>
"/>
</td>
</tr><tr>
<td>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Number of comments on Latest Comments page:"), $this);?>

</td><td>
<input type="text" size="5" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[show]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['show']; ?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['show'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Invalid value'), $this);?>

</div>
<?php endif; ?>
</td>
</tr></table>
</div>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Moderation Settings'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Require administrator approval prior to publishing comments."), $this);?>

</p>
<table class="gbDataTable"><tr>
<td>
<label for="cbModerate">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Moderate all comments:"), $this);?>

</label>
</td><td>
<input type="checkbox" id="cbModerate" <?php if ($this->_tpl_vars['form']['moderate']): ?> checked="checked"<?php endif; ?>
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[moderate]"), $this);?>
"/>
</td>
</tr></table>
</div>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "Anti-Spam Settings"), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You can reduce the amount of spam comments that you receive by using a service called %sAkismet%s.  This service is free for personal use.  In order to use it, you will need to %sregister for an API key%s and enter that key in the box below.",'arg1' => "<a href=\"http://akismet.com\">",'arg2' => "</a>",'arg3' => "<a href=\"http://akismet.com/personal\">",'arg4' => "</a>"), $this);?>

</p>
<table class="gbDataTable"><tr>
<td colspan="2">
<?php if ($this->_tpl_vars['CommentSiteAdmin']['akismetActive']): ?>
<div class="giSuccess">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Akismet is active."), $this);?>

</div>
<?php else: ?>
<div class="giWarning">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Akismet is not active."), $this);?>

</div>
<?php endif; ?>
</td>
</tr><tr>
<td>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "API key:"), $this);?>

</td><td>
<input type="text" size="15" maxlength="12" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[apiKey]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['apiKey']; ?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['apiKey']['invalid'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Invalid API key."), $this);?>

</div>
<?php endif; ?>
</td>
</tr></table>
<?php if ($this->_tpl_vars['CommentSiteAdmin']['akismetActive']): ?>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][checkAllWithAkismet]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Check all comments now'), $this);?>
"/>
<?php endif; ?>
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
</div>