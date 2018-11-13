<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>參賽報名表-<?=$view['title']?></title>

    <!-- Bootstrap -->
    <link href="<?=$config['site_templateurl'];?>/registrationForm/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="<?=$config['site_templateurl'];?>/registrationForm/css/style.css" rel="stylesheet">
    <link href="<?=base_url($langurl);?>/js/datejs/skin/WdatePicker.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="<?=base_url('js/kindeditor/themes/default/default.css')?>" />
    <style>
        .ke-dialog{
            top: 110px;
        }
    </style>
</head>

<body ng-app="myApp" ng-controller="myctrl">
    <h1 class="text-center"><?=$view['title']?></h1>
    <h2 class="text-center">

        <!-- <div class="dropdown" style="margin: 0 auto; width:200px;">
            <button class="btn btn-default dropdown-toggle" style="font-size:20px; font-weight: bold;" type="button" id="dropdownMenu00" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="color-red margin-right-5px">★</span>举办地：<span class="name" ng-bind="baomingObj.hostCity.value"></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu00">
                <li ng-click="chooseHostCity(item)" ng-repeat="item in baomingObj.hostCity.valueArr"><a href="javascript:;">{{item}}</a></li>
            </ul>
        </div> -->
        <div style="font-size:20px; font-weight: bold;" type="button" id="dropdownMenu00" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            举办地：<span class="name" ng-bind="baomingObj.hostCity.value"></span>
        </div>
    </h2>

    <form action="<?=$action?>" id="signupForm" name="signupForm" method="post" novalidate>
    <input type="hidden" name="action" value="<?=$action?>"/>
    <input type="hidden" name="enroll[enroll_id]" value="<?=$view['id']?>"/>
        <div class="panel panel-primary margin-20">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputOtherContact" class="control-label"><span class="color-red margin-right-5px">★</span>参赛性质</label>
                            <div class="">
                                <div class="dropdown">
                                    <input type="hidden" name="enroll[type]" id="enroll[type]" value="1"/>
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu00" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            参赛人性质：<span class="name" ng-bind="baomingObj.xingzhi.value"></span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu00">
                                        <li ng-click="choosexingzhi(item)" ng-repeat="item in baomingObj.xingzhi.valueArr"><a href="javascript:;">{{item}}</a></li>
                                    </ul>
                                    请选择您是“选手”，“老师”，还是“陪同”人员
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary margin-20">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputName" class="control-label"><span class="color-red margin-right-5px">★</span>姓名 name</label>
                            <div class="">
                                <input ng-model="baomingObj.name.value" type="text" name="enroll[name]" id="enroll[name]" maxlength=60 class="form-control" placeholder="姓名 name" vtype="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="control-label"><span class="color-red margin-right-5px">★</span>拼音(英文姓名)<span class="color-red">首</span>字母大写，姓与名用空格隔开。如：Zhang Wei</label>
                            <div class="">
                                <input ng-model="baomingObj.name.enValue" type="text" name="enroll[py_name]" id="enroll[py_name]" class="form-control" vtype="required" placeholder="拼音（英文姓名）">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="inputBirthday" class="control-label"><span class="color-red margin-right-5px">★</span>出生日期 Date of birth</label>
                            <div class="">
                                <input ng-model="baomingObj.birth.value" type="text" name="enroll[birthday]" id="enroll[birthday]" class="form-control" vtype="required" placeholder="出生日期 Date of birth" onclick="WdatePicker()">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputGender" class="control-label"><span class="color-red margin-right-5px">★</span>性別 Gender</label>
                            <div class="" style="height: 34px;">
                                <label style="margin-right:50px;" class="control-label">
                                    <input  type="radio" checked name="enroll[gender]" id="gender0" value="1">&nbsp;男
                                </label>
                                <label class="control-label">
                                    <input  type="radio" name="enroll[gender]" id="gender1" value="0">&nbsp;女
                                </label>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="inputNationality" class="control-label"><span class="color-red margin-right-5px">★</span>國籍 Nationality</label>
                            <div class="">
                                <input ng-model="baomingObj.nationality.value" type="text" name="enroll[nationality]" id="enroll[nationality]" class="form-control" vtype="required" placeholder="國籍 Nationality">
                            </div>
                        </div>
                        <div class="form-group clearfix" ng-if="baomingObj.xingzhi.value == '陪同'">
                            <label for="inputNationality" class="control-label"><span class="color-red margin-right-5px">★</span>陪同参赛选手姓名</label>
                            <div class="">
                                <input ng-model="baomingObj.beipeitoing.value" type="text" vtype="required" name="enroll[entourage]" id="nationality" class="form-control" placeholder="陪同参赛选手姓名">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputAge" class="control-label"><span class="color-red margin-right-5px">★</span>年齡 Age</label>
                            <div class="">
                                <input ng-model="baomingObj.age.value" type="number" name="enroll[age]" id="enroll[age]" vtype="required" class="form-control" placeholder="年齡 Age">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="inputNational" class="control-label"><span class="color-red margin-right-5px">★</span>民族 National</label>
                            <div class="">
                                <input ng-model="baomingObj.national.value" type="text" name="enroll[national]" id="enroll[national]" class="form-control" vtype="required" placeholder="民族 National">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputAge" class="control-label"><span class="color-red margin-right-5px">★</span>照片 Photo（兩寸白底彩色免冠照片）</label>
                            <div class="">
                                <img onclick="uploadpic(this,'enroll[portrait]','portrait')" src="<?=$config['site_templateurl'];?>/registrationForm/images/nopic.jpg" class="img-thumbnail" alt="兩寸白底彩色免冠照片" data-holder-rendered="true" style="cursor:pointer;height: 140px;">
                                <input type="hidden" name="enroll[portrait]" id="enroll[portrait]" vtype="required" value="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="panel panel-primary margin-20">
            <div class="panel-body">
                <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputTelNo" class="control-label">家庭電話 Tel No.</label>
                                <div class="">
                                    <input ng-model="baomingObj.telNo.value" type="text" name="enroll[tel]" id="enroll[tel]" class="form-control" placeholder="家庭電話 Tel No.">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputMobileNo" class="control-label"><span class="color-red margin-right-5px">★</span>手機號碼Mobile No.</label>
                                <div class="">
                                    <input ng-model="baomingObj.mobileNo.value" name="enroll[mobile]" type="text" id="enroll[mobile]" class="form-control" vtype="required&&mobile" placeholder="手機號碼Mobile No.">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputId" class="control-label"><span class="color-red margin-right-5px">★</span>身份證 ID</label>
                                <div class="">
                                    <input ng-model="baomingObj.identity.value" name="enroll[identity]" type="text" id="enroll[identity]" maxlength="18" class="form-control" vtype="required&&identity" placeholder="身份證 ID">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputAddress" class="control-label"><span class="color-red margin-right-5px">★</span>郵寄地址 Address</label>
                                <div class="">
                                    <input ng-model="baomingObj.address.value" type="text" name="enroll[address]" id="enroll[address]" class="form-control" vtype="required" placeholder="郵寄地址 Address">
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="panel panel-primary margin-20">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputEmail" class="control-label"><span class="color-red margin-right-5px">★</span>郵箱 Email</label>
                            <div class="">
                                <input ng-model="baomingObj.email.value" type="text" name="enroll[email]" id="enroll[email]" class="form-control" vtype="required&&email" placeholder="郵箱 Email">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputOtherContact" class="control-label">其它聯繫方式</label>
                            <div class="">
                                <input ng-model="baomingObj.otherContact.value" type="text" name="enroll[other_contact]" id="otherContact" class="form-control" placeholder="其它聯繫方式（如 QQ 等）">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary margin-20">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputPassport" class="control-label">護照號碼 Passport No.</label>
                            <div class="">
                                <input ng-model="baomingObj.passportNo.value" type="text" name="enroll[passport]" id="passport" class="form-control" placeholder="護照號碼 Passport No.">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputIssueDate" class="control-label">護照簽發日期 Date of Issue</label>
                            <div class="">
                                <input ng-model="baomingObj.dateOfIssue.value" type="text" id="issueDate" class="form-control" name="enroll[issue_date]" placeholder="護照簽發日期 Date of Issue" onclick="WdatePicker()">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputExpiryDate" class="control-label">護照有效日期 Date of Expiry</label>
                            <div class="">
                                <input ng-model="baomingObj.dateOfExpiry.value" type="text" name="enroll[expiry_date]" id="expiryDate" class="form-control" placeholder="護照有效日期 Date of Expiry (有效期八個月以上)" onclick="WdatePicker()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary margin-20">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputFile" class="control-label"><!-- <span class="color-red margin-right-5px">★</span> -->近期证件照片、身份证正反面电子版、护照首页电子版（若香港护照请传护照封皮电子版）</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="cert_wrap" class="">

