<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="/lib/css/materialize.css" rel="stylesheet" type="text/css"/>
    <link href="/lib/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="/lib/js/require.js" type="text/javascript"></script>
    <script src="/lib/js/lib/jquery/jquery-3.2.1.js" type="text/javascript"></script>
</head>

<body>
<?php
require __DIR__ . '/vendor/autoload.php';
$Namespace = $_POST['namespace'];
$ModuleName = $_POST['module_name'];
if ($ModuleName && $Namespace) {
    //make sure the format is correctlly
    $Namespace = ucfirst($Namespace);
    $ModuleName = ucfirst($ModuleName);

    //generate namespace with lower case
    $namespace = strtolower($Namespace);

    //generate module name with lower case
    $moduleName = strtolower($ModuleName);

    //zip file name
    $fileName = $Namespace . '_' . $ModuleName . '.zip';

    //url to zip file
    $url = 'result/' . $fileName;

    //define command list
    $commands = array();

    //remove zip file if it's existed
    $commands[] = "rm -f $url;";

    //unzip default source code
    $commands[] = "unzip module_default.zip -d source/;";

    //change module name in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/Defaultmodule/' . $ModuleName . '/g" {} +; ';

    //change module name lower case in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/defaultmodule/' . $moduleName . '/g" {} +; ';

    //change namespace in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/Magestore/' . $Namespace . '/g" {} +; ';

    //change namespace lower case in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/magestore/' . $namespace . '/g" {} +; ';

    //change folder name
    $commands[] = 'cd source; mv app/code/Magestore/ app/code/' . $Namespace . ' ; ';

    //change folder name
    $commands[] = 'cd source; mv app/code/' . $Namespace . '/Defaultmodule app/code/' . $Namespace . '/' . $ModuleName . '; ';

    //zip created module
    $commands[] = "cd source; zip -r ../result/$fileName *;";

    //remove temp source files
    $commands[] = "cd source; rm -rf *;";

    //execute commands
    $output = shell_exec(implode(' ', $commands));

    //download zip file
    header("Location: $url");
    exit();
}
?>
<form action="index.php" method="post">
    <ul>
        <li><label for="namespace">Namespace</label></li>
        <li><input id="namespace" name="namespace" type="text" value="Yournamespace"/></li>
        <li><label for="module_name">Module Name</label></li>
        <li><input id="module_name" name="module_name" type="text" value="Modulename"/></li>
        <li><input type="submit" value="Download"/>
    </ul>
</form>

<div id='container' data-bind="scope:'container'">
    <!-- ko template: getTemplate() --><!-- /ko -->
</div>

<script>
    requirejs.config({
        baseUrl: "http://m2gen.magentovn.com//lib/js/",
        urlArgs: "bust=" + (new Date()).getTime(), // Disable require js cache
        waitSeconds: 0,
        paths: {
            domReady: 'domReady',
            jquery: 'lib/jquery/jquery-3.2.1.js',
            underscore: 'lib/underscore',
            ko: 'lib/knockoutjs/knockout',
            'knockout-es5': 'lib/knockoutjs/knockout-es5',
            'es6-collections': 'es6-collections',
            uiApp: 'ui/core/app',
            uiClass: 'ui/lib/core/class',
            uiElement: 'ui/lib/core/element/element',
            uiComponent: 'ui/lib/core/collection',
            uiRegistry: 'ui/lib/registry/registry',
            eventManager: 'model/event-manager',
            accounting: 'lib/accounting.min',
            'mage/utils/wrapper': 'lib/mage/utils/wrapper',
            'mage/apply/main': 'lib/mage/apply/main',
            mageUtils: 'lib/mage/utils/main',
            'hammerjs': 'hammer.min',
            'velocity': 'velocity.min',
            'materialize': 'materialize',
        },
        config: {
            text: {
                useXhr: function (url, protocol, hostname, port) {
                    return true;
                }
            }
        },
        shim: {
            'velocity': {
                deps: ['jquery']
            },
            'materialize': {
                deps: ['jquery', 'velocity']
            }
        }
    });
</script>
<script>
    require([
        'uiApp',
        'lib/jquery/posOverlay',
        'lib/jquery/posAlert',
        'lib/jquery/posPopup'
    ], function (app) {
        app({
            components: {
                "container": {
                    "component": "ui/components/container",
                    "displayArea": "container"
                }
            }
        });

    });
</script>
</body>
</html>

