<?php

namespace App\Listeners;

use App\Events\ModelAction;
use Illuminate\Support\Facades\Log;

class LogModelAction
{
    public function handle(ModelAction $event)
    {
        $action = $event->action;
        $modelName = get_class($event->model);
        $userId = $event->user->id;
        
        Log::info("User {$userId} {$action} {$modelName}");
    }
}
