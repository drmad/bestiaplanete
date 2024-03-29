<!DOCTYPE html>
<!--
    You can delete this file. Remember to remove the routing rule from
    config/default.php
-->
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
        }
        header {
            background: #008080;
            height: 55px;
            position: relative;
            border-top: 5px solid #006060;
            text-align: center;
            padding-top: 5px;
        }
        .container {
            padding: 10px 10px;
            width: 900px;
            margin: 0px auto;
        }
        h1 {
            font-weight: normal;
            font-size: 36px;
        }
        pre {
            border: 1px solid #EEE;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
    <title>Welcome to your new Vendimia project</title>
</head>
<body>
    <header>
        <svg alt="Vendimia" width="55px" height="55px" xmlns="http://www.w3.org/2000/svg">
            <style>
                rect {
                    fill: white;
                }
                circle, path {
                    fill: #008080;
                }
            </style>
            <rect x="0" y="0" width="50" height="50" rx="2.5"/>
            <g transform="rotate(-15)">
                <circle cy="24.876781" cx="19.216204" r="4.6302085" />
                <circle cy="24.876781" cx="29.543043" r="4.6302085" />
                <circle cy="24.876781" cx="8.8893538" r="4.6302085" />
                <circle cy="35.203625" cx="14.052783" r="4.6302085" />
                <circle cy="35.203625" cx="24.379629" r="4.6302085" />
                <circle cy="45.530468" cx="19.216204" r="4.6302085" />
            </g>
            <path d="m 20.892295,13.65912 7.249933,-7.18269 -9.943405,2.58986 -0.808494,3.52143 z" />
        </svg>
    </header>

    <div class="container">
    <h1>Welcome to your new Vendimia project</h1>
    <p>Now, you have to do a few things more before start:</p>

    <ul>
    <li>Adjust the <code>config/default.php</code> file to your needs (specially in the <code>database</code> section, if you'll use one).</li>

    <li>Create new modules for your project. You can use the <code>vendimia</code> script for this task:</li>

    <pre>cd <?=Vendimia\PROJECT_PATH?>

./vendimia new module MyModule</pre>

    <li>And that's it. Have fun coding!</li>

    </ul>
    </div>

</body>
</html>