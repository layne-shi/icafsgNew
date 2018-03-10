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
		<th align="left">参赛方向名称</th>
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
	<link rel="stylesheet" href="<?=base_url('css/admin/enroll.css')?>" />
	<form name="formview" id="formview" action="" method="post">
	<input type="hidden" name="action" id="action" value="<?=site_aurl($classname)?>">
	<input type="hidden" name="id" value="<?=isset($view['id'])?$view['id']:'';?>">
	<div id="main_view" class="main_view" >
	<table cellSpacing=0 width="100%" class="content_view">
	<tr>
		<td width="80">参赛方向</td>
		<td><input type="text" name="direct[title]" id="direct[title]" class="validate input-text" size="60" validtip="required" value="<?=isset($view['title'])?$view['title']:'';?>">
		</td>
	</tr>
	<tr>
        <td>参赛专业</td>
        <td>
            由用户选择<input onclick="$('#major_tr').show();" type="radio" name="direct[special_type]" value="0" <?php if(!isset($view['special_type'])||$view['special_type']==0){echo 'checked';} ?> />
            由用户填写<input onclick="$('#major_tr').hide();" type="radio" name="direct[special_type]" value="1" <?php if(isset($view['special_type'])&&$view['special_type']==1){echo 'checked';} ?> />
        </td>
	</tr>
    <tr id="major_tr" <?php if(isset($view['special_type'])&&$view['special_type']==1):?>style="display:none;"<?php endif;?>>
        <td>专业列表</td>
        <td>
          <div class="dxt_box_hover">
            <dl id="major_tpl_dl">
            <?php if(!isset($view) || empty($view['majorData'])):?>
				<dd class="item-option">
                 <b><span class="item-option-number">1</span></b><input size="50" maxlength="50" title="参赛专业名称" name="direct[major][]" type="text" class="input-text" value="">
                </dd>
				<dd class="item-option">
                 <b><span class="item-option-number">2</span></b><input size="50" maxlength="50" title="参赛专业名称" name="direct[major][]" type="text" class="input-text" value=""><span><a href="javascript:;" onclick="delItem(this,'major_tpl')">[删除]</a></span>
                </dd>
				<dd class="item-option">
                 <b><span class="item-option-number">3</span></b><input size="50" maxlength="50" title="参赛专业名称" name="direct[major][]" type="text" class="input-text" value=""><span><a href="javascript:;" onclick="delItem(this,'major_tpl')">[删除]</a></span>
                </dd>
				<dd class="item-option">
                 <b><span class="item-option-number">4</span></b><input size="50" maxlength="50" title="参赛专业名称" name="direct[major][]" type="text" class="input-text" value=""><span><a href="javascript:;" onclick="delItem(this,'major_tpl')">[删除]</a></span>
                </dd>
            <?php elseif ($view['majorData']):?>
                <?php foreach($view['majorData'] as $k => $major):?>
				<dd class="item-option">
                 <b><span class="item-option-number"><?=($k+1)?></span></b><input size="50" maxlength="50" title="参赛专业名称" name="direct[major][]" value="<?=$major['title']?>" type="text" class="input-text" value=""><span><a href="javascript:;" onclick="delItem(this,'major_tpl')">[删除]</a></span>
                </dd>
                <?php endforeach;?>
            <?php endif;?>
                <dd>
                  <font><a href="javascript:;" onclick="lineAdd(this,'major_tpl')">[+增加一行]</a>
                  </font>
                </dd>
			</dl>
		  </div>
        </td>
    </tr>
    <tr>
        <td>参赛形式</td>
        <td>
          <div class="dxt_box_hover">
            <dl id="form_tpl_dl">
            <?php if(!isset($view) || empty($view['formData'])):?>
				<dd class="item-option">
                 <b><span class="item-option-number">1</span></b><input size="50" maxlength="50" title="参赛形式名称" name="direct[form][]" type="text" class="input-text"><em><input name="direct[need_input][]" class="need_input" type="checkbox" value="1"/> 要求填写</em>
                </dd>
				<dd class="item-option">
                 <b><span class="item-option-number">2</span></b><input size="50" maxlength="50" title="参赛形式名称" name="direct[form][]" type="text" class="input-text"><em><input name="direct[need_input][]" class="need_input" type="checkbox" value="2"/> 要求填写</em><span><a href="javascript:;" onclick="delItem(this,'form_tpl')">[删除]</a></span>
                </dd>
				<dd class="item-option">
                 <b><span class="item-option-number">3</span></b><input size="50" maxlength="50" title="参赛形式名称" name="direct[form][]" type="text" class="input-text"><em><input name="direct[need_input][]" class="need_input" type="checkbox" value="3"/> 要求填写</em><span><a href="javascript:;" onclick="delItem(this,'form_tpl')">[删除]</a></span>
                </dd>
				<dd class="item-option">
                 <b><span class="item-option-number">4</span></b><input size="50" maxlength="50" title="参赛形式名称" name="direct[form][]" type="text" class="input-text"><em><input name="direct[need_input][]" class="need_input" type="checkbox" value="4"/> 要求填写</em><span><a href="javascript:;" onclick="delItem(this,'form_tpl')">[删除]</a></span>
                </dd>
            <?php elseif ($view['formData']):?>
                <?php foreach($view['formData'] as $key => $form):?>
				<dd class="item-option">
                 <b><span class="item-option-number"><?=($key+1)?></span></b><input size="50" maxlength="50" title="参赛形式名称" name="direct[form][]" value="<?=$form['title']?>" type="text" class="input-text"><em><input name="direct[need_input][]" class="need_input" type="checkbox" <?=($form['need_input'] == 1 ? 'checked' : '')?> value="<?=($key+1)?>"/> 要求填写</em><span><a href="javascript:;" onclick="delItem(this,'form_tpl')">[删除]</a></span>
                </dd>
                <?php endforeach;?>
            <?php endif;?>
                <dd>
                  <font><a href="javascript:;" onclick="lineAdd(this,'form_tpl')">[+增加一行]</a>
                  </font>
                </dd>
			</dl>
		  </div>
        </td>
    </tr>
    <tr>
        <td>参赛组别</td>
        <td>
            启用<input <?php if(!isset($view['enable_group'])||$view['enable_group']==1){echo 'checked';} ?> onclick="$('#group_box').show()" type="radio" name="direct[enable_group]" value="1"/>
            不启用<input <?php if(isset($view['enable_group'])&&$view['enable_group']==0){echo 'checked';} ?> onclick="$('#group_box').hide()" type="radio" name="direct[enable_group]" value="0"/>
            <div id="group_box" class="dxt_box_hover " style="<?php if(isset($view['enable_group'])&&$view['enable_group']==0){echo 'display:none;';} ?>">
              <dl>
              <?php foreach($groups as $group):?>
                <dd>
                 <em><input type="checkbox" value="<?=$group['id']?>" name="direct[group][]" <?=(isset($view['groups'])&&(in_array($group['id'],$view['groups']))?'checked':'')?> ><?=$group['name']?></em>
                </dd>
              <?php endforeach;?>
              </dl>
            </div>
        </td>
    </tr>
    <tr>
        <td>参赛曲目</td>
        <td>
            启用<input <?php if(!isset($view['enable_song'])||$view['enable_song']==1){echo 'checked';} ?> type="radio" name="direct[enable_song]" value="1"/>
            不启用<input <?php if(isset($view['enable_song'])&&$view['enable_song']==0){echo 'checked';} ?> type="radio" name="direct[enable_song]" value="0"/>
        </td>
    </tr>
    <tr>
        <td>指导教师</td>
        <td>
            启用<input  <?php if(!isset($view['enable_guide'])||$view['enable_guide']==1){echo 'checked';} ?> type="radio" name="direct[enable_guide]" value="1"/>
            不启用<input <?php if(isset($view['enable_guide'])&&$view['enable_guide']==0){echo 'checked';} ?> type="radio" name="direct[enable_guide]" value="0"/>
        </td>
    </tr>
    <tr>
        <td>推荐教师</td>
        <td>
            启用<input <?php if(!isset($view['enable_referee'])||$view['enable_referee']==1){echo 'checked';} ?> type="radio" name="direct[enable_referee]" value="1"/>
            不启用<input <?php if(isset($view['enable_referee'])&&$view['enable_referee']==0){echo 'checked';} ?> type="radio" name="direct[enable_referee]" value="0"/>
        </td>
    </tr>
	</table>
	</div>
	</form>
