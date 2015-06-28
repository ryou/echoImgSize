<?php

/*
■概要
任意のディレクトリ内の画像を、pタグで囲まれたimg要素として吐き出すスクリプト

■使用法

php [スクリプト名] [src属性に使うディレクトリパス] [画像サイズ半減フラグ]
ex: php main.php ./images/ false

*/

$g_targetPath = '';
if (isset($argv[1])) {
    $g_targetPath = $argv[1];
} else {
    echo "set the target directory path\n";
    exit;
}

$g_halfSizeFlag = false;
if (isset($argv[2])) {
    $g_halfSizeFlag = $argv[2];
}

if ($handle = opendir('./')) {
    while ( ($filename = readdir($handle)) !== false ) {
        $tmp = explode('.', $filename);
        $ext = $tmp[count($tmp)-1];
        if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif') {
            // 出力処理
            $imgSizeData = getimagesize($filename);
            $imgWidth    = $imgSizeData[0];
            $imgHeight   = $imgSizeData[1];
            if ($g_halfSizeFlag) {
                $imgWidth  /= 2;
                $imgHeight /= 2;
            }
            echo "<p><img src=\"{$g_targetPath}{$filename}\" alt=\"\" width=\"{$imgWidth}\" height=\"{$imgHeight}\"></p>\n";
        }
    }

    closedir($handle);
} else {
    echo "cannot open target directory '{$g_targetPath}'\n";
    exit;
}
