<?php /* Smarty version 2.6.20, created on 2015-10-30 03:06:14
         compiled from themes/matrix/templates/error.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="<?php echo $this->_reg_objects['g'][0]->language(array(), $this);?>
" xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->_reg_objects['g'][0]->head(array(), $this);?>

<?php if (empty ( $this->_tpl_vars['head']['title'] )): ?>
<title><?php echo $this->_reg_objects['g'][0]->text(array('text' => "Error!"), $this);?>
</title>
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_reg_objects['g'][0]->theme(array('url' => "theme.css"), $this);?>
"/>
</head>
<body class="gallery">
<div <?php echo $this->_reg_objects['g'][0]->mainDivAttributes(array(), $this);?>
>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['theme']['errorTemplate'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php echo $this->_reg_objects['g'][0]->debug(array(), $this);?>

</body>
</html>