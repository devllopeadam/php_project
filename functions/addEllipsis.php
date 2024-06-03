<?php

function addEllipsis($string, $maxLength = 30)
{
  if (strlen($string) > $maxLength) {
    return substr($string, 0, $maxLength) . '...';
  }
  return $string;
}