<img id="cert_tpl1" src="<?=$config['site_templateurl'];?>/registrationForm/images/nopic.jpg" class="img-thumbnail" data-holder-rendered="true" style="cursor:pointer;height: 180px;" onclick="uploadpic(this,'enroll[certificate1]','cert')">
<input type="hidden" name="enroll[certificate1]" id="enroll[certificate1]" value="">

<img id="cert_tpl2" src="<?=$config['site_templateurl'];?>/registrationForm/images/nopic.jpg" class="img-thumbnail" data-holder-rendered="true" style="cursor:pointer;height: 180px;" onclick="uploadpic(this,'enroll[certificate2]','cert')">
<input type="hidden" name="enroll[certificate2]" id="enroll[certificate2]" value="">

<img id="cert_tpl3" src="<?=$config['site_templateurl'];?>/registrationForm/images/nopic.jpg" class="img-thumbnail" data-holder-rendered="true" style="cursor:pointer;height: 180px;" onclick="uploadpic(this,'enroll[certificate3]','cert')">
<input type="hidden" name="enroll[certificate3]" id="enroll[certificate3]" value="">

<img id="cert_tpl4" src="<?=$config['site_templateurl'];?>/registrationForm/images/nopic.jpg" class="img-thumbnail" data-holder-rendered="true" style="cursor:pointer;height: 180px;" onclick="uploadpic(this,'enroll[certificate4]','cert')">
<input type="hidden" name="enroll[certificate4]" id="enroll[certificate4]" value="">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="panel panel-primary margin-20" ng-if="baomingObj.xingzhi.value == '选手'">
            <div class="panel-body">
                <table class="table table-bordered" style="background-color: #f8fcff;">
                    <tbody>
                            <tr>
                                <td rowspan="4" colspan="1" style="word-break: break-all;vertical-align: middle;">
                                    <div class="form-group">
                                        <label for="inputSchool" class="control-label">學校單位 School/Company</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="radio">
                                        <label class="control-label">
                                            <input ng-model="baomingObj.company.value" type="radio" name="enroll[school_radios]" id="schoolRadios0" value="company">单位/Company
                                        </label>
                                    </div>
                                </td>
                                <td rowspan="4" colspan="1" style="vertical-align: middle;">
                                    <div class="">
                                        <input ng-model="baomingObj.company.nValue" type="text" id="school" name="enroll[school_company]" class="form-control" placeholder="名称">
                                    </div>
                                </td>
                                <td rowspan="4" colspan="1" style="word-break: break-all;vertical-align: middle;">
                                    <div class="form-group">
                                        <label for="inputSchool" class="control-label">年級/職務 Grade/Duty</label>
                                    </div>
                                </td>
                                <td rowspan="3" colspan="1" style="vertical-align: middle;">
                                    <div class="">
                                        <input ng-if="baomingObj.company.value == 'university'" disabled ng-model="baomingObj.company.oValue" type="text" id="school" name="enroll[grade_duty]" class="form-control" placeholder="年級/職務 Grade/Duty">
                                        <input ng-if="baomingObj.company.value != 'university'" ng-model="baomingObj.company.oValue" type="text" id="school" name="enroll[grade_duty]" class="form-control" placeholder="年級/職務 Grade/Duty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="radio">
                                        <label class="control-label">
                                            <input ng-model="baomingObj.company.value" type="radio" name="enroll[school_radios]" id="schoolRadios0" value="primary">小學/Primary School
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="radio">
                                        <label class="control-label">
                                            <input ng-model="baomingObj.company.value" type="radio" name="enroll[school_radios]" id="schoolRadios1" value="high">中學/High School
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="radio">
                                        <label class="control-label">
                                            <input ng-model="baomingObj.company.value" type="radio" name="enroll[school_radios]" id="schoolRadios2" value="university">大學/University
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label class="control-label">
                                                    <input ng-if="baomingObj.company.value == 'university'" ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios0" value="1">
                                                    <input ng-if="baomingObj.company.value != 'university'" disabled ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios0" value="1">大專
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label class="control-label">
                                                    <input ng-if="baomingObj.company.value == 'university'" ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios1" value="2">
                                                    <input ng-if="baomingObj.company.value != 'university'" disabled ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios1" value="2">大本
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label class="control-label">
                                                    <input ng-if="baomingObj.company.value == 'university'" ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios2" value="3">
                                                    <input ng-if="baomingObj.company.value != 'university'" disabled ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios2" value="3">研究生
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label class="control-label">
                                                    <input ng-if="baomingObj.company.value == 'university'" ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios3" value="4">
                                                    <input ng-if="baomingObj.company.value != 'university'" disabled ng-model="baomingObj.duty.value" type="radio" name="enroll[university_grade]" id="gradeRadios3" value="4">博士
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-primary margin-20" ng-if="baomingObj.xingzhi.value == '选手'">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputGuardianName" class="control-label">家長姓名/Guardian Name</label>
                            <div class="">
                                <input ng-model="baomingObj.guardianName.value" type="text" name="enroll[guardian_name]" id="guardianName" class="form-control" placeholder="家長姓名/Guardian Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputGuardianGender" class="control-label">家長性別/Gender</label>
                            <div class="">
                                <label style="margin-right:50px;" class="control-label">
                                    <input  type="radio" checked name="enroll[guardian_gender]" id="enroll[guardian_gender]0" value="1">&nbsp;男
                                </label>
                                <label class="control-label">
                                    <input  type="radio" name="enroll[guardian_gender]" id="enroll[guardian_gender]1" value="0">&nbsp;女
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputGuardianTel" class="control-label">家長電話號碼/Tel No.</label>
                            <div class="">
                                <input ng-model="baomingObj.guardianTelNo.value" name="enroll[guardian_tel]" type="text" id="guardianTel" class="form-control" placeholder="電話號碼/Tel No.">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputGuardianMobile" class="control-label">家長手機號碼/Mobile No.</label>
                            <div class="">
                                <input ng-model="baomingObj.guardianMobileNo.value" name="enroll[guardian_mobile]" type="text" id="guardianMobile" class="form-control" placeholder="手機號碼/Mobile No.">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

