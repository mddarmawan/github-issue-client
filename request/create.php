<?php

require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

if ($_POST) {
  $params = $_POST;
  $body = '';
  $body = $body . '##### What happened?';
  $body = $body . '
  ';
  $body = $body . $params['body'][0];
  $body = $body . '

  ';
  $body = $body . '##### How is the flow?';
  $body = $body . '
  ';
  $body = $body . $params['body'][1];
  $body = $body . '

  ';
  $body = $body . '##### What to expect?';
  $body = $body . '
  ';
  $body = $body . $params['body'][2];
  $curl = new Request([
    'username' => env('GITHUB_USERNAME'),
    'password' => env('GITHUB_PASSWORD'),
    'url' => 'https://api.github.com/repos/' . env('GITHUB_AUTHOR') . '/' . env('GITHUB_REPO') . '/issues',
    'fields' => [
      'title' => $params['title'],
      'body'  => $body,
      'labels' => [
        $params['type'],
      ],
    ],
  ]);
  $value = json_decode($curl->execute('create'));
  $result = [];

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

  echo json_encode([
    'status' => 'success',
    'message' => 'Success.',
    'data' => $result,
  ]);
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Failed.',
  ]);
}

?>