/* $(function () {
    $('#submit').click(function(){
        var truthBeTold = window.confirm("確認提交？");
        if(truthBeTold){
            window.alert("已提交！");
        }else{
            // window.alert("再见啦！");
        }
    });
}); */
var common = {
    // 随机生成一个Id
    createRandomId: function(){
        return Date.parse(new Date()) + Math.random().toString().substr(2);
    }
};

var LANG_Validate={
    'required':'红星为必填项',
    'number':'请录入数值',
    'digits':'请录入整数',
    'unsignedint':'请录入正整数',
    'unsigned':'请输入大于等于0的数值',
    'positive':'请输入大于0的数值',
    'alpha':'请输入英文字母',
    'alphaint':'请输入英文字母或数字',
    'alphanum':'请输入英文字母,中文及数字',
    'date':'请录入日期格式yyyy-mm-dd',
    'email':'请录入正确的Email地址',
    'url':'请录入正确的网址',
    'mobile':'请录入正确的手机号码',
    'tel':'请录入正确的固定电话',
    'phone':'请录入正确的电话或手机',
    'zip':'请录入正确的邮编',
    'area':'请选择完整的地区',
    'greater':'不能小于前一项',
    'requiredonly':'必须选择一项',
    'identity':'请输入合法身份证'
};

/** 
 * 表单验证规则
 *
 * 使用方法： validatorMap[key][1](element, element.value)
 *
 * 验证函数： function(element, v){}
 *            @parames     element     jQuery对象
 *            @parames     v           表单元素的值
 *            @return      true 验证通过, flase验证失败
 */
var validatorMap = {
    'required': [LANG_Validate['required'], function(element, v) {
        return v != null && v != '' && $.trim(v) != '';
    }],
    'requiredradio': [LANG_Validate['requiredonly'], function(element, v) {
        var name = $(element).attr("name");
        var radio = $("input[type=radio][name='" + name + "']");
        var falg = false;
        radio.each(function(index,element){
            if (element.checked == true)
            {
                falg = true;
                return false;
            }
        });
        return falg;
    }],
    'mobile': [LANG_Validate['mobile'], function(element, v) {
        return /^0?1[34578]\d{9}$/.test(v);
    }],
    'identity':[LANG_Validate['identity'], function(element, v) {
        return /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(v);
    }],
    'email': [LANG_Validate['email'], function(element, v) {
        return /^[a-z\d][a-z\d_.]*@[\w-]+(?:\.[a-z]{2,})+$/i.test(v);
    }]
};


var app = angular.module('myApp',[]);

