<?php
header('Content-Type: application/json');

// 读取 user_data.json 内容
$file = __DIR__ . '/user_data.json';
if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    echo $jsonData;
} else {
    http_response_code(404);
    echo json_encode(['message' => '数据文件未找到']);
}
?>
