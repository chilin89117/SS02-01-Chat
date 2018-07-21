<?php
namespace App\Listeners;
use App\Events\ChatEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChatListener
{
  public function __construct()
  {
    //
  }

  public function handle(ChatEvent $event)
  {
    //
  }
}