app.controller('myctrl',['$scope',function($scope){
    $scope.baomingObj = {
        
        // 填表人性质
        xingzhi: {   
            id: "xingzhiId" + common.createRandomId(),
            value: "选手",
            valueArr: [
                "选手",
                "老师",
                "陪同",
            ]
        },
        // 举办地
        hostCity: {   
            id: "hostCityId" + common.createRandomId(),
            value: enrollData.host,
            valueArr: [
                enrollData.host,
            ]
        },
        // 推荐教师
        teacher: {   
            id: "teacherId" + common.createRandomId(),
            value: ""
        },        
        // 姓名 拼音（英文姓名）
        name: {   
            isValidate : true,
            id: "nameId" + common.createRandomId(),
            value: "",
            enValue: "" // 英文名字
        },
        // 生日
        birth: {   
            isValidate : true,
            id: "birthId" + common.createRandomId(),
            value: ""
        },
        // 性别
        gender: {   
            isValidate : true,
            id: "genderId" + common.createRandomId(),
            value: "男"
        },
        // 国籍
        nationality: {   
            isValidate : true,
            id: "nationalityId" + common.createRandomId(),
            value: ""
        },
        // 年龄
        age: {   
            isValidate : true,
            id: "ageId" + common.createRandomId(),
            value: ""
        },
        // 民族
        national: {  
            isValidate : true, 
            id: "nationalId" + common.createRandomId(),
            value: ""
        },
        // 头像
        avatar: {   
            isValidate : true,
            id: "avatarId" + common.createRandomId(),
            value: enrollData.tplurl + "/registrationForm/images/nopic.jpg"        
        },
        // 家庭电话
        telNo: {   
            id: "telNoId" + common.createRandomId(),
            value: ""
        },
        // 手机号
        mobileNo: {   
            isValidate : true,
            id: "mobileNoId" + common.createRandomId(),
            value: ""
        },
        // 身份证
        identity: {   
            isValidate : true,
            id: "idId" + common.createRandomId(),
            value: ""
        },
        // 地址
        address: {   
            id: "addressId" + common.createRandomId(),
            value: ""
        },
        // 邮箱
        email: {   
            id: "emailId" + common.createRandomId(),
            value: ""
        },
        // 其它联系方式
        otherContact: {   
            id: "otherContactId" + common.createRandomId(),
            value: ""
        },
        // 护照号
        passportNo: {   
            id: "passportNoId" + common.createRandomId(),
            value: ""
        },
        // 护照签发日期
        dateOfIssue: {   
            id: "dateOfIssueId" + common.createRandomId(),
            value: ""
        },
        // 护照有效日期
        dateOfExpiry: {   
            id: "dateOfExpiryId" + common.createRandomId(),
            value: ""
        },
        // 身份证、护照照片
        pic: {   
            picArr: [
                {
                    id: "pic" + common.createRandomId(),
                    value:  enrollData.tplurl + "/registrationForm/images/nopic.jpg"
                }
            ]
        },
        // 学校、公司
        company: {   
            id: "companyId" + common.createRandomId(),
            value: "单位",
            oValue: "",
            nValue: ""
        },
        // 年級/職務
        duty: {   
            id: "dutyId" + common.createRandomId(),
            value: ""
        },
        // 家长姓名 拼音（英文姓名）
        guardianName: {   
            id: "guardianNameId" + common.createRandomId(),
            value: ""
        },
        // 家长性别
        guardianGender: {   
            id: "guardianGenderId" + common.createRandomId(),
            value: ""
        },
        // 家长电话
        guardianTelNo: {   
            id: "guardianTelNoId" + common.createRandomId(),
            value: ""
        },
        // 家长手机
        guardianMobileNo: {   
            id: "guardianMobileNoId" + common.createRandomId(),
            value: ""
        },
        // 申請編創
        creationPize: {   
            id: "creationPizeId" + common.createRandomId(),
            value: "否"
        },
        // 申請指導獎
        guidancePize: {   
            id: "guidancePizeId" + common.createRandomId(),
            value: "申請艺术指導獎"
        },        
        // 參賽方向
        direction: {   
            id: enrollData.firstDirect.id,
            value: enrollData.firstDirect.title
        },
        // 管弦乐大赛
        guanxuanyue: {
            array: []
        },
        // 钢琴大赛
        gangqin: {
            array: []
        },
        // 民乐大赛
        minyue: {
            array: []
        },
        // 声乐大赛
        shengyue: {
            array: []
        },
        // 舞蹈大赛
        wudao: {
            array: []
        },

        // 参赛方向数组
        directarr : enrollData.directData
    };

// 例：
// $scope.baomingObj.directarr.id1.array = []
// $scope.baomingObj.directarr.id33.array = []


    // 删除
    $scope.del = function(what, index, $event){
        $event.stopPropagation();
        $scope.baomingObj.directarr["id"+what].array.splice(index, 1);
    };

    // 举办地选择
    $scope.chooseHostCity = function(what){
        $scope.baomingObj.hostCity.value = what;
    };
    // 性质选择
    $scope.choosexingzhi = function(what){
        $scope.baomingObj.xingzhi.value = what;
        var $obj = document.getElementById('enroll[type]');

        switch (what)
        {
            case "老师":
                $obj.value = "2";
            break;
            case "陪同":
                $obj.value = "3";
            break;
            case "选手":
            default:
                $obj.value = "1";
        }
        
    };
    // 参赛方向选择
    $scope.chooseDirection = function(what,id){
        $scope.baomingObj.direction.value = what;
        $scope.baomingObj.direction.id = id;
    };

    /*
    // 参赛形式选择
    $scope.chooseWay = function($event, item){
        item.way = $event.target.innerText;
    };

    $scope.chooseSpecial = function($event, item){
        item.special = $event.target.innerText;
        if($scope.baomingObj.direction.value == '声乐大赛'){
            if(item.special == '合唱' || item.special == '小组唱'){
                item.way = '重唱';
            }else{
                item.way = '独唱';
            }
            
        };
    };*/

    
    // 兼报
    $scope.add = function()
    {
        var attr = "id"+$scope.baomingObj.direction.id;
        //var array = $scope.baomingObj.directarr[attr].array;
        var tmp = [];
        $scope.baomingObj.directarr[attr].array.push(tmp);
    };


    // 保存图片到本地
    $scope.saveToPng = function(){
        $('#optBtns').hide();
        $('.del-btn').hide();
        var indexArr = [];
        angular.forEach($('.match-body'), function(item, index){
            if(item.style.display != 'none'){
                indexArr.push(index);
            };
            item.style.display = 'block';
        });
        html2canvas($("body")[0]).then(function(canvas) {  
            $('#optBtns').show();
            $('.del-btn').show();
            angular.forEach($('.match-body'), function(item, index){
                if(indexArr.length >0 ){
                    
                    for(var j=0,jlen=indexArr.length;j<jlen;j++){
                        if(index == indexArr[j]){
                            item.style.display = 'block';
                        }else{
                            item.style.display = 'none';
                        }
                    } 
                }else{
                    item.style.display = 'none';
                }
            });
                // var imgUri = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream"); // 获取生成的图片的url  
                var imgUri = canvas.toDataURL(); // 获取生成的图片的url  
                
            $('#dw').attr('href',imgUri);
            $('#capture').attr('src',imgUri);
            // $('#myModal').modal('show');
            // console.log(imgUri);
            // window.location.href= 'imgUri'; // 下载图片  
        }).then(function(){

            document.getElementById("dw").click();
        });  
    };

    // 提交
    $scope.submit = function(){
        var truthBeTold = window.confirm("请检查报名表是否填写正确，提交后如需更改请联系客服。\n\n是否提交？");
        if(truthBeTold)
        {
            var user_type = document.getElementById("enroll[type]").value;

            // 判断选手是否选择了参赛方向
            if (user_type == '1')
            {
                var flag = false;
                for (var key in $scope.baomingObj.directarr)
                {
                    if ($scope.baomingObj.directarr[key].array.length > 0)
                    {
                        flag = true;
                    }
                }

                if (!flag)
                {
                    window.alert("选手必须选择参赛方向");
                    return false;
                }
            }

            var errflag = false;
            var errmsg  = '';
            var formElements = $('#signupForm').find('[vtype]');
            formElements.each(function(i,element)
            {
                // 表单元素为可见元素或不是隐藏域
                if ($(element).is(':visible') || $(element).attr('type') == 'hidden')
                {
                    var vtype = $(element).attr("vtype");
                    if (vtype)
                    {
                        var valiteArr = vtype.split('&&');
                        $(valiteArr).each(function(i,key) {
                            if (!validatorMap[key][1](element, element.value))
                            {
                                errflag = true;
                                errmsg = validatorMap[key][0];
                                return false;
                            }
                        });
                    }
                }

                if (errflag)
                {
                    return false;
                }
            });

            if (errflag)
            {
                window.alert(errmsg);
                return false;
            }

            /*
            var cert_1 = document.getElementById('enroll[certificate1]');
            var cert_2 = document.getElementById('enroll[certificate2]');
            var cert_3 = document.getElementById('enroll[certificate3]');
            var cert_4 = document.getElementById('enroll[certificate4]');

            if (cert_1.value == '' && cert_2.value == '' && cert_3.value == '' && cert_4.value == '')
            {
                window.alert("必须上传电子版证件！");
                return false;
            }*/

//            console.log(formElements);
/*
            var $name = document.getElementById("enroll[name]").value;
            var $pyname = document.getElementById("enroll[py_name]").value;
            var $birthday = document.getElementById("enroll[birthday]").value;
            var $nationality = document.getElementById("enroll[nationality]").value;
            var $age = document.getElementById("enroll[age]").value;
            var $national = document.getElementById("enroll[national]").value;
            var $mobile = document.getElementById("enroll[mobile]").value;
            var $identity = document.getElementById("enroll[identity]").value;
            var $address = document.getElementById("enroll[address]").value;
            var $email = document.getElementById("enroll[email]").value;

            var $portrait = document.getElementById("enroll[portrait]").value;

            if (!$name || !$pyname || !$birthday || !$nationality || !$age || !$national || !$mobile || !$identity || !$address || !$email || !$portrait)
            {
                window.alert("红星为必填项！");
                return false;
            }

            if ($mobile.length != 11 || isNaN($mobile))
            {
                window.alert("手机号错误！");
                return false;
            }

            if ($identity.length != 18)
            {
                window.alert("身份证号错误！");
                return false;
            }

*/

            document.getElementById("signupForm").submit();
        }else{
            // window.alert("再见啦！");
        }
    };
}]);

$(function(){
    $(document).on('click', '.heading-title', function(){
        var glyphicon = $(this).find('.glyphicon-triangle-bottom');
        if(glyphicon.hasClass('glyphicon-triangle-top')){
            glyphicon.removeClass('glyphicon-triangle-top');
            $(this).next('.panel-body').slideDown();
        }else{
            glyphicon.addClass('glyphicon-triangle-top');
            $(this).next('.panel-body').slideUp();
        };
    });
});


