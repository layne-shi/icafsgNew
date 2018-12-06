<?php if($tpl=='list'):?>
	<?php $this->load->view('admin_head.php');?>

    <div id="main_head" class="main_head" style="height:auto;">
    <form name="formsearch" id="formsearch" action="<?=site_aurl($tablefunc.'/details/'.$view['id'])?>" method="post">
      <input type="hidden" name="action" value="search"/>
      <table class="menu">
        <tr>
          <td>
            <?php $ext = mb_strlen($view['title']) > 10 ? '...' : ''?>

            <a href="<?=site_aurl($tablefunc)?>" class="current">
                <?=mb_substr($view['title'],0,10) . $ext?>
            </a>

            <input name="start_time" id="start_time" type="text" class="input-text" value="<?=$search['start_time']?>" placeholder="报名日期" readOnly onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
            <span>至</span>
            <input name="end_time" id="end_time" type="text" class="input-text" value="<?=$search['end_time']?>" placeholder="报名日期" readOnly onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>

            <select name="type" id="type">
            <option value="">人员类型</option>
            <?php foreach($typearr as $key => $type):?>
            <option value="<?=$key?>"<?php if ($search['type']==$key): ?>selected<?php endif; ?>><?=$type?></option>
            <?php endforeach;?>
            </select>

            <input type="submit" class="btn" value="<?=lang('search')?>">
            <a onclick="to_export('search')" href="javascript:;" class="current">
                按条件导出
            </a>
            <a onclick="to_export()" href="javascript:;" class="current">
                导出全部
            </a>
          </td>
        </tr>
      </table>
    </form>
    </div>

    <form name="formlist" id="formlist" action="<?=site_aurl($tablefunc)?>" method="post">
	  <input type="hidden" name="action" id="action" value="<?=site_aurl($tablefunc)?>">
      <div id="main" class="main" style="padding-top:40px;">

        <table cellSpacing=0 class="content_list" style="text-align:center;width:320%;">
          <thead>
          <tr>
<!--             <th width="30" align="left">
                <input type="checkbox" onclick="checkAll(this)">
            </th> -->
            <th width=40>序号</th>
            <th>报名时间</th>
            <th>推荐教师</th>
            <th>姓名</th>
            <th>拼音</th>
            <th>性别</th>
            <th>生日</th>
            <th>年龄</th>
            <th>护照</th>
            <th>性质</th>
            <th>身份證</th>
            <th>陪同人员</th>
            <th>参赛方向</th>
            <th>参赛专业</th>
            <th>参赛形式</th>
            <th>参赛组别</th>
            <th>比赛曲目</th>
            <th>曲作者</th>
            <th>词作者</th>
            <th>指导教师</th>
            <th>国籍</th>
            <th>民族</th>
            <th>手机号</th>
            <th>家庭电话</th>
            <th>邮箱</th>
            <th>其他联系方式</th>
            <th>邮寄地址</th>
            <th>家长姓名</th>
            <th>家长联系方式</th>
            <th>申请教师指导奖</th>
            <th>申请艺术指导奖</th>
            <th>申请编创奖</th>
            <th>学校单位</th>
            <th>名称</th>
            <th>年级或职务</th>
            <th>大学年级</th>
          </tr>
          </thead>
          <tbody id="content_list">
          <?php foreach($data as $k => $item): ?>
          <tr id="<?='tid_'.$item['list_id']?>">
