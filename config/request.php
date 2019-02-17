<?php

class Request extends Config
{
  private $ch;
  private $result;

  public function __construct($attributes)
  {
    foreach ($attributes as $property => $value) {
      $this->$property = $value;
    }
  }

  private function open()
  {
    $this->ch = curl_init();
  }

  private function close()
  {
    curl_close($this->ch);
  }

  public function execute($command)
  {
    $this->open();

    switch ($command) {
      case 'create':
        $this->create();

        break;

      case 'read':
        $this->read();

        break;
      
      default:
        return json_encode(['message'=>'Not found.']);

        break;
    }

    $this->result = curl_exec($this->ch);
    $this->close();
    
    return $this->result;
  }

  private function read()
  {
    curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($this->ch, CURLOPT_URL, $this->url);
    curl_setopt($this->ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
    curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
  }

  private function create()
  {
    curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($this->ch, CURLOPT_URL, $this->url);
    curl_setopt($this->ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
    curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($this->ch, CURLOPT_POST, 'POST');
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->fields)); 
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
  }
}

?>