<!-- 參賽方向 start -->
<div class="panel panel-primary margin-20" ng-if="baomingObj.xingzhi.value == '选手'">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputSchool" class="control-label">參賽方向 Application Direction</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="dropdown fl"><span class="color-red margin-right-5px">★</span>
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="name" ng-bind="baomingObj.direction.value"></span>
                            <span class="caret"></span>
                        </button>
                        <input type="hidden" value="{{baomingObj.direction.id}}">
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu0">
                        <?php foreach($view['directData'] as $direct):?>
                            <li ng-click="chooseDirection('<?=$direct['title']?>','<?=$direct['id']?>')">
                                <a href="javascript:;"><?=$direct['title']?></a>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="fl jianbao">
                        <a class="btn btn-primary" ng-click="add()">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                            <!-- 兼报 -->
                        </a>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="match">
                <div class="no-data bg-danger">
                    <h2 style="padding: 10px;">请选择一个参赛方向，然后点击上方的蓝色
                        <a class="btn btn-default">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                            <!-- 兼报 -->
                        </a>
                        ，如有兼报，请再次选择一个参赛方向，点击上方的蓝色
                        <a class="btn btn-default">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                            <!-- 兼报 -->
                        </a>
                        。
                    </h2>
                </div>


<!-- 参赛方向模板 start -->
<?php foreach($view['directData'] as $direct):?>
<div ng-repeat="($index, item) in <?="baomingObj.directarr.id".$direct['id'].".array"?>" class="panel panel-primary" style="background:#fff;margin:20px 0">
  <div class="panel-heading diplay-flex heading-title">
    <span class="flex1" style="line-height: 250%;">
        {{$index+1}}、<?=$direct['title']?>
        <span class="glyphicon glyphicon-triangle-bottom" style="margin-left:20px;"></span>
    </span>
    <a class="btn btn-danger del-btn" ng-click="del('<?=$direct[id]?>', $index, $event)">
        <span class="glyphicon glyphicon-remove-sign"></span>
        删除
    </a>
  </div>
  <div class="panel-body match-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="direct[{{$index+1}}][<?=$direct['id']?>][major]" class="control-label"><span class="color-red margin-right-5px">★</span>參賽專業（所需乐器名称） Special</label>
                <div class="<?=($direct['special_type'] == 0?'clearfix':'')?>">
                <?php if($direct['special_type'] == 1):?>
                    <input type="text" vtype="required" name="direct[{{$index+1}}][<?=$direct['id']?>][major]" id="direct[{{$index+1}}][<?=$direct['id']?>][major]" class="form-control" placeholder="參賽專業（所需乐器名称） Special">
                <?php elseif($direct['special_type'] == 0):?>
                    <div class="dropdown fl">
                        <button class="btn btn-default dropdown-toggle" type="button" id="<?=$direct['id']?>_{$index}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="name form-txt"><?=($direct['items']['majorData'][0]?$direct['items']['majorData'][0]['title']:'')?></span>
                            <span class="caret"></span>
                        </button>
