<?php

function getCode($model)
{
  $coupon = $model::all()->last();
  $code = $coupon->code;
  $str = substr($code,0,-2);
  $num = substr($code,-2);
  $num = (int)$num;
  $new_num = $num+1;
  if ($new_num<10) {
    return $str."0$new_num";
  }else{
    return $str."$new_num";
  }
}

function convertToInput($imageUrl)
{
  $words = explode('/',$imageUrl);
  $image = array_pop($words);
  return $image;
}

function convertRate($amount, $rate)
{
  // return round($amount*$rate, 2);
  return round($amount/$rate);
}
