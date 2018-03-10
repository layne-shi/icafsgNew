<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>参赛须知</title>

    <!-- Bootstrap -->
    <link href="<?=$config['site_templateurl'];?>/registrationForm/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="<?=$config['site_templateurl'];?>/registrationForm/css/style.css" rel="stylesheet">
</head>

<body>
    <h1 class="text-center">参赛须知</h1>

    <form>
        <div class="panel panel-primary margin-20">
            <div class="panel-body">
                参赛须知
            </div>
        </div>

        <div class="margin-20" id="optBtns">
            <div class="panel-body">
                <div class="row text-center">
                    <a class="btn btn-primary" href="<?=$url?>">同意</a>
                </div>
            </div>
        </div>
    </form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=$config['site_templateurl'];?>/registrationForm/js/bootstrap.min.js"></script>
</body>

</html>