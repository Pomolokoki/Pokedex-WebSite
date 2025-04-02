<?php
function addDataUpdate($file, $table, $column)
{
    if (file_exists($file))
    {
        $data = explode("///", file_get_contents($file));
        var_dump($data);
        $content = '';
        for ( $i = 0; $i < count($data); $i++ )
        {
            $content .= '$sqlAddBonusData .= `UPDATE ' . $table . ' SET '. $column . '=CONCAT(SUBSTRING('. $column . ', 1, POSITION(\'///NULL\' IN '. $column . ')+2),"' . str_replace('"', '\"', $data[$i]) . '") WHERE id=' . $i + 1 . "`;\n";
            //$content .= 'UPDATE ' . $table . ' SET '. $column . '=CONCAT(SUBSTRING('. $column . ', 1, POSITION(\'///NULL\' IN '. $column . ')+2),"' . str_replace('"', '\"', $data[$i]) . '") WHERE id=' . $i + 1 . ";\n";
        }
        file_put_contents('addData.php', $content);
    }
}
include_once 'addData.php';
?>