<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        header("Access-Control-Allow-Origin: *");
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    API
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $.ajax({
            type: 'GET',
            url: 'http://localhost/apicakephp/admin/users/index.json',
            headers: {
                'Authorization': 'bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImV4cCI6MTY1NzM4NzcyOX0.FfjUpplPM_0531xBiIZMqF2PPdM8PRxtN_Py6Qbh2a4'
            },
            success: function(data) {
                console.log(data);
            }
        });
    </script>
</body>
</html>