<?php endif;?>

<script>

    // 获取参赛专业模板
    function get_major_tpl()
    {
        // 参赛专业模板
        var major_tpl = '<dd class="item-option">';
        major_tpl += '<b><span class="item-option-number"></span></b>';
        major_tpl += '<input size="50" maxlength="50" title="参赛专业名称" name="direct[major][]" type="text" class="input-text">';
        major_tpl += '<span><a href="javascript:;" onclick="delItem(this,\'major_tpl\')">[删除]</a></span>';
        major_tpl += '</dd>';

        return $(major_tpl);
    }

    // 获取参赛形式模板
    function get_form_tpl()
    {
        // 参赛形式模板
        var form_tpl = '<dd class="item-option">';
        form_tpl += '<b><span class="item-option-number"></span></b>';
        form_tpl += '<input size="50" maxlength="50" title="参赛形式名称" name="direct[form][]" type="text" class="input-text">';
        form_tpl += '<em><input name="direct[need_input][]" type="checkbox" class="need_input"> 要求填写</em>';
        form_tpl += '<span><a href="javascript:;" onclick="delItem(this,\'form_tpl\')">[删除]</a></span>';
        form_tpl += '</dd>';

        return $(form_tpl);
    }

	/**
	 * 更新选项索引
	 * @param jQuery $item
	 * @return void
	 */
	function updateOptionNumber($item)
    {
		$item.find('.item-option').each(function(i, e) {
			$(e).find('.item-option-number').text(i+1);

            if ($(e).find('.need_input'))
            {
                $(e).find('.need_input').val(i+1);
            }
		});
	}

    // 删除
    function delItem(event,tplname)
    {
        if(window.confirm('确认删除吗?'))
        {
            var $this = $(event);
            var $item = $this.closest('dd');
            $item.remove();
            updateOptionNumber($("#"+tplname+"_dl"));
        }
    }

	/**
	 * 添加一行
	 * @param jQuery trigger
	 * @param string 模板
	 * @return boolean
	 */
	function lineAdd(trigger, tplname)
    {
        var $this = $(trigger);
        var $lastLine = $this.closest('dd').prev();
        var tplfunc = 'get_'+tplname;

        if (typeof(eval(tplfunc)) == 'function')
        {
            var $newLine = eval(tplfunc+'();');
            $newLine.insertAfter($lastLine);
            updateOptionNumber($("#"+tplname+"_dl"));
        }
	}
</script>
