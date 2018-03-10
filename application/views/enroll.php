<?php if($tpl=='list'):?>
	<?php $this->load->view('admin_head.php');?>
	<div id="main_head" class="main_head">
	<form name="formsearch" id="formsearch" action="<?=site_aurl($tablefunc)?>" method="post">
	<table class="menu">
	<tr><td>
	<a href="<?=site_aurl($tablefunc)?>" class="current"><?=lang('func_'.$tablefunc)?></a>

    <input name="begin_time" id="begin_time" type="text" class="input-text" value="<?=$search['begin_time']?>" placeholder="开始日期" readOnly onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
    <input name="end_time" id="end_time" type="text" class="input-text" value="<?=$search['end_time']?>" placeholder="结束日期" readOnly onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>

	<select name="host_id">
        <option value="">举办地</option>

      <?php foreach($hostarr as $host):?>
        <option value="<?=$host['id']?>"<?php if ($search['host_id'] ==$host['id']): ?>selected<?php endif; ?>>
            <?=$host['title']?>
        </option>
      <?php endforeach;?>
	</select>
	<input type="submit" class="btn" value="<?=lang('search')?>"></td></tr>
	</table>
	</form>
	<table cellSpacing=0 width="100%" class="content_list">
    <thead>
	<tr>
		<th width=30  align="left">
            <input type="checkbox" onclick="checkAll(this)">
        </th>
		<th width=40  align="left"><?=lang('id')?></th>
        <th width=50  align="left"><?=lang('order')?></th>
		<th align="left"><?=lang('title')?></th>
        <th width=100 align="left">举办地</th>
		<th width=100 align="left">开始时间</th>
        <th width=100 align="left">结束时间</th>
		<th width=50 align="left"><?=lang('status')?></th>
		<th width=200  align="center"><?=lang('operate')?></th>
	</tr>
	</thead>
	</table>
	</div>
	<form name="formlist" id="formlist" action="<?=site_aurl($tablefunc)?>" method="post">
	<input type="hidden" name="action" id="action" value="<?=site_aurl($tablefunc)?>">
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
    <link rel="stylesheet" href="<?=base_url('css/admin/enroll.css')?>" />

	<form name="formview" id="formview" action="" method="post">
	<input type="hidden" name="action" id="action" value="<?=site_aurl($tablefunc)?>">
	<input type="hidden" name="id" value="<?=isset($view['id'])?$view['id']:'';?>">
	<div id="main_view" class="main_view">
	<table cellSpacing=0 width="100%" class="content_view">
	  <tr>
        <td width="100">报名表名称</td>
        <td>
          <input type="text" name="enroll[title]" id="enroll[title]" size="100" class="validate input-text" validtip="required"  value="<?=isset($view['title'])?$view['title']:'';?>">
        </td>
      </tr>
      <tr>
        <td width="100">举办地</td>
        <td>
          <select name="enroll[host_id]" id="enroll[host_id]" class="validate"  validtip="required">
            <option value="">选择举办地</option>
            <?php foreach($hostarr as $host):?>
            <option value="<?=$host['id']?>"<?php if (isset($view['host_id'])&&$view['host_id'] ==$host['id']): ?>selected<?php endif; ?>><?=$host['title']?></option>
            <?php endforeach;?>
          </select>
        </td>
      </tr>
      <tr>
        <td>起止时间</td>
        <td>
          <input type="text" name="enroll[begin_time]" id="enroll[begin_time]"  readOnly onClick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'});"  class="input-text " value="<?=isset($view['begin_time'])?date('Y-m-d',$view['begin_time']):''?>">
          至
          <input type="text" name="enroll[end_time]" id="enroll[end_time]"  readOnly onClick="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'});"  class="input-text " value="<?=isset($view['end_time'])?date('Y-m-d',$view['end_time']):''?>">
        </td>
      </tr>
      <tr>
        <td width="100">参赛方向</td>
        <td>
          <div class="dxt_box_hover">
            <dl id="direct-box">
            <?php if(!empty($view['directData'])):?>
                <?php foreach($view['directData'] as $val):?>
                <dd class="item-option">
                  <span></span>
                  <select class="validate" name="enroll[direct][]" validtip="required">
                    <option value="">请选择参赛方向</option>
                    <?php foreach($directarr as $direct):?>
                     <option value="<?=$direct['id']?>" <?=($val['id'] == $direct['id'] ?'selected':'')?>><?=$direct['title']?></option>
                    <?php endforeach;?>
                  </select>
                  <span><a href="javascript:;" onclick="delItem(this)">[删除]</a></span>
                </dd>
                <?php endforeach;?>
            <?php else:?>
                <dd class="item-option">
                  <span></span>
                  <select class="validate" name="enroll[direct][]" validtip="required">
                    <option value="">请选择参赛方向</option>
                    <?php foreach($directarr as $direct):?>
                     <option value="<?=$direct['id']?>"><?=$direct['title']?></option>
                    <?php endforeach;?>
                  </select>
                  <span><a href="javascript:;" onclick="delItem(this)">[删除]</a></span>
                </dd>
            <?php endif;?>

                <dd>
                  <font><a href="javascript:;" onclick="lineAdd(this)">[+新增一个参赛方向]</a>
                  </font>
                </dd>
            </dl>
          </div>
        </td>
      </tr>
      <tr>
        <td><?=lang('status')?></td>
		<td>
        <?=lang('status1')?><input type="radio" name="enroll[status]" value="1" <?php if(!isset($view['status'])||$view['status']==1){echo 'checked';} ?> /><?=lang('status0')?><input type="radio" name="enroll[status]" value="0" <?php if(isset($view['status'])&&$view['status']==0){echo 'checked';} ?>  />
        </td>
      </tr>
      <tr>
      	<td><?=lang('order')?></td>
		<td><input type="text" name="enroll[listorder]" id="enroll[listorder]" value="<?php if(isset($view['listorder'])){echo $view['listorder'];}else{echo '999';} ?>" class="input-text"></td>
      </tr>
	</table>

	</div>
	</form>

<script>

    // 获取模板
    function get_tpl()
    {
        var tpl = '<dd class="item-option"><span></span>';
        tpl += '<select class="validate" name="enroll[direct][]" validtip="required">';
        tpl += '<option value="">请选择参赛方向</option>';

        <?php foreach($directarr as $direct){?>
            tpl += '<option value="<?=$direct[id]?>"><?=$direct[title]?></option>';
        <?php }?>

        tpl += '</select>';
        tpl += '<span><a href="javascript:;" onclick="delItem(this)">[删除]</a></span></dd>';

        return $(tpl);
    }

    // 删除
    function delItem(event)
    {
        if(window.confirm('确认删除吗?'))
        {
            var $this = $(event);
            var $item = $this.closest('dd');
            $item.remove();
        }
    }

	/**
	 * 添加一行
	 * @param jQuery trigger
	 * @return boolean
	 */
	function lineAdd(trigger)
    {
        var $this = $(trigger);
        var $lastLine = $this.closest('dd');
        var $newLine = get_tpl();
        $newLine.insertBefore($lastLine);
	}
</script>

<?php endif;?>