<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Shanghai'); //设置时区为上海时间
// 获取POST请求中的数据
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 获取用户的 IP 地址
$ip_address = $_SERVER['REMOTE_ADDR'];

if ($data && isset($data['user_data'])) {
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip_address' => $ip_address,
        'user_data' => $data['user_data']
    ];

    // 指定文件路径
    $file = __DIR__ . '/user_data.json';
    $currentData = [];

    // 读取现有的数据
    if (file_exists($file)) {
        $currentData = json_decode(file_get_contents($file), true);
    }

    // 添加新的数据
    $currentData[] = $logEntry;

    // 写入到 JSON 文件
    if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
        echo json_encode(['message' => '数据成功存储']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => '数据存储失败']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => '无效的数据']);
}
?>
