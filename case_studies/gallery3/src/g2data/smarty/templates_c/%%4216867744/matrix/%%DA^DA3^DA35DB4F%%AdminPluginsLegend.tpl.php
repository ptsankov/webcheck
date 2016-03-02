<?php /* Smarty version 2.6.20, created on 2015-10-30 03:07:14
         compiled from gallery:modules/core/templates/AdminPluginsLegend.tpl */ ?>
<div class="AdminPlugins_legend">
<span id="AdminPlugins_legend_active_msg_<?php echo $this->_tpl_vars['legendId']; ?>
" class="icon-plugin-active"
style="margin-right: 10px; vertical-align: top; display: none">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'up to date'), $this);?>

</span>
<span id="AdminPlugins_legend_inactive_msg_<?php echo $this->_tpl_vars['legendId']; ?>
" class="icon-plugin-inactive"
style="margin-right: 10px; vertical-align: top; display: none">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'disabled'), $this);?>

</span>
<span id="AdminPlugins_legend_unupgraded_msg_<?php echo $this->_tpl_vars['legendId']; ?>
" class="icon-plugin-upgrade"
style="margin-right: 10px; vertical-align: top; display: none">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'upgrade required'), $this);?>

</span>
<span id="AdminPlugins_legend_uninstalled_msg_<?php echo $this->_tpl_vars['legendId']; ?>
" class="icon-plugin-uninstall"
style="margin-right: 10px; vertical-align: top; display: none">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'not installed'), $this);?>

</span>
<span id="AdminPlugins_legend_incompatible_msg_<?php echo $this->_tpl_vars['legendId']; ?>
" class="icon-plugin-incompatible"
style="margin-right: 10px; vertical-align: top; display: none">
<?php echo $this->_reg_objects['g'][0]->text(array('text' => 'incompatible'), $this);?>

</span>
</div>