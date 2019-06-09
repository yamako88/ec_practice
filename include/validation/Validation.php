<?php

class Validation
{

  public function __construct()
  {

  }

  

  public function checkEmpty($value) {
      if ($value === '') {
          return FALSE;
      } else {
          return TRUE;
      }
  }

  public function checkHalfwidthAlphanumeric($value) {
      if (preg_match('/\A[a-z\d]{6,16}+\z/i', $value) !==1) {
          return FALSE;
      } else {
          return TRUE;
      }
  }

    public function checkLength($value, $length) {
        if (mb_strlen($value) > $length) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkSpace($value) {
        if (preg_match('/^[\s　]+$/', $value) === 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkNumberIsValid($value, $length) {
        if (preg_match('/^[0-9]{1,' . $length . '}$/', $value) !== 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkBoolean($status) {
        if (preg_match('/^[01]$/', $status) !== 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
