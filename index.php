<?php
$Namespace = $_POST['namespace'];
$ModuleName = $_POST['module_name'];
if($ModuleName && $Namespace){
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
    $commands[] = 'find * -name \*.* -exec sed -i "s/Test/'.$ModuleName.'/g" {} \;';

    //change module name lower case in files
    $commands[] = 'find * -name \*.* -exec sed -i "s/test/'.$moduleName.'/g" {} \;';

    //change namespace in files
    $commands[] = 'find * -name \*.* -exec sed -i "s/Magentovn/'.$Namespace.'/g" {} \;';

    //change namespace lower case in files
    $commands[] = 'find * -name \*.* -exec sed -i "s/magentovn/'.$namespace.'/g" {} \;';

    //change folder name
    $commands[] = 'find . -depth -type d -name "Magentovn*" -exec mv {} source/app/code/'.$Namespace.' \;';

    //change folder name
    $commands[] = 'find . -depth -type d -name "Test*" -exec mv {} source/app/code/'.$Namespace.'/'.$ModuleName.' \;';

    //zip created module
    $commands[] = "cd source; zip -r ../result/$fileName *;";

    //remove temp source files
    $commands[] = "rm -Rf source/;";

    //execute commands
    foreach ($commands as $command){
        shell_exec($command);
    }

    //download zip file
    header("Location: $url");
    exit();
}
?>
<form action="index.php" method="post">
    <ul>
        <li><label for="namespace">Namespace</label></li>
        <li><input id="namespace" name="namespace" type="text"/></li>
        <li><label for="module_name">Module Name</label></li>
        <li><input id="module_name" name="module_name" type="text"/></li>
        <li><input type="submit" value="Download"/>
    </ul>
</form>