<!--                         <input class="hide-form" type="hidden" id="direct[{{$index+1}}][<?=$direct['id']?>][major]" name="direct[{{$index+1}}][<?=$direct['id']?>][major]" value="<?=$direct['items']['majorData'][0]?$direct['items']['majorData'][0]['id']:''?>"> -->

<input class="hide-form" type="hidden" id="direct[{{$index+1}}][<?=$direct['id']?>][major]" name="direct[{{$index+1}}][<?=$direct['id']?>][major]" value="<?=$direct['items']['majorData'][0]?$direct['items']['majorData'][0]['title']:''?>">

                        <ul class="dropdown-menu" aria-labelledby="<?=$direct['id']?>_{$index}}">
                        <?php foreach($direct['items']['majorData'] as $major):?>
                            <li onclick="choseMajorItem(this,'<?=$major[title]?>','<?=$major[id]?>')"><a href="javascript:;"><?=$major['title']?></a></li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                <?php endif;?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label"><span class="color-red margin-right-5px">★</span>参赛形式</label>
                <div class="clearfix">
                    <div class="dropdown fl">
                        <button class="btn btn-default dropdown-toggle" type="button" id="formsel{{$index}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="name form-txt"><?=($direct['items']['formData'][0]?$direct['items']['formData'][0]['title']:'')?></span>
                            <span class="caret"></span>
                        </button>
                        <!-- 参赛形式 -->
                        <input type="hidden" class="hide-form" id="direct[{{$index+1}}][<?=$direct['id']?>][form][form_id]" name="direct[{{$index+1}}][<?=$direct['id']?>][form][form_id]" value="<?=($direct['items']['formData'][0]?$direct['items']['formData'][0]['id']:'')?>"/>

