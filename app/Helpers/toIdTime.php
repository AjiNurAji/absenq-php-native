<?php

function toIDTime($datetime)
{
  if (!$datetime)
    return null;

  $dt = new DateTime($datetime, new DateTimeZone('UTC'));
  $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));

  return $dt->format('d-m-Y H:i:s');
}
