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
            value: "新加坡",
            valueArr: [
                "新加坡",
                "日本",
                "英国",
                "爱琴海",
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
            value: "./images/brain_114.96463932107px_1199703_easyicon.net.png"        
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
                    value: "./images/brain_114.96463932107px_1199703_easyicon.net.png"
                }
            ]
        },
        // 学校、公司
        company: {   
            id: "companyId" + common.createRandomId(),
            value: "小學",
            oValue: ""
        },
        // 年級/職務
        duty: {   
            id: "dutyId" + common.createRandomId(),
            value: "大專"
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
            id: "directionId" + common.createRandomId(),
            value: "管弦乐大赛"
        },
        // 管弦乐大赛
        guanxuanyue: {
            array: [
                /* {
                    id: "guanxuanyueId" + common.createRandomId(),
                    special: "",    // 參賽專業（所需乐器名称）
                    way: "独奏",  // 参赛形式
                    class: {
                        // 成人组
                        adult: {
                            classItem: "演員", 
                            repertoire: "",   // 比賽曲目
                            teacher: "",   // 指導教師
                        },                           
                        // 高等院校组
                        highCollege: {
                            classItem: "表演", 
                            repertoire: "",   // 比賽曲目
                            teacher: "",   // 指導教師
                        },                           
                        // 其它
                        adult: {
                            classItem: "藝術高中组", 
                            repertoire: "",   // 比賽曲目
                            teacher: "",   // 指導教師
                        }                        
                    }
                } */
            ]
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
        }
    };

    // 删除
    $scope.del = function(what, index, $event){
        $event.stopPropagation();
        $scope.baomingObj[what].array.splice(index, 1);
    };

    // 举办地选择
    $scope.chooseHostCity = function(what){
        $scope.baomingObj.hostCity.value = what;
    };
    // 性质选择
    $scope.choosexingzhi = function(what){
        $scope.baomingObj.xingzhi.value = what;
    };
    // 参赛方向选择
    $scope.chooseDirection = function(what){
        $scope.baomingObj.direction.value = what;
    };
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
    };

    
    // 兼报
    $scope.add = function(){
        if($scope.baomingObj.direction.value == '管弦乐大赛'){
            $scope.baomingObj.guanxuanyue.array.push({
                id: "guanxuanyueId" + common.createRandomId(),
                special: "",    // 參賽專業（所需乐器名称）
                way: "独奏",  // 参赛形式
                classItem: "演員", 
                peopleCount: "",
                repertoire: "",   // 比賽曲目
                teacher: "",   // 指導教師
                teacherT: ""   // 推荐教師
            });
        }else if($scope.baomingObj.direction.value == '钢琴大赛'){
            $scope.baomingObj.gangqin.array.push({
                id: "guanxuanyueId" + common.createRandomId(),
                special: "钢琴",    // 參賽專業（所需乐器名称）
                way: "独奏",  // 参赛形式
                classItem: "演員", 
                repertoire: "",   // 比賽曲目
                teacher: "",   // 指導教師
                teacherT: ""   // 推荐教師
            });

        }else if($scope.baomingObj.direction.value == '民乐大赛'){
            $scope.baomingObj.minyue.array.push({
                id: "minyueId" + common.createRandomId(),
                special: "",    // 參賽專業（所需乐器名称）
                way: "独奏",  // 参赛形式
                classItem: "演員", 
                peopleCount: "",
                repertoire: "",   // 比賽曲目
                teacher: "",   // 指導教師
                teacherT: ""   // 推荐教師
            });

        }else if($scope.baomingObj.direction.value == '声乐大赛'){
            $scope.baomingObj.shengyue.array.push({
                id: "shengyueId" + common.createRandomId(),
                special: "美声",    // 參賽專業（所需乐器名称）
                way: "独唱",  // 参赛形式
                peopleCount: "",
                repertoire: "",   // 比賽曲目
                teacher: "",   // 指導教師
                teacherT: ""   // 推荐教師
            });

        }else if($scope.baomingObj.direction.value == '舞蹈大赛'){
            $scope.baomingObj.wudao.array.push({
                id: "wudaoId" + common.createRandomId(),
                special: "中国舞（民族民间舞）",    // 參賽專業（所需乐器名称）
                way: "独舞",  // 参赛形式
                peopleCount: "",
                repertoire: "",   // 比賽曲目
                teacher: "",   // 指導教師
                teacherT: ""   // 推荐教師
            });
        }
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
            var imgUri = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream"); // 获取生成的图片的url  
            // console.log(imgUri);
            // window.location.href= 'imgUri'; // 下载图片  
            $('#capture').attr('src',imgUri);
            $('#myModal').modal('show');
        });  
    };

    // 提交
    $scope.submit = function(){
        var truthBeTold = window.confirm("请检查报名表是否填写正确，提交后如需更改请联系客服。\n\n是否提交？");
        if(truthBeTold){
            window.alert("已提交！");
            window.location = './complete.html';
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


