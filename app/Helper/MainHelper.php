<?php

namespace App\Helper;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainHelper 
{
  public $maxKeyLenght = 9;
  public $maxIdLenght = 15;

  public function generateId($key = 'SYS', $lenght = 12)
  {
    if (strlen($key) > $this->maxKeyLenght) {
      $key = strtoupper(substr($key, 0, $this->maxKeyLenght));
    }

    $id = $key;
    $lenghtId = strlen($id);
    
    if ($lenghtId < $this->maxIdLenght) {
      $id .= rand(1000, 9999);
      $id .= rand(1000, 9999);
      $id .= rand(1000, 9999);
    }

    return substr($id, 0, $this->maxIdLenght);
  }
}
