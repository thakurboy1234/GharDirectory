<?php

namespace Botble\Base\Events;

use Eloquent;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class CreatedContentEvent extends Event
{
    use SerializesModels;

    public string $screen;

    public Request $request;

    /**
     * @var Eloquent|false
     */
    public $data;

    public function __construct($screen, $request, $data)
    {
        $this->screen = $screen;
        $this->request = $request;
        $this->data = $data;
    }
}
