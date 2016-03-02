<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:10
         compiled from gallery:themes/matrix/templates/photo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'markup', 'gallery:themes/matrix/templates/photo.tpl', 22, false),)), $this); ?>
<?php if (! empty ( $this->_tpl_vars['theme']['imageViews'] )): ?>
<?php $this->assign('image', $this->_tpl_vars['theme']['imageViews'][$this->_tpl_vars['theme']['imageViewsIndex']]); ?>
<?php endif; ?>
<table width="100%" cellspacing="0" cellpadding="0">
<tr valign="top">
<?php if (! empty ( $this->_tpl_vars['theme']['params']['sidebarBlocks'] )): ?>
<td id="gsSidebarCol">
<?php echo $this->_reg_objects['g'][0]->theme(array('include' => "sidebar.tpl"), $this);?>

</td>
<?php endif; ?>
<td>
<div id="gsContent">
<div class="gbBlock gcBackground1">
<table width="100%">
<tr>
<td>
<?php if (! empty ( $this->_tpl_vars['theme']['item']['title'] )): ?>
<h2> <?php echo ((is_array($_tmp=$this->_tpl_vars['theme']['item']['title'])) ? $this->_run_mod_handler('markup', true, $_tmp) : smarty_modifier_markup($_tmp)); ?>
 </h2>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['theme']['item']['description'] )): ?>
<p class="giDescription">
<?php echo ((is_array($_tmp=$this->_tpl_vars['theme']['item']['description'])) ? $this->_run_mod_handler('markup', true, $_tmp) : smarty_modifier_markup($_tmp)); ?>

</p>
<?php endif; ?>
</td>
<td style="width: 30%">
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.ItemInfo",'item' => $this->_tpl_vars['theme']['item'],'showDate' => true,'showOwner' => $this->_tpl_vars['theme']['params']['showImageOwner'],'class' => 'giInfo'), $this);?>

<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.PhotoSizes",'class' => 'giInfo'), $this);?>

</td>
</tr>
</table>
</div>
<?php if (! empty ( $this->_tpl_vars['theme']['navigator'] )): ?>
<div class="gbBlock gcBackground2 gbNavigator">
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.Navigator",'navigator' => $this->_tpl_vars['theme']['navigator'],'reverseOrder' => true), $this);?>

</div>
<?php endif; ?>
<div id="gsImageView" class="gbBlock">
<?php if (! empty ( $this->_tpl_vars['theme']['imageViews'] )): ?>
<?php ob_start(); ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.DownloadItem",'arg2' => "itemId=".($this->_tpl_vars['theme']['item']['id']),'forceFullUrl' => true,'forceSessionId' => true), $this);?>
">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Download %s",'arg1' => $this->_tpl_vars['theme']['sourceImage']['itemTypeName']['1']), $this);?>

