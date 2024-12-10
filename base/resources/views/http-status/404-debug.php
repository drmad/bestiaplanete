<html>
<head><style>
    body{margin: 0px; font-family: sans-serif}
    header{background: #008080; color: white; padding: 15px}
    section{padding: 10px;}
    h1{margin: 0px; font-weight: normal; font-size: 200%}
    h2{margin: 0px; font-weight: normal; font-size: 120%}
    a[data-code] {color: #AAF; font-size: 80%; font-variant: small-caps; border: 1px solid #AAF; border-radius: 10px; padding: 0px 10px; }
    a[data-code].hidden {display: none}

    li {font-family: monospace}
    div.code-line span.class{color: #008080}
    div.code-line span.method{color: #008080; font-weight: bold}
    div.code-line span.args{color: #888}

    table {font-family: monospace; border-collapse:collapse; width: 100%}

    table.code {table-layout: fixed; border: 1px solid #eee; margin: 10px 0px; display: none; max-width: 50vw;overflow: hidden}
    table.code td:first-child{width: 25px; background: #eee;color:#aaa;text-align: right; padding: 0px 10px; user-select: none}
    table.code td:nth-child(2){width: 100%; padding-left: 20px; white-space: pre; overflow: hidden}
    table.code tr.selected{background: #FFA}
    table.code tr.selected td:first-child {color: black; font-weight: bold}
    table.information th {width: 200px; text-align: right; background: #e0eeee; padding: 2px 4px; vertical-align: top}
    table.information td {padding-left: 10px; border-bottom: 1px solid #eee}

    span.methods {font-weight: bold; color: #008080}
    span.path {font-weight: bold}
    span.empty {font-style: italic}
    </style>
    <title>Not found</title>
</head>
<body>
    <header>
    <h1>Unmatched routing rule</h1>
    <h2><?=$target?></h2>
    </header>

    <main><section>
    <h2>Routing rules</h2>
    <ul>
    <?php foreach($rules as $rule):?>
        <li>
            <span class="methods"><?=$rule['methods']?></span>
            <?php if ($rule['path']):?>
                <span class="path"><?=$rule['path']?></span>
            <?php else: ?>
                <span class="empty">(empty)</span>
            <?php endif?>

            🠒
            <span class="target"><?=$rule['target']?></span>
        </li>
    <?php endforeach ?>
    </ul>
    </section></main>
</body>
</html>