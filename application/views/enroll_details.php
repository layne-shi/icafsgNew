<?php if($tpl=='list'):?>
	<?php $this->load->view('admin_head.php');?>

    <div id="main_head" class="main_head" style="height:auto;">
    <form name="formsearch" id="formsearch" action="<?=site_aurl($tablefunc)?>" method="post">
      <table class="menu">
        <tr>
          <td>
            <a href="<?=site_aurl($tablefunc)?>" class="current">
                <?=lang('func_'.$tablefunc)?>
            </a>
            <input type="text" size=60 class="input-text" value="<?=$view['title']?>" readonly="" >

            <a href="<?=site_aurl($tablefunc.'/export/'.$view['id'])?>" class="current">导出全部</a>
          </td>
        </tr>
      </table>
    </form>
    </div>

    <form name="formlist" id="formlist" action="<?=site_aurl($tablefunc)?>" method="post">
	  <input type="hidden" name="action" id="action" value="<?=site_aurl($tablefunc)?>">
      <div id="main" class="main" style="padding-top:40px;">

        <table cellSpacing=0 class="content_list" style="text-align:center;width:260%;">
          <thead>
          <tr>
<!--             <th width="30" align="left">
                <input type="checkbox" onclick="checkAll(this)">
            </th> -->
            <th>推荐教师</th>
            <th>姓名</th>
            <th>拼音</th>
            <th>性别</th>
            <th>生日</th>
            <th>年龄</th>
            <th>护照</th>
            <th>性质</th>
            <th>身份證</th>
           <!--  <th>陪同人员</th> -->
            <th>参赛方向</th>
            <th>参赛专业</th>
            <th>参赛形式</th>
            <th>参赛组别</th>
            <th>比赛曲目</th>
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
          </tr>
          </thead>
          <tbody id="content_list">
          <?php foreach($data as $k => $item): ?>
          <tr id="<?='tid_'.$item['list_id']?>">
<!--             <td width="30" align="left">
                <input type="checkbox" name="optid[]" value="<?=$item['list_id']?>">
            </td> -->
            <td><?=$item['referee']?></td>
            <td><?=$item['name']?></td>
            <td><?=$item['py_name']?></td>
            <td><?=$item['gender']?></td>
            <td><?=$item['birthday']?></td>
            <td><?=$item['age']?></td>
            <td><?=$item['passport']?></td>
            <td><?=$item['type']?></td>
            <td><?=$item['identity']?></td>
            <!--  <td> </td>  陪同人员 -->
            <td><?=$item['dir_name']?></td>
            <td><?=$item['major']?></td>
            <td><?=$item['form']?></td>
            <td><?=$item['group']?></td>
            <td><?=$item['song']?></td>
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
<?php endif;?>