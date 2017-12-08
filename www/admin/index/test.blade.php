<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form  method="post" enctype="multipart/form-data" action="http://www.coupon.com/admin/index/test?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly93d3cuY291cG9uLmNvbS9hZG1pbi9sb2dpbi9sb2dpbiIsImlhdCI6MTUxMTgzMDA5MSwiZXhwIjoxNTExODQwODkxLCJuYmYiOjE1MTE4MzAwOTEsImp0aSI6Ijh6cWRGbzJUd1NjdWxDa1cifQ.O1j01jQbZEXRFcv4eWdAOWFyB-Ag3Xqb1ps3jWYwImE">
    {{ csrf_field() }}
    <table>
        <tr>
            <td></td>
            <td>
                <input type="file" name="coupon">
                <input type="submit" value="提交" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="{{ asset('js/jquery-1.8.2.min.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script type="text/javascript">
    var token = $.cookie('token');
    console.log(token);
</script>