<!--             <td width="30" align="left">
                <input type="checkbox" name="optid[]" value="<?=$item['list_id']?>">
            </td> -->
            <td width=40><?=$k+1?></td>
            <td><?=$item['create_time']?></td>
            <td><?=$item['referee']?></td>
            <td>
            <a href="javascript:;" onclick="show_profile('<?=$item['sign_id']?>')">
                <font color="green"><?=$item['name']?></font>
            </a>
            </td>
            <td><?=$item['py_name']?></td>
            <td><?=$item['gender']?></td>
            <td><?=$item['birthday']?></td>
            <td><?=$item['age']?></td>
            <td><?=$item['passport']?></td>
            <td><?=$item['type']?></td>
            <td><?=$item['identity']?></td>
            <td><?=$item['entourage']?></td>
            <td><?=$item['dir_name']?></td>
            <td><?=$item['major']?></td>
            <td><?=$item['form']?></td>
            <td><?=$item['group']?></td>
            <td><?=$item['song']?></td>
            <td><?=$item['composer']?></td>
            <td><?=$item['author']?></td>
            <td><?=$item['guide']?></td>
            <td><?=$item['nationality']?></td>
            <td><?=$item['national']?></td>
            <td><?=$item['mobile']?></td>
            <td><?=$item['tel']?></td>
            <td><?=$item['email']?></td>
            <td><?=$item['other_contact']?></td>
            <td><?=$item['address']?></td>
            <td><?=$item['guardian_name']?></td>
            <td><?=$item['guardian_mobile']?></td>
            <td><?=($item['guidance_teacher_pize']==0?'否':'是')?></td>
            <td><?=($item['guidance_art_pize']==0?'否':'是')?></td>
            <td><?=($item['creation_pize']==0?'否':'是')?></td>
            <td>
            <?php
                switch ($item['school_radios'])
                {
                    case 'company':
                        echo '单位';
                        break;
                    case 'primary':
                        echo '小学';
                        break;
                    case 'high':
                        echo '中学';
                        break;
                    case 'university':
                        echo '大学';
                        break;
                }
            ?>
            </td>
            <td><?=$item['school_company']?></td>
            <td><?=$item['grade_duty']?></td>
            <td>
            <?php
                switch ($item['university_grade'])
                {
                    case '1':
                        echo '大专';
                        break;
                    case '2':
                        echo '大本';
                        break;
                    case '3':
                        echo '研究生';
                        break;
                    case '4':
                        echo '博士';
                        break;
                }
            ?>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </form>

	<div class="main_foot">
	  <table>
        <tr>
          <td align="left">
            <div class="page">
             <?php if (isset($pagestr)): ?><?=$pagestr?><?php endif; ?>
            </div>
          </td>
        </tr>
      </table>
	</div>

	<?php $this->load->view('admin_foot.php');?>

    <script>
    function to_export(type)
    {
        var $url = "<?=site_aurl($tablefunc.'/export/'.$view['id'])?>";

        if (type && type == 'search')
        {
            var start_time = $("#start_time").val();
            var end_time = $("#end_time").val();
            var user_type = $("#type").val();

            if (!start_time)
            {
                start_time = 0;
            }
            if (!end_time)
            {
                end_time = 0;
            }
            if (!user_type)
            {
                user_type = 0;
            }

            $url += "/" + start_time + "/" + end_time + "/" + user_type;
        }

        window.location.href = $url;
    }

    function show_profile($id)
    {
        var url = "<?=site_aurl($tablefunc.'/profile')?>";
        url += "/" + $id;

        var throughBox = $.dialog.through;
        var myDialog = throughBox({title:'查看详情',lock:true});
        $.ajax({type: "POST",url:url,dataType: 'json',
            success: function (data) {
                if(data.status==200){
                    var win = $.dialog.top;
                    myDialog.content(data.remsg);
                    win.$("#formview").validform();
                    var editors = setEditer(win);

                    myDialog.button({name:"确定",
                        callback:function(){
                            if(win.$("#formview").validform('validall')){
                                if(editors){
                                    var len = editors.length;
                                    for(var i=0;i<len;i++){
                                        editors[i].sync();
                                    }
                                }
				                myDialog.close();
                            }else{

                            }
                            return false;
                        },
                        focus: true
                    });

                }else{
                    showmsg(myDialog,data);
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                debugging(myDialog,url,XMLHttpRequest,textStatus,errorThrown,'profile');
            }
        });
    }

    </script>

<?php elseif ($tpl=='profile'):?>

<form name="formview" id="formview" action="" method="post">
<input type="hidden" name="action" id="action" value="">
<input type="hidden" name="id" value="<?=isset($view['id'])?$view['id']:'';?>">
<div id="main_view" class="main_view">
    <table cellSpacing=0 width="100%" class="content_view">
      <tr>
        <td width="100">姓名</td>
        <td width="620"><?=isset($view['name'])?$view['name']:'';?></td>
      </tr>
      <tr>
        <td width="100">头像</td>
        <td><img src="<?=$view['portrait']?>" width="200"/></td>
      </tr>
      <tr>
        <td width="100">证件</td>
        <td>
        <?php if($view['certificate1']):?>
            <img src="<?=$view['certificate1']?>" width="600"/> <br>
        <?php endif;?>
        <?php if($view['certificate2']):?>
            <img src="<?=$view['certificate2']?>" width="600"/> <br>
        <?php endif;?>
        <?php if($view['certificate3']):?>
            <img src="<?=$view['certificate3']?>" width="600"/> <br>
        <?php endif;?>
        <?php if($view['certificate4']):?>
            <img src="<?=$view['certificate4']?>" width="600"/> <br>
        <?php endif;?>
        </td>
      </tr>
    </table>
</div>
</form>

<?php endif;?>