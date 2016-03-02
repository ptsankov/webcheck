<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:10
         compiled from gallery:modules/comment/templates/ShowAllComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'gallery:modules/comment/templates/ShowAllComments.tpl', 35, false),array('modifier', 'markup', 'gallery:modules/comment/templates/ShowAllComments.tpl', 35, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/comment/templates/ChangeComment.js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Latest Comments'), $this);?>
 </h2>
</div>
<?php if (! empty ( $this->_tpl_vars['status'] )): ?>
<div class="gbBlock"><h2 class="giSuccess">
<?php if (isset ( $this->_tpl_vars['status']['changed'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Comment changed successfully'), $this);?>

<?php endif; ?>
</h2></div>
<?php endif; ?>
<?php if (empty ( $this->_tpl_vars['ShowAllComments']['comments'] )): ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'There are no comments for this item'), $this);?>
 </h3>
</div>
<?php else: ?>
<?php if ($this->_tpl_vars['ShowAllComments']['navigator']['pageCount'] > 1): ?>
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.Navigator",'class' => 'commentNavigator','navigator' => $this->_tpl_vars['ShowAllComments']['navigator'],'currentPage' => $this->_tpl_vars['ShowAllComments']['navigator']['page'],'totalPages' => $this->_tpl_vars['ShowAllComments']['navigator']['pageCount']), $this);?>

<?php endif; ?>
<table>
<?php $_from = $this->_tpl_vars['ShowAllComments']['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
<tr id="comment-<?php echo $this->_tpl_vars['comment']['randomId']; ?>
"><td style="text-align: center; padding: 0 4px">
<?php $this->assign('item', $this->_tpl_vars['ShowAllComments']['itemData'][$this->_tpl_vars['comment']['parentId']]); ?>
<a id="CommentThumb-<?php echo $this->_tpl_vars['item']['id']; ?>
" href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.ShowItem",'arg2' => "itemId=".($this->_tpl_vars['item']['id'])), $this);?>
">
<?php if (isset ( $this->_tpl_vars['item']['thumb'] )): ?>
<?php echo $this->_reg_objects['g'][0]->image(array('item' => $this->_tpl_vars['item'],'image' => $this->_tpl_vars['item']['thumb'],'maxSize' => 120), $this);?>

<?php else: ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['item']['pathComponent']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['item']['pathComponent'])))) ? $this->_run_mod_handler('markup', true, $_tmp) : smarty_modifier_markup($_tmp)); ?>

<?php endif; ?>
</a>
<script type="text/javascript">
//<![CDATA[
<?php if (isset ( $this->_tpl_vars['item']['resize'] )): ?>
new YAHOO.widget.Tooltip("gTooltip", {
context: "CommentThumb-<?php echo $this->_tpl_vars['item']['id']; ?>
", text: '<?php echo $this->_reg_objects['g'][0]->image(array('item' => $this->_tpl_vars['item'],'image' => $this->_tpl_vars['item']['resize'],'maxSize' => 500,'alt' => "",'longdesc' => ""), $this);?>
', showDelay: 250 });
<?php elseif (isset ( $this->_tpl_vars['item']['thumb'] )): ?>
new YAHOO.widget.Tooltip("gTooltip", {
context: "CommentThumb-<?php echo $this->_tpl_vars['item']['id']; ?>
", text: '<?php echo $this->_reg_objects['g'][0]->image(array('item' => $this->_tpl_vars['item'],'image' => $this->_tpl_vars['item']['thumb'],'alt' => "",'longdesc' => ""), $this);?>
', showDelay: 250 });
<?php endif; ?>
//]]>
</script>
</td><td>
<div class="one-comment gcBorder2">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gallery:modules/comment/templates/Comment.tpl", 'smarty_include_vars' => array('comment' => $this->_tpl_vars['comment'],'can' => $this->_tpl_vars['ShowAllComments']['can'][$this->_tpl_vars['comment']['id']],'item' => $this->_tpl_vars['item'],'user' => $this->_tpl_vars['ShowAllComments']['commenters'][$this->_tpl_vars['comment']['commenterId']],'ajaxChangeCallback' => 'changeComment','truncate' => 1024)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>