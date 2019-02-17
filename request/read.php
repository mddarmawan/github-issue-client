<?php

require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$curl = new Request([
  'username' => env('GITHUB_USERNAME'),
  'password' => env('GITHUB_PASSWORD'),
  'url' => 'https://api.github.com/repos/' . env('GITHUB_AUTHOR') . '/' . env('GITHUB_REPO') . '/issues?state=all',
  'fields' => [
    'title' => 'Eleventh issues.',
    'body'  => 'With body!',
    'labels' => [
      'bug',
    ],
  ],
]);
$response = json_decode($curl->execute('read'));
$result = [];

foreach ($response as $key => $value) {
  $result[$key] = [
    'title' => $value->title,
    'state' => $value->state,
    'body'  => $value->body,
    'number' => $value->number,
  ];

  foreach ($value->labels as $label) {
    $result[$key]['labels'][] = [
      'name' => $label->name,
      'color' => $label->color,
    ];
  }
}

echo json_encode([
  'status' => 'success',
  'message' => 'Success.',
  'data' => $result,
]);

?>