<?php
function displayDate($date)
{
  if ($date == date("Y-m-d")) {
    $date = "Today";
    return $date;
  } else if ($date == date("Y-m-d", strtotime("-1 day"))) {
    $date = "Yesterday";
    return $date;
  } else {
    $month = date("F", strtotime($date));
    $day = date("d", strtotime($date));
    $date = $month . " " . $day;
    return $date;
  }
}
