<?php 

include_once '../extractDataFromDB.php';


// if (!isset($_GET['request'])) {
//     header("Location: unauthorized.php");
//     return;
// }

function GetItems($page = 1, $pageSize = 15)
{
    $offset = ($page - 1) * $pageSize;
    $pageSize = (int)$pageSize;
    $offset = (int)$offset;

    return executeQueryWReturn(
        "SELECT item.id,
            item.name,
            item.smallDescription,
            item.sprite,
            item.category,
            item.pocket,
            item.effect
       FROM item
        LIMIT $pageSize OFFSET $offset",
        null
    );
}

include_once '../extractDataFromDB.php';

function rechercheItems($name = '', $category = '', $page = 1, $pageSize = 15)
{
    $offset = ($page - 1) * $pageSize;
    $params = [];
    $where = [];

    if ($name !== '') {
        $where[] = 'UPPER(item.name) LIKE :name';
        $params[':name'] = '%' . strtoupper($name) . '%';
    }
    if ($category !== '' && strtoupper($category) !== 'ALL') {
        $where[] = 'UPPER(item.category) = :category';
        $params[':category'] = strtoupper($category);
    }

    $whereClause = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql = "SELECT item.id, item.name, item.smallDescription, item.sprite, item.category, item.pocket, item.effect
            FROM item
            $whereClause
            LIMIT $pageSize OFFSET $offset";

    return executeQueryWReturn($sql, $params);
}

switch ($_GET['request']) {
    case 'SearchItems':
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 15;
        echo json_encode(rechercheItems($name, $category, $page, $pageSize));
        return;
}

// switch ($_GET['request']) {
//     case 'GetItems':
//         $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//         $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 15;
//         echo json_encode(GetItems($page, $pageSize));
//         return;    
// }
