<html>

    <head>
        <title>Product list backend</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
        <link href="css/jquery.fileupload.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            body
            {
                margin: 0;
                padding: 0;
                background-color:#D6F5F5;
                text-align:center;
            }
            .top-bar
            {
                width: 100%;
                height: auto;
                text-align: center;
                background-color:#FFF;
                border-bottom: 1px solid #000;
                margin-bottom: 20px;
            }
            .inside-top-bar
            {
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .link
            {
                font-size: 18px;
                text-decoration: none;
                background-color: #000;
                color: #FFF;
                padding: 5px;
            }
            .link:hover
            {
                background-color: #9688B2;
            }
        </style>

        <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-60962033-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>

    <body>
        <div class="top-bar">
            Saarc Stars SL Backend
        </div>
        
        <div style="border:1px dashed #333333; width:400px; margin:0 auto; padding:10px;">
            <p>Upload product list in CSV format</p>
            <form name="import" method="post" enctype="multipart/form-data">

                <span class="btn btn-success ">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Select CSV files...</span>
                    <input type="file" name="file" /><br />
                </span>
                <input type="submit" name="submit" value="Submit" />
            </form>
<?php
include ("connection.php");

if (isset($_POST["submit"])) {
    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");
    $c = 0;
    while (($filesop = fgetcsv($handle, 1000, ";")) !== false) {

        $c = $c ++;
        if ($c > 1) {
            $sql = mysqli_query($conn, "INSERT INTO a3n_product (brand, model, description, price, stock, image) VALUES ('$filesop[0]','$filesop[1]','$filesop[2]','$filesop[3]','$filesop[4]','$filesop[5]')")or die(mysqli_error($conn));
        }
    }

    if ($sql) {
        echo "You database has imported successfully. You have inserted " . $c - 1 . " recoreds";
    } else {
        echo "Sorry! There is some problem.";
    }
}
?>

        </div>
        <hr style="margin-top:100px;" />	
        <div style="border:1px dashed #333333; width:400px; margin:0 auto; padding:10px;">
            <div>
                Upload Image Files
                <p>
                    Click on the select files and select all the files.
                </p>        
            </div>
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select files...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="files[]" multiple>
            </span>
            <br>
            <br>
            <!-- The global progress bar -->
            <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>
            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="js/jquery.ui.widget.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="js/jquery.fileupload.js"></script>
        <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script>
            /*jslint unparam: true */
            /*global window, $ */
            $(function() {
                'use strict';
                // Change this to the location of your server-side upload handler:
                var url = 'php/';
                $('#fileupload').fileupload({
                    url: url,
                    dataType: 'json',
                    done: function(e, data) {
                        $.each(data.result.files, function(index, file) {
                            $('<p/>').text(file.name).appendTo('#files');
                        });
                    },
                    progressall: function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                                );
                    }
                }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
        </script>

    </body>
</html>