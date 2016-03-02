<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:10
         compiled from gallery:modules/comment/templates/AddComment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'markup', 'gallery:modules/comment/templates/AddComment.tpl', 12, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Add Comment'), $this);?>
 </h2>
</div>
<?php if (isset ( $this->_tpl_vars['form']['action']['preview'] )): ?>
<div class="gcBorder2" style="padding: 0.7em;">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Comment Preview'), $this);?>
 </h3>
<div class="one-comment gcBorder2">
<h3> <?php echo ((is_array($_tmp=$this->_tpl_vars['form']['subject'])) ? $this->_run_mod_handler('markup', true, $_tmp) : smarty_modifier_markup($_tmp)); ?>
 </h3>
<p class="comment">
<?php echo ((is_array($_tmp=$this->_tpl_vars['form']['comment'])) ? $this->_run_mod_handler('markup', true, $_tmp) : smarty_modifier_markup($_tmp)); ?>

</p>
</div>
</div>
<?php endif; ?>
<form action="<?php echo $this->_reg_objects['g'][0]->url(array(), $this);?>
" method="post" enctype="application/x-www-form-urlencoded"
id="addCommentForm">
<div>
<?php echo $this->_reg_objects['g'][0]->hiddenFormVars(array(), $this);?>

<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => 'controller'), $this);?>
" value="comment.AddComment"/>
<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[formName]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['formName']; ?>
"/>
<input type="hidden" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => 'itemId'), $this);?>
" value="<?php echo $this->_tpl_vars['AddComment']['itemId']; ?>
"/>
</div>
<div class="gbBlock">
<?php if ($this->_tpl_vars['user']['isGuest']): ?>
<h4> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Name'), $this);?>
 </h4>
<input type="text" id="author" size="60" class="gcBackground1"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[author]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['author']; ?>
"
onfocus="this.className=''" onblur="this.className='gcBackground1'"/>
<?php else: ?>
<h4> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Posted by'), $this);?>
 </h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "%s (%s)",'arg1' => $this->_tpl_vars['user']['fullName'],'arg2' => $this->_tpl_vars['AddComment']['host']), $this);?>

<?php endif; ?>
<h4> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Subject'), $this);?>
 </h4>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/core/templates/MarkupBar.tpl", 'smarty_include_vars' => array('viewL10domain' => 'modules_core','element' => 'subject','firstMarkupBar' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<input type="text" id="subject" size="60" class="gcBackground1"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[subject]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['subject']; ?>
"
onfocus="this.className=''" onblur="this.className='gcBackground1'"/>
<?php if (empty ( $this->_tpl_vars['inBlock'] )): ?>
<script type="text/javascript">
document.getElementById('addCommentForm')['<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[subject]"), $this);?>
'].focus();
</script>
<?php endif; ?>
<h4>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Comment'), $this);?>

<span class="giSubtitle"> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "(required)"), $this);?>
 </span>
</h4>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/core/templates/MarkupBar.tpl", 'smarty_include_vars' => array('viewL10domain' => 'modules_core','element' => 'comment')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<textarea rows="15" cols="60" id="comment" class="gcBackground1"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[comment]"), $this);?>
"
onfocus="this.className=''" onblur="this.className='gcBackground1'"><?php echo $this->_tpl_vars['form']['comment']; ?>
</textarea>
<?php if (isset ( $this->_tpl_vars['form']['error']['comment']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You must enter a comment!"), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['comment']['flood'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Please wait a little longer before posting another comment'), $this);?>

</div>
<?php endif; ?>
</div>
<?php $_from = $this->_tpl_vars['AddComment']['plugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['plugin']):
?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:".($this->_tpl_vars['plugin']['file']), 'smarty_include_vars' => array('l10Domain' => $this->_tpl_vars['plugin']['l10Domain'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endforeach; endif; unset($_from); ?>
<div class="gbBlock gcBackground1">
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][preview]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Preview'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][add]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Save'), $this);?>
"/>
<?php if (empty ( $this->_tpl_vars['inBlock'] )): ?>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][cancel]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Cancel'), $this);?>
"/>
<?php endif; ?>
</div>
</form>