<input type="hidden" class="hide-form-title" id="direct[{{$index+1}}][<?=$direct['id']?>][form][form_title]" name="direct[{{$index+1}}][<?=$direct['id']?>][form][form_title]" value="<?=($direct['items']['formData'][0]?$direct['items']['formData'][0]['title']:'')?>"/>
                        <ul class="dropdown-menu" aria-labelledby="<?=$direct['id']?>_{{$index}}">
                        <?php foreach($direct['items']['formData'] as $form):?>
                            <li onclick="choseFormItem(this,'<?=$form[title]?>','<?=$form[id]?>','<?=$form[need_input]?>')"><a href="javascript:;"><?=$form['title']?></a></li>
                        <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="fl jianbao" style="<?=($direct['items']['formData'][0]&&$direct['items']['formData'][0]['need_input']==1?'':'display:none;')?>">
                        <input type="number" name="direct[{{$index+1}}][<?=$direct['id']?>][form][form_number]" vtype="required" class="form-control" placeholder="人数"/>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group group-table-wrap" ng-if="<?=($direct['enable_group'] == 1?'true':'false')?>">
                <span class="color-red margin-right-5px">&nbsp;必选&nbsp;★</span>
                <!-- 参赛组 -->
                <?php foreach($direct['items']['groupData'] as $k1 => $level1):?>
                <table class="table table-bordered">
                    <thead class="bg-color-b0d9fb">
                        <tr>
                            <th colspan="<?=(count($level1['level2']) > 3 ? '4':'3')?>" class="text-center"><?=$level1['name']?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($level1['level2'] as $k2=> $level2):?>
                    <?php
                    if ($k2 % 4 == 0)
                    {
                        echo '<tr>';
                        $i=0;
                    }else{
                        $i++;
                    }?>
                        <td>
                        <!-- 2018/10/25 修改参赛组别为：有3级分类，则第3级分类作为组别选项；否则显示第2级分类为组别选项 -->
                        <?php
                            if (empty($level2['level3']))
                            {
                        ?>
                            <label class="control-label">
                                <input  type="radio" vtype="requiredradio" id="direct[{{$index+1}}][<?=$direct['id']?>][group_id]" name="direct[{{$index+1}}][<?=$direct['id']?>][group_id]" value="<?=$level2['id']?>">
                                <?=$level2['name']?>
                            </label>

                        <?php
                            }else{
                        ?>
                            <label class="control-label "><?=$level2['name']?></label>
                            <div class="">
                            <?php foreach($level2['level3'] as $k3 => $lvevel3):?>
                                <label class="control-label {{item.classItem=='<?=$lvevel3[id]?>' ? 'label-select' : ''}}" style="font-weight:normal;">
                                    <input ng-model="item.classItem" type="radio" vtype="requiredradio" id="direct[{{$index+1}}][<?=$direct['id']?>][group_id]" name="direct[{{$index+1}}][<?=$direct['id']?>][group_id]" value="<?=$lvevel3['id']?>">  <?=$lvevel3['name']?>
                                </label>
                                &nbsp;&nbsp;
                            <?php endforeach;?>
                            </div>
                        <?php
                            }
                        ?>
                        </td>
                    <?=($i==4 ?'</tr>':'')?>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php endforeach;?>
            </div>

            <div class="form-group group-table-wrap margin-top-20">
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <td>
                                <div class="col" ng-if="<?=($direct['enable_song'] == 1?'true':'false')?>">
                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <span class="color-red margin-right-5px">★</span>
                                        <label for="direct[{{$index+1}}][<?=$direct['id']?>][song]" class="control-label">比賽曲目 Repertoire</label>
                                        <div class="">
                                            <input vtype="required" name="direct[{{$index+1}}][<?=$direct['id']?>][song]" id="direct[{{$index+1}}][<?=$direct['id']?>][song]" class="form-control" type="text" placeholder="比賽曲目 Repertoire">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <span class="color-red margin-right-5px">★</span>
                                        <label for="direct[{{$index+1}}][<?=$direct['id']?>][composer]" class="control-label">曲作者</label>
                                        <div class="">
                                            <input vtype="required" name="direct[{{$index+1}}][<?=$direct['id']?>][composer]" id="direct[{{$index+1}}][<?=$direct['id']?>][composer]" class="form-control" type="text" placeholder="曲作者">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <span class="color-red margin-right-5px">★</span>
                                        <label for="direct[{{$index+1}}][<?=$direct['id']?>][author]" class="control-label">词作者</label>
                                        <div class="">
                                            <input vtype="required" name="direct[{{$index+1}}][<?=$direct['id']?>][author]" id="direct[{{$index+1}}][<?=$direct['id']?>][author]" class="form-control" type="text" placeholder="词作者(仅声乐专业填写，其他专业填“无”)">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md-6" ng-if="<?=($direct['enable_guide'] == 1?'true':'false')?>">

                                            <div class="form-group">
                                                <label for="direct[{{$index+1}}][guide]" class="control-label">指導教師 Teacher</label>
                                                <div class="">
                                                    <input type="text" name="direct[{{$index+1}}][<?=$direct['id']?>][guide]" id="direct[{{$index+1}}][<?=$direct['id']?>][guide]" class="form-control" placeholder="指導教師 Teacher">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" ng-if="<?=($direct['enable_referee'] == 1?'true':'false')?>">

                                            <div class="form-group">
                                                <span class="color-red margin-right-5px">★</span>
                                                <label for="direct[{{$index+1}}][referee]" class="control-label">推荐教师</label>
                                                <div class="">
                                                    <input vtype="required" type="text" name="direct[{{$index+1}}][<?=$direct['id']?>][referee]" id="direct[{{$index+1}}][<?=$direct['id']?>][referee]" class="form-control" placeholder="推荐教师">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- 参赛方向模板 end-->

