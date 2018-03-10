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
        <th width=40  align="left"><?=lang('id')?></th>
        <th align="left"><?=lang('title')?></th>
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
		<td>组别名称</td>
		<td>
          <input type="text" name="name" size="90" max="90" id="name" class="validate input-text"  style="color:<?=isset($view['color'])?$view['color']:'';?>;" validtip="required" value="<?=isset($view['name'])?$view['name']:'';?>">
		</td>
	</tr>
    <tr>
        <td>上级分组</td>
        <td>
            <select name="parent" id="parent" class="validate" validtip="required">
              <option value="0">顶级分组</option>

			  <?php foreach($groups as $group):?>
			  <option value="<?=$group['id']?>" <?php if(isset($view['parent'])&&$group['id']==$view['parent']):?>selected<?php endif;?>><?=(str_repeat('&nbsp;&nbsp;',$group['count']-1)).'|--'.$group['name']?></option>
			  <?php endforeach;?>
			</select>
        </td>
    </tr>
    <tr>
		<td><?=lang('order')?></td>
		<td colspan="2"><input type="text" name="listorder" id="listorder" value="<?php if(isset($view['listorder'])){echo $view['listorder'];}else{echo '99';} ?>" class="input-text" ></td>
    </tr>
	</table>
	</div>
	</form>
<?php endif;?>
