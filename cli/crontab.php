<?php

/**
 * 另起进程，并关闭反馈。可以让上级调用不必等待这个进程的返回
 */
posix_setsid();
fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);

$uri = $_SERVER['argv'][1];
if (empty($uri)) {
    exit;
}

$file = __DIR__ . '/task.php';

exec('/usr/bin/env php ' . $file . ' request_uri="' . $uri . '"');
