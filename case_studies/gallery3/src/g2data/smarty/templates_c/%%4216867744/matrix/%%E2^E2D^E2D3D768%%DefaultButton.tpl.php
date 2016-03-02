<?php /* Smarty version 2.6.20, created on 2015-10-30 03:09:17
         compiled from gallery:modules/core/templates/DefaultButton.tpl */ ?>
<?php $this->assign('buttonId', "defaultSubmitBtn".($this->_tpl_vars['callCount'])); ?>
<input type="submit" name="<?php echo $this->_reg_objects['g'][0]->formVar(array('var' => $this->_tpl_vars['name']), $this);?>
" value="" id="<?php echo $this->_tpl_vars['buttonId']; ?>
" tabindex="-1"
style="background-color: transparent !important; border-style:none; position:absolute; width:0; right:0"/>
<script type="text/javascript">
// <![CDATA[
var a = navigator.userAgent.toLowerCase(), b = document.getElementById('<?php echo $this->_tpl_vars['buttonId']; ?>
');
if (a.indexOf('msie') < 0 || a.indexOf('opera') >= 0) b.style.display = 'none';
// ]]>
</script>
<input type="text" name="stupidIE" value="" style="display: none"/>