$(function () {
    $('#submit').click(function(){
        var truthBeTold = window.confirm("確認提交？");
        if(truthBeTold){
            window.alert("已提交！");
        }else{
            // window.alert("再见啦！");
        }
    });
});