<?php if($tpl=='list'):?>
	<?php $this->load->view('admin_head.php');?>
	<div id="main_head" class="main_head">
	<table class="menu">
	<tr><td>
	<a href="<?=site_aurl($classname)?>" class="current"><?=lang('func_'.$classname)?></a>
    </td></tr>
	</table>
	<table cellSpacing=0 width="100%" class="content_list">
    <thead>
	<tr>
		<th width=30  align="left">
            <input type="checkbox" onclick="checkAll(this)">
        </th>
		<th width=40  align="left"><?=lang('id')?></th>
		<th align="left">举办地名称</th>
        <th width=50  align="left"><?=lang('operate')?></th>
	</tr>
	</thead>
	</table>
	</div>
	<form name="formlist" id="formlist" action="<?=site_aurl($classname)?>" method="post">
	<input type="hidden" name="action" id="action" value="<?=site_aurl($classname)?>">
	<div id="main" class="main">
	<table cellSpacing=0 width="100%" class="content_list">
	<tbody id="content_list"><?php if (isset($liststr)): ?><?=$liststr?><?php endif; ?></tbody>
	</table>
	</div>
	</form>
	<div class="main_foot">
	<table><tr><td>
	<div class="func"><?php if (isset($funcstr)): ?><?=$funcstr?><?php endif; ?></div>
	</td><td align="right">
	<div class="page"><?php if (isset($pagestr)): ?><?=$pagestr?><?php endif; ?></div>
	</td></tr></table>
	</div>
	<?php $this->load->view('admin_foot.php');?>
<?php elseif($tpl=='view'):?>
	<link rel="stylesheet" href="<?=base_url('js/kindeditor/themes/default/default.css')?>" />
	<form name="formview" id="formview" action="" method="post">
	<input type="hidden" name="action" id="action" value="<?=site_aurl($classname)?>">
	<input type="hidden" name="id" value="<?=isset($view['id'])?$view['id']:'';?>">
	<div id="main_view" class="main_view" >
	<table cellSpacing=0 width="100%" class="content_view">
	<tr>
      <td width="100">举办地名称</td>
      <td ><input type="text" name="title" id="title"  size="40" class="validate input-text" validtip="required"  value="<?=isset($view['title'])?$view['title']:'';?>"></td>
	</tr>
	</table>
	</div>
	</form>
<?php endif;?>