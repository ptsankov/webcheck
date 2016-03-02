<?php /* Smarty version 2.6.20, created on 2015-10-30 03:06:17
         compiled from gallery:modules/comment/templates/ShowComments.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/comment/templates/ChangeComment.js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'View Comments'), $this);?>
 </h2>
</div>
<?php if (! empty ( $this->_tpl_vars['status'] )): ?>
<div class="gbBlock">
<h2 class="giSuccess">
<?php if (isset ( $this->_tpl_vars['status']['changed'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Comment changed successfully'), $this);?>

<?php endif; ?>
</h2>
</div>
<?php endif; ?>
<?php if (empty ( $this->_tpl_vars['ShowComments']['comments'] )): ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'There are no comments for this item'), $this);?>
 </h3>
</div>
<?php else: ?>
<div class="gbBlock">
<?php $_from = $this->_tpl_vars['ShowComments']['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
<div id="comment-<?php echo $this->_tpl_vars['comment']['randomId']; ?>
" class="one-comment gcBorder2">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/comment/templates/Comment.tpl", 'smarty_include_vars' => array('comment' => $this->_tpl_vars['comment'],'item' => $this->_tpl_vars['ShowComments']['item'],'can' => $this->_tpl_vars['ShowComments']['can'],'user' => $this->_tpl_vars['ShowComments']['commenters'][$this->_tpl_vars['comment']['commenterId']],'ajaxChangeCallback' => 'changeComment','truncate' => 1024)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>