<?php

namespace app\Chat\Facades;

use Illuminate\Support\Facades\Facade;

class ChatAuth extends Facade {
   protected static function getFacadeAccessor() { return 'ChatMessages'; }
}