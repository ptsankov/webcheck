<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:29
         compiled from gallery:modules/core/templates/ItemMoveSingle.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'markup', 'gallery:modules/core/templates/ItemMoveSingle.tpl', 34, false),array('modifier', 'escape', 'gallery:modules/core/templates/ItemMoveSingle.tpl', 34, false),array('modifier', 'default', 'gallery:modules/core/templates/ItemMoveSingle.tpl', 34, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "Move %s",'arg1' => $this->_tpl_vars['ItemMoveSingle']['itemTypeNames']['0']), $this);?>
 </h2>
</div>
<?php if (isset ( $this->_tpl_vars['status']['moved'] )): ?>
<div class="gbBlock"><h2 class="giSuccess">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Successfully moved'), $this);?>

</h2></div>
<?php endif; ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Destination'), $this);?>
 </h3>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Choose a destination album'), $this);?>

</p>
<div id="gTreeDiv"></div>
<script type="text/javascript">
//<![CDATA[
var tree;
var nodes=[];
var selectedId;
function treeInit() {
tree = new YAHOO.widget.TreeView("gTreeDiv");
nodes[-1] = tree.getRoot();
selectedId = <?php if (empty ( $this->_tpl_vars['form']['destination'] )): ?> <?php echo $this->_tpl_vars['ItemMoveSingle']['albumTree'][0]['data']['id']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['form']['destination']; ?>
 <?php endif; ?>;
<?php $_from = $this->_tpl_vars['ItemMoveSingle']['albumTree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
nodes[<?php echo $this->_tpl_vars['album']['depth']; ?>
] = new YAHOO.widget.TextNode({ id: "<?php echo $this->_tpl_vars['album']['data']['id']; ?>
",
label: "<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['album']['data']['title'])) ? $this->_run_mod_handler('markup', true, $_tmp, 'strip') : smarty_modifier_markup($_tmp, 'strip')))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['album']['data']['pathComponent']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['album']['data']['pathComponent'])); ?>
",
href: "javascript:onLabelClick(<?php echo $this->_tpl_vars['album']['data']['id']; ?>
)" },
nodes[<?php echo $this->_tpl_vars['album']['depth']-1; ?>
], <?php if ($this->_tpl_vars['album']['depth'] == 0): ?>true<?php else: ?>false<?php endif; ?>);
<?php if ($this->_tpl_vars['form']['destination'] == $this->_tpl_vars['album']['data']['id'] && $this->_tpl_vars['album']['depth'] > 0): ?>
nodes[1].expand();
nodes[1].expandAll();
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
tree.draw();
var node = tree.getNodeByProperty("id", selectedId);
node.getLabelEl().setAttribute("class", "ygtvlabelselected");
document.getElementById("<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[destination]"), $this);?>
").value = selectedId;
}
function onLabelClick(id) {
if (selectedId != id) {
var node = tree.getNodeByProperty("id", id);
node.getLabelEl().setAttribute("class", "ygtvlabelselected");
node = tree.getNodeByProperty("id", selectedId);
node.getLabelEl().setAttribute("class", "ygtvlabel");
selectedId = id;
document.getElementById("<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[destination]"), $this);?>
").value = id;
}
}
YAHOO.util.Event.addListener(window, "load", treeInit);
//]]>
</script>
<input type="hidden" id="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[destination]"), $this);?>
" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[destination]"), $this);?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['destination']['empty'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'No destination chosen'), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['destination']['selfMove'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You cannot move an album into its own subtree."), $this);?>

</div>
<?php endif; ?>
</div>
<div class="gbBlock gcBackground1">
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][move]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Move'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][cancel]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Cancel'), $this);?>
"/>
</div>