</a>
<?php $this->_smarty_vars['capture']['fallback'] = ob_get_contents(); ob_end_clean(); ?>
<?php if ($this->_tpl_vars['image']['viewInline']): ?>
<?php if (count ( $this->_tpl_vars['theme']['imageViews'] ) > 1): ?>
<?php ob_start(); ?>
<?php if ($this->_tpl_vars['theme']['imageViewsIndex'] == 1 && count ( $this->_tpl_vars['theme']['imageViews'] ) == 2): ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('params' => $this->_tpl_vars['theme']['pageUrl'],'arg1' => "itemId=".($this->_tpl_vars['theme']['item']['id'])), $this);?>
">
<?php else: ?>
<?php $this->assign('imageViewsLink', $this->_tpl_vars['theme']['imageViewsIndex']+1); ?>
<?php if ($this->_tpl_vars['imageViewsLink'] == count ( $this->_tpl_vars['theme']['imageViews'] )): ?>
<?php $this->assign('imageViewsLink', $this->_tpl_vars['theme']['imageViewsIndex']-1); ?>
<?php endif; ?>
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('params' => $this->_tpl_vars['theme']['pageUrl'],'arg1' => "itemId=".($this->_tpl_vars['theme']['item']['id']),'arg2' => "imageViewsIndex=".($this->_tpl_vars['imageViewsLink'])), $this);?>
">
<?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('imageViewLink', ob_get_contents());ob_end_clean(); ?>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['theme']['photoFrame'] )): ?>
<?php $this->_tag_stack[] = array('container', array('type' => "imageframe.ImageFrame",'frame' => $this->_tpl_vars['theme']['photoFrame'],'width' => $this->_tpl_vars['image']['width'],'height' => $this->_tpl_vars['image']['height']), $this); $_block_repeat=true; $this->_reg_objects['g'][0]->container($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat); while ($_block_repeat) { ob_start();?>
<?php if (isset ( $this->_tpl_vars['imageViewLink'] )): ?><?php echo $this->_tpl_vars['imageViewLink']; ?>
<?php endif; ?>
<?php echo $this->_reg_objects['g'][0]->image(array('id' => "%ID%",'item' => $this->_tpl_vars['theme']['item'],'image' => $this->_tpl_vars['image'],'fallback' => $this->_smarty_vars['capture']['fallback'],'class' => "%CLASS%"), $this);?>

<?php if (isset ( $this->_tpl_vars['imageViewLink'] )): ?></a><?php endif; ?>
<?php $_obj_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_reg_objects['g'][0]->container($this->_tag_stack[count($this->_tag_stack)-1][1], $_obj_block_content, $this, $_block_repeat);} array_pop($this->_tag_stack);?>

<?php else: ?>
<?php if (isset ( $this->_tpl_vars['imageViewLink'] )): ?><?php echo $this->_tpl_vars['imageViewLink']; ?>
<?php endif; ?>
<?php echo $this->_reg_objects['g'][0]->image(array('item' => $this->_tpl_vars['theme']['item'],'image' => $this->_tpl_vars['image'],'fallback' => $this->_smarty_vars['capture']['fallback']), $this);?>

<?php if (isset ( $this->_tpl_vars['imageViewLink'] )): ?></a><?php endif; ?>
<?php endif; ?>
<?php else: ?>
<?php echo $this->_smarty_vars['capture']['fallback']; ?>

<?php endif; ?>
<?php else: ?>
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "There is nothing to view for this item."), $this);?>

<?php endif; ?>
</div>
<?php if ($this->_tpl_vars['theme']['pageUrl']['view'] != 'core.ShowItem' && $this->_tpl_vars['theme']['params']['dynamicLinks'] == 'jumplink'): ?>
<div class="gbBlock">
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.ShowItem",'arg2' => "itemId=".($this->_tpl_vars['theme']['item']['id'])), $this);?>
">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'View in original album'), $this);?>

</a>
</div>
<?php endif; ?>
<?php if (! empty ( $this->_tpl_vars['theme']['sourceImage'] ) && $this->_tpl_vars['theme']['sourceImage']['mimeType'] != $this->_tpl_vars['theme']['item']['mimeType']): ?>
<div class="gbBlock">
<a href="<?php echo $this->_reg_objects['g'][0]->url(array('arg1' => "view=core.DownloadItem",'arg2' => "itemId=".($this->_tpl_vars['theme']['item']['id'])), $this);?>
">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => "Download %s in original format",'arg1' => $this->_tpl_vars['theme']['sourceImage']['itemTypeName']['1']), $this);?>

</a>
</div>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['theme']['params']['photoBlocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
<?php echo $this->_reg_objects['g'][0]->block(array('type' => $this->_tpl_vars['block']['0'],'params' => $this->_tpl_vars['block']['1']), $this);?>

<?php endforeach; endif; unset($_from); ?>
<?php if (! empty ( $this->_tpl_vars['theme']['navigator'] )): ?>
<div class="gbBlock gcBackground2 gbNavigator">
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.Navigator",'navigator' => $this->_tpl_vars['theme']['navigator'],'reverseOrder' => true), $this);?>

</div>
<?php endif; ?>
<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.GuestPreview",'class' => 'gbBlock'), $this);?>

<?php echo $this->_reg_objects['g'][0]->block(array('type' => "core.EmergencyEditItemLink",'class' => 'gbBlock','checkBlocks' => "sidebar,photo"), $this);?>

</div>
</td>
</tr>
</table>