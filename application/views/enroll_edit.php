
	<link rel="stylesheet" href="<?=base_url('js/kindeditor/themes/default/default.css')?>" />
	<form name="formview" id="formview" action="" method="post">
	<input type="hidden" name="action" id="action" value="<?=site_aurl($tablefunc)?>">
	<input type="hidden" name="id" value="<?=isset($view['id'])?$view['id']:'';?>">
	<div id="main_view" class="main_view">
	<table cellSpacing=0 width="100%" class="content_view">
	  <tr>
        <td width="100">报名表名称</td>
        <td>
          <input type="text" name="title" id="title" size="100" class="validate input-text" validtip="required"  value="<?=isset($view['title'])?$view['title']:'';?>">
        </td>
      </tr>
      <tr>
        <td>起止时间</td>
        <td>
          <input type="text" name="begin_time" id="begin_time"  readOnly onClick="WdatePicker({doubleCalendar:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})"  class="input-text Wdate" value="<?=isset($view['begin_time'])?date('Y-m-d H:i:s',$view['begin_time']):date('Y-m-d H:i:s')?>">
          至
          <input type="text" name="end_time" id="end_time"  readOnly onClick="WdatePicker({doubleCalendar:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})"  class="input-text Wdate" value="<?=isset($view['end_time'])?date('Y-m-d H:i:s',$view['end_time']):date('Y-m-d H:i:s')?>">
        </td>
      </tr>
      <tr>
        <td width="100">举办地</td>
        <td>
          <span id="host_sel_wrap">
          <select name="host" id="host" class="validate"  validtip="required">
            <option value="">选择举办地</option>
            <?php foreach($hostarr as $host):?>
            <option value="<?=$host['id']?>"<?php if (isset($view['host'])&&$view['host'] ==$host['id']): ?>selected<?php endif; ?>><?=$host['title']?></option>
            <?php endforeach;?>
          </select>
          &nbsp;&nbsp;&nbsp;&nbsp;
          </span>
          <a href="javascript:;" onclick="inputhost();" style="color:#0066FF">
            [手动输入]
          </a>
          <span id="host_input_wrap" style="display:none;">
          &nbsp;&nbsp;
            <input type="text" id="host" name="host" class="validate input-text"  validtip="required"/>
          </span>
        </td>
      </tr>
      <tr>
        <td width="100">参赛方向</td>
        <td>
          <select class="validate"  validtip="required">
            <option value="">选择参赛方向</option>
          </select>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" class="btn" onclick="$('#direct_wrap').toggle()" value="添加">
          <span style="background-color: #eeebeb;">
          选择一个参赛方向后，点击"添加"
          </span>
          <br>
        </td>
      </tr>
      <tr id="direct_wrap" style="display:none;">
        <td colspan="2">
          <div id="direct_content">
          三三四四
          </div>
        </td>
      </tr>
	</table>

<!--
    <div style="margin:10px auto;color:#0066FF;">[+参赛方向]</div>

     <table cellSpacing=0 width="100%" style="margin: 3px 3px 5px;padding: 5px;padding-bottom:10px;border: 1px solid #d8d8d8;" class="content_view">
      <tr>
        <td colspan="2">订单</td>
      </tr>
    </table> -->
	</div>
	</form>

<script>
function inputhost()
{
    var obj1 = $('#host_input_wrap');
    var obj2 = $('#host_sel_wrap');

    if (obj1.is(":hidden"))
    {
        obj2.hide();
        obj2.find("#host").attr("disabled","disabled");
        obj1.show();
        obj1.find("#host").removeAttr("disabled");
    }
    else
    {
        obj2.show();
        obj2.find("#host").removeAttr("disabled");
        obj1.hide();
        obj1.find("#host").attr("disabled","disabled");
    }
}
</script>
