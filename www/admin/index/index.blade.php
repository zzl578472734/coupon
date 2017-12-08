<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Free HTML5 Bootstrap Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">
    <link id="bs-css" href="{{ asset('css/admin/bootstrap-cerulean.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/charisma-app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugin/jqueryTable/jqueryTable.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/index.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<div class="navbar navbar-default" role="navigation">

    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"> <img alt="Charisma Logo" src="{{ asset('images/admin/logo20.png') }}" class="hidden-xs"/>
            <span>图片后台管理</span></a>

        <!-- user dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> admin</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li id='logut'><a  v-on:click="logut" href="#">Logout</a></li>
            </ul>
        </div>


    </div>
</div>
<!-- topbar ends -->
<div class="ch-container">
    <div class="row">

        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">
                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu tabNav">
                        <li name='imgControl'><a class="ajax-link" href="#"><i class="glyphicon glyphicon-home"></i><span> 图片管理</span></a>
                        </li>
                        <li name='upLoad'><a class="ajax-link" href="#"><i class="glyphicon glyphicon-eye-open"></i><span> 本地上传</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="content" class="col-lg-10 col-sm-10">
            <div id='imgControl'>
                <div class="row rightTool ">
                    <button class="btn btn-primary btn-sm">抓取图片</button>

                    <select id='allImgGroup' @change='selectGroup($event)'>
                        <option v-for="group in groups" :value ='group.id'> @{{group.name}}</option>
                    </select>
                </div>
                <div class="row">
                        <br>
                        <ul class="thumbnails gallery">
                                <li  v-for="img in imgs" class="thumbnail">
                                    <a><img class="grayscale" :src="{img.src}"></a>
                                </li>
                        </ul>
                        <ul class="page" maxshowpageitem="5" pagelistcount="15"  id="imgListPage"></ul>
                </div>
            </div>

            <div id='upLoad' class='displayNone'>
                <div class="rightTool">
                    <button class="btn btn-success btn-sm" id='upload'>本地上传</button>
                    <input  id='uploadInput' type='file' multiple="multiple"/>
                </div>

                 <ul id='fileNames'></ul>
            </div>
        </div>  
        
             <script src="{{ asset('js/jquery.min.js') }}"></script>
             <script src="{{ asset('js/jquery.cookie.js') }}"></script>
            <script src="{{ asset('js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('js/vue.js') }}"></script>
            <script src="{{ asset('js/vue-resource.js') }}"></script>
            <script src="{{ asset('plugin/jqueryTable/jqueryTable.js') }}"></script>
            <script src="{{ asset('js/admin/index.js') }}"></script>
</body>
</html>
