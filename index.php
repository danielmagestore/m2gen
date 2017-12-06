<?php
$Namespace = $_POST['namespace'];
$ModuleName = $_POST['module_name'];
if($ModuleName && $Namespace){
    //make sure the format is correctlly
    $Namespace = ucfirst($Namespace);
    $ModuleName = ucfirst($ModuleName);

    //generate namespace with lower case
    $namespace = strtolower($Namespace);

    //generate module name with lower case
    $moduleName = strtolower($ModuleName);

    //zip file name
    $fileName = $Namespace.'_'.$ModuleName.'.zip';
    
    //url to zip file
    $url = 'result/'.$fileName;

    //define command list
    $commands = array();

    //remove zip file if it's existed
    $commands[] = "rm -f $url;";

    //unzip default source code
    $commands[] = "unzip module_default.zip -d source/;";

    //change module name in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/Defaultmodule/'.$ModuleName.'/g" {} +; ';

    //change module name lower case in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/defaultmodule/'.$moduleName.'/g" {} +; ';

    //change namespace in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/Magestore/'.$Namespace.'/g" {} +; ';

    //change namespace lower case in files
    $commands[] = 'cd source; find * -name \*.* -exec sed -i "s/magestore/'.$namespace.'/g" {} +; ';

    //change folder name
    $commands[] = 'cd source; mv app/code/Magestore/ app/code/'.$Namespace.' ; ';

    //change folder name
    $commands[] = 'cd source; mv app/code/'.$Namespace.'/Defaultmodule app/code/'.$Namespace.'/'.$ModuleName.'; ';

    //zip created module
    $commands[] = "cd source; zip -r ../result/$fileName *;";

    //remove temp source files
    $commands[] = "cd source; rm -rf *;";

    //execute commands
    $output = shell_exec(implode(' ',$commands));

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
