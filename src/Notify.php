<?php

namespace Pitchanon\Line;

Class Notify {

  const LINE_API = "https://notify-api.line.me/api/notify";

  private static $line;

  public function __construct(array $config) {
    if (!isset(self::$line) || empty(self::$line)) {
      self::$line = $config;
    }
    return self::$line;
  }

  /**
   * Notify_message.
   *
   * @param string $message Message.
   * @param string $token Line token.
   *
   * @return bool|string
   */
  public static function NotifyMessage(string $message) {
    $queryData = ['message' => $message];
    $queryData = http_build_query($queryData, '', '&');
    $headerOptions = [
      'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" . "Authorization: Bearer " . self::$line["token"] . "\r\n" . "Content-Length: " . strlen($queryData) . "\r\n",
        'content' => $queryData,
      ],
    ];
    $context = stream_context_create($headerOptions);
    $result = file_get_contents(self::LINE_API, FALSE, $context);
    return $result;
  }

}

