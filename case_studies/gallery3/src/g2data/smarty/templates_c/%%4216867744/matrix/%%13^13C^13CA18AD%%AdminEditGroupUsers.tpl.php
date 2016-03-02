<?php /* Smarty version 2.6.20, created on 2015-10-30 03:09:17
         compiled from gallery:modules/core/templates/AdminEditGroupUsers.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'gallery:modules/core/templates/AdminEditGroupUsers.tpl', 65, false),)), $this); ?>
<div class="gbBlock gcBackground1">
<h2> <?php echo $this->_reg_objects['g'][0]->text(array('text' => "Edit Members of Group '%s'",'arg1' => $this->_tpl_vars['AdminEditGroupUsers']['group']['groupName']), $this);?>
 </h2>
</div>
<div class="gbBlock">
<?php if (! empty ( $this->_tpl_vars['status'] )): ?>
<h3 class="giSuccess">
<?php if (isset ( $this->_tpl_vars['status']['addedUser'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Added user '%s' to group '%s'",'arg1' => $this->_tpl_vars['status']['addedUser'],'arg2' => $this->_tpl_vars['AdminEditGroupUsers']['group']['groupName']), $this);?>

<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['status']['removedUser'] )): ?>
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "Removed user '%s' from group '%s'",'many' => "Removed %s users from group '%s'",'count' => $this->_tpl_vars['status']['removedUsers'],'arg1' => $this->_tpl_vars['status']['removedUser'],'arg2' => $this->_tpl_vars['AdminEditGroupUsers']['group']['groupName']), $this);?>

<?php endif; ?>
</h3>
<?php endif; ?>
<p class="giDescription">
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "This group contains %d user",'many' => "This group contains %d users",'count' => $this->_tpl_vars['AdminEditGroupUsers']['totalUserCount'],'arg1' => $this->_tpl_vars['AdminEditGroupUsers']['totalUserCount']), $this);?>

</p>
</div>
<?php if (! empty ( $this->_tpl_vars['form']['list']['userNames'] )): ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Members'), $this);?>
 </h3>
<?php if (( $this->_tpl_vars['form']['list']['maxPages'] > 1 )): ?>
<div style="margin-bottom: 10px"><span class="gcBackground1" style="padding: 5px">
<input type="hidden"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[list][page]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['list']['page']; ?>
"/>
<input type="hidden"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[list][maxPages]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['list']['maxPages']; ?>
"/>
<?php if (( $this->_tpl_vars['form']['list']['page'] > 1 )): ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminEditGroupUsers",'arg3' => "form[list][page]=1",'arg4' => "groupId=".($this->_tpl_vars['AdminEditGroupUsers']['group']['id'])), $this);?>
"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "&laquo; first"), $this);?>
</a>
&nbsp;
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminEditGroupUsers",'arg3' => "form[list][page]=".($this->_tpl_vars['form']['list']['backPage']),'arg4' => "groupId=".($this->_tpl_vars['AdminEditGroupUsers']['group']['id'])), $this);?>
"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "&laquo; back"), $this);?>
</a>
<?php endif; ?>
&nbsp;
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Viewing page %d of %d",'arg1' => $this->_tpl_vars['form']['list']['page'],'arg2' => $this->_tpl_vars['form']['list']['maxPages']), $this);?>

&nbsp;
<?php if (( $this->_tpl_vars['form']['list']['page'] < $this->_tpl_vars['form']['list']['maxPages'] )): ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminEditGroupUsers",'arg3' => "form[list][page]=".($this->_tpl_vars['form']['list']['nextPage']),'arg4' => "groupId=".($this->_tpl_vars['AdminEditGroupUsers']['group']['id'])), $this);?>
"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "next &raquo;"), $this);?>
</a>
&nbsp;
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SiteAdmin",'arg2' => "subView=core.AdminEditGroupUsers",'arg3' => "form[list][page]=".($this->_tpl_vars['form']['list']['maxPages']),'arg4' => "groupId=".($this->_tpl_vars['AdminEditGroupUsers']['group']['id'])), $this);?>
"><?php echo $this->_reg_objects['g'][0]->text(array('text' => "last &raquo;"), $this);?>
</a>
<?php endif; ?>
</span></div>
<?php endif; ?>
<table class="gbDataTable">
<tr>
<th> </th>
<th> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Username'), $this);?>
 </th>
</tr>
<?php $_from = $this->_tpl_vars['form']['list']['userNames']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['userId'] => $this->_tpl_vars['user']):
?>
<tr class="<?php echo smarty_function_cycle(array('values' => "gbEven,gbOdd"), $this);?>
">
<td>
<?php if (( $this->_tpl_vars['user']['can']['remove'] )): ?>
<input type="checkbox" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[userIds][".($this->_tpl_vars['userId'])."]"), $this);?>
"/>
<?php endif; ?>
</td>
<td>
<?php echo $this->_tpl_vars['user']['userName']; ?>

</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_reg_objects['g'][0]->defaultButton(array('name' => "form[action][add]"), $this);?>

<?php if (! empty ( $this->_tpl_vars['form']['list']['filter'] ) || ( $this->_tpl_vars['form']['list']['maxPages'] > 1 )): ?>
<input type="text"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[list][filter]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['list']['filter']; ?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][filterBySubstring]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Filter'), $this);?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][filterClear]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Clear'), $this);?>
"/>
<?php endif; ?>
<?php if (( ! empty ( $this->_tpl_vars['form']['list']['filter'] ) )): ?>
<span style="white-space: nowrap">
&nbsp;
<?php echo $this->_reg_objects['g'][0]->text(array('one' => "%d user matches your filter",'many' => "%d users match your filter",'count' => $this->_tpl_vars['form']['list']['count'],'arg1' => $this->_tpl_vars['form']['list']['count']), $this);?>

</span>
<?php endif; ?>
<?php if ($this->_tpl_vars['AdminEditGroupUsers']['canRemove']): ?>
<div>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][remove]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Remove selected'), $this);?>
"/>
</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['list']['noUserSelected'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You must select a user to remove."), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['list']['cantRemoveSelf'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You can't remove yourself from this group."), $this);?>

</div>
<?php endif; ?>
</div>
<?php endif; ?>
<div class="gbBlock">
<h3> <?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Add Member'), $this);?>
 </h3>
<input type="text" id="giFormUsername"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[text][userName]"), $this);?>
" value="<?php echo $this->_tpl_vars['form']['text']['userName']; ?>
"/>
<?php $this->_tag_stack[] = array('autoComplete', array('element' => 'giFormUsername'), $this); $_block_repeat=true; $this->_reg_objects['g'][0]->autoComplete($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat); while ($_block_repeat) { ob_start();?>
<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.SimpleCallback",'arg2' => "command=lookupUsername",'arg3' => "prefix=__VALUE__",'htmlEntities' => false), $this);?>

<?php $_obj_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_reg_objects['g'][0]->autoComplete($this->_tag_stack[count($this->_tag_stack)-1][1], $_obj_block_content, $this, $_block_repeat);} array_pop($this->_tag_stack);?>

<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][add]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Add'), $this);?>
"/>
<?php if (isset ( $this->_tpl_vars['form']['error']['text']['userName']['missing'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "You must enter a username."), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['text']['userName']['invalid'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "User '%s' does not exist.",'arg1' => $this->_tpl_vars['form']['text']['userName']), $this);?>

</div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['form']['error']['text']['userName']['alreadyInGroup'] )): ?>
<div class="giError">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "This user already is in this group."), $this);?>

</div>
<?php endif; ?>
</div>
<div class="gbBlock gcBackground1">
<input type="hidden"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => 'groupId'), $this);?>
" value="<?php echo $this->_tpl_vars['AdminEditGroupUsers']['group']['id']; ?>
"/>
<input type="submit" class="inputTypeSubmit"
name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => "form[action][done]"), $this);?>
" value="<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'Done'), $this);?>
"/>
</div>