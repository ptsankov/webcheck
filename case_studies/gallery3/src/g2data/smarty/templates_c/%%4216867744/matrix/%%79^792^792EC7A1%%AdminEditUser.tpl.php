<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:42
         compiled from gallery:modules/core/templates/AdminEditUser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'gallery:modules/core/templates/AdminEditUser.tpl', 49, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Edit a user'), $this);?>
 </h2>
</div>
<div class="gbBlock">
<h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Username'), $this);?>

<span class="giSubtitle"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "(required)"), $this);?>
 </span>
</h4>
<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => 'userId'), $this);?>
" value="<?php echo $this->_tpl_vars['AdminEditUser']['user']['id']; ?>
"/>
<input type="text" id="giFormUsername" size="30"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[userName]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['userName']; ?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['userName']['duplicate'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'That username is already in use'), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['userName']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'You must enter a new username'), $this);?>

</div>
<?php endif; ?>
<h4> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Full Name'), $this);?>
 </h4>
<input type="text" size="32"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[fullName]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['fullName']; ?>
"/>
<?php if ($this->_tpl_vars['AdminEditUser']['show']['email']): ?>
<h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "E-mail Address"), $this);?>

<span class="giSubtitle"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "(suggested)"), $this);?>
 </span>
</h4>
<input type="text" size="32" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[email]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['email']; ?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['email']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'You must enter an email address'), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['email']['invalid'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Invalid email address'), $this);?>

</div>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['AdminEditUser']['show']['language']): ?>
<h4> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Language'), $this);?>
 </h4>
<select name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[language]"), $this);?>
">
<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['AdminEditUser']['languageList'],'selected' => $this->_tpl_vars['form']['language']), $this);?>

</select>
<?php endif; ?>
<?php if ($this->_tpl_vars['AdminEditUser']['show']['password']): ?>
<h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Password'), $this);?>

<span class="giSubtitle"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "(required)"), $this);?>
 </span>
</h4>
<input type="password" size="32" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[password1]"), $this);?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['password1']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'You must enter a password'), $this);?>

</div>
<?php endif; ?>
<h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Verify Password'), $this);?>

<span class="giSubtitle"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "(required)"), $this);?>
 </span>
</h4>
<input type="password" size="32" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[password2]"), $this);?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['password2']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'You must enter the password a second time'), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['password2']['mismatch'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'The passwords you entered did not match'), $this);?>

</div>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['AdminEditUser']['show']['locked'] || $this->_tpl_vars['AdminEditUser']['failedLoginCount']): ?>
<h4> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Options'), $this);?>
 </h4>
<?php if ($this->_tpl_vars['AdminEditUser']['show']['locked']): ?>
<p>
<input id="AdminEditUser_lockUser" type="checkbox" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[locked]"), $this);?>
" <?php if ($this->_tpl_vars['form']['locked']): ?>checked="checked"<?php endif; ?>>
<label for="AdminEditUser_lockUser">
<b><?php echo $this->_reg_objects['g'][0]->text(array('text' => "Lock user."), $this);?>
</b>
<span class="giInfo"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "Locked users are unable to edit their own account information. (Password, Name, Email, etc.)"), $this);?>
</span>
</label>
</p>
<?php endif; ?>
<?php if ($this->_tpl_vars['AdminEditUser']['failedLoginCount']): ?>
<p>
<input id="AdminEditUser_failedLoginAttempts" type="checkbox" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][resetFailedLogins]"), $this);?>
">
<label for="AdminEditUser_failedLoginAttempts">
<b><?php echo $this->_reg_objects['g'][0]->text(array('text' => "Reset failed login count."), $this);?>
</b>
<span class="giWarning">
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "%d failed login attempt since the last successful login.",'many' => "%d failed login attempts since the last successful login.",'count' => $this->_tpl_vars['AdminEditUser']['failedLoginCount'],'arg1' => $this->_tpl_vars['AdminEditUser']['failedLoginCount']), $this);?>

</span>
</label>
</p>
<?php endif; ?>
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