<?php

    if (!file_exists('config/build.json')) {
        
        $connection = DB::connToDB();
        MyPDO::execSQLFromFile(ROOT . '/config/camagru.sql', $connection);
        $connection = null;

        $str = '{"build":"true", "date":"';
        $str .= $date = date('Y-m-d_H:i:s');
        $str .= '"}';
        
        file_put_contents('config/build.json', $str);
    }

?>