</div>

<?php endforeach;?>

            </div>
        </div>

    </div>

</div>
<!-- 參賽方向 end -->


        <div class="panel panel-primary margin-20" ng-if="baomingObj.xingzhi.value == '选手'">
            <div class="panel-body">

                    <div class="row">

                        <div class="form-group col-sm-6">
                                <label for="inputapplyForCreationPize" class="control-label">申請編創獎 Apply For Creation Pize （需另行交費）</label>
                            <div class="">
                                <label class="control-label" style="font-weight:normal;">
                                    <input ng-model="baomingObj.creationPize.value" type="radio" name="enroll[creation_pize]" id="applyPize" value="1"> 是
                                </label>
                                &nbsp;&nbsp;
                                <label class="control-label" style="font-weight:normal;">
                                    <input ng-model="baomingObj.creationPize.value" type="radio" name="enroll[creation_pize]" id="unapplyPize" value="0"> 否
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inputApplyForGuidancePrize" class="control-label">申請指導獎 Apply For Guidance Prize （需另行交費）</label>
                            <div class="">
                                <label class="control-label" style="font-weight:normal;">
                                    <input type="checkbox" name="enroll[guidance_teacher_pize]" id="applyGuidancePize" value="1"> 申請教师指導獎
                                </label>
                                &nbsp;&nbsp;
                                <label class="control-label" style="font-weight:normal;">
                                    <input type="checkbox"
                                    name="enroll[guidance_art_pize]"
                                    id="unapplyGuidancePize" value="1"> 申請艺术指導獎
                                </label>
                            </div>
                        </div>

                </div>
            </div>
        </div>

        <div class="margin-20" id="optBtns">
            <div class="panel-body">
                <div class="row text-center">
                    <button type="button" class="btn btn-primary" ng-click="submit()">確定提交</button>
                    <button type="button" class="btn btn-primary" ng-click="saveToPng()" style="margin-left:30px;">保存到本地</button>
                </div>
            </div>
        </div>

        <div class="margin-20">
            <div class="panel-body" style="color:red; font-size:18px;">
                <div class="row">
                    <span style="display:inline-block; width:30px;">注： </span>1：所有隨行人員所交資料均與參賽者相同，其中照片背面須標注姓名；
                </div>
                <div class="row">
                    <span style="display:inline-block; width:30px;"></span>2：以上填寫資料如有任何變動，均需及時與組委會聯繫；
                </div>
                <div class="row">
                    <span style="display:inline-block; width:30px;"></span>3：請參賽選手及隨行人員詳細閱讀報名須知（可在組委會指定官網下載）
                </div>
                <div class="row">
                    <span style="display:inline-block; width:30px;"></span>4：報名表一經填寫上交，即被視為報名者本人及家長已詳細閱讀報名須知，認可並將遵守報名須知中的所有條款內容。
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title alert alert-danger" style="font-weight:bold; margin-top: 30px;">
                    鼠标右键点击下面的参赛报名表，可选择&emsp;“图片另存为”&emsp;到本地。
                    <!-- <div class="alert alert-warning" role="alert" style="display:none;">注意：保存到本地后，鼠标右键点击保存的文件，然后&emsp;重命名&emsp;为&emsp;报名表.png</div> -->
                  </h4>
                </div>
                <div class="modal-body">
                  <p><img  style="width:100%;" id="capture" src="" title="右键点击图片，保存图片到本地" alt="右键点击图片，保存图片到本地" /></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

    </form>
        <a href="{{baomingObj.imgSrc}}" id="dw" download="报名表.png"></a>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="<?=$config['site_templateurl'];?>/registrationForm/js/jquery.1.12.4.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?=base_url('js/kindeditor/kindeditor-min.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('js/language/'.$this->Cache_model->defaultAdminLang.'.js')?>"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=$config['site_templateurl'];?>/registrationForm/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?=base_url($langurl);?>/js/datejs/WdatePicker.js"></script>

    <script src="<?=$config['site_templateurl'];?>/registrationForm/js/angular.js"></script>

    <script>
    var baseurl = "<?=base_url()?>";
    var siteurl = "<?=site_url()?>";
    var siteaurl = "<?=site_aurl()?>";

    /**
     * 上传图片
     * @parames     string      that    img图像this
     * @parames     string      picid   隐藏域id保存图像src
     * @parames     string      type    是上传图像还是证件
     */
    function uploadpic(that,picid,type)
    {
        var editor = KindEditor.editor({
            uploadJson:siteaurl+"/main/attrupload2",
            allowFileManager : true
        });

        editor.loadPlugin('image', function() {
            editor.plugin.imageDialog({
                showRemote : false,
                imageUrl : KindEditor('#'+picid).val(),
                    clickFn : function(url, title, width, height, border, align)
                    {
                        var newurl = url.substr(url.indexOf("data"));

                        document.getElementById(picid).value=newurl;

                        if(that){
                            $(that).attr('src',url);
                        }

                        editor.hideDialog();
                    }
                });
        });
    }

    // 选择"参赛专业"
    function choseMajorItem(event,title,id)
    {
        var $that = $(event);
        var $parent = $that.closest('.dropdown');
        var obj = $parent.find('.form-txt');
        obj.text(title);

        //$parent.find(".hide-form").val(id);
        $parent.find(".hide-form").val(title);
    }

    // 选择“参赛形式”
    function choseFormItem(event,title,id,need)
    {
        var $that = $(event);
        var $parent = $that.closest('.dropdown');
        var obj = $parent.find('.form-txt');
        var obj2 = $parent.next('.jianbao');

        obj.text(title);
        $parent.find(".hide-form").val(id);
        $parent.find(".hide-form-title").val(title);

        if (need && need == 1)
        {
            obj2.show();
        }
        else
        {
            obj2.hide();
        }
    }

    // 选择参赛组项目
    function choseGroup(event)
    {
        var $that = $(event);
        var $parent = $that.closest('label');
        var brothers = $parent.siblings('label');
        brothers.removeClass('label-select');
        $parent.addClass('label-select');
    }

    /** 数据库中获取的数据 */
    window.enrollData = {};
    enrollData.host = "<?=$view['host']?>";
    enrollData.tplurl= "<?=$config['site_templateurl']?>";

    //默认第一个参赛方向
    enrollData.firstDirect = {
        id : "<?=$view['directData'][0]['id']?>",
        title : "<?=$view['directData'][0]['title']?>"
    };

    enrollData.directData = {
    <?php foreach($view['directData'] as $index => $dir):?>
        'id<?=$dir["id"]?>' : {
            array:[]
        }<?=(($index+1) != count($view['directData']))?',':''?>
    <?php endforeach;?>
    };

    </script>

    <script src="<?=$config['site_templateurl'];?>/registrationForm/js/main.js"></script>
    <script src="<?=$config['site_templateurl'];?>/registrationForm/js/html2canvas.min.js"></script>
</body>

</html>