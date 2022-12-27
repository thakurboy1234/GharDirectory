<?php

namespace Botble\Base\Events;

use Eloquent;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class BeforeEditContentEvent extends Event
{
    use SerializesModels;

    public Request $request;

    /**
     * @var Eloquent|false
     */
    public $data;

    public function __construct(Request $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }
}
