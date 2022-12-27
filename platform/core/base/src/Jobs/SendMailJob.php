<?php

namespace Botble\Base\Jobs;

use Botble\Base\Supports\EmailAbstract;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public ?string $content;

    public ?string $title;

    public string|array|null $to;

    public array $args;

    public bool $debug = false;

    public function __construct(?string $content, ?string $title, $to, array $args, bool $debug = false)
    {
        $this->content = $content;
        $this->title = $title;
        $this->to = $to;
        $this->args = $args;
        $this->debug = $debug;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->to)->send(new EmailAbstract($this->content, $this->title, $this->args));
        } catch (Exception $exception) {
            if ($this->debug) {
                throw $exception;
            }
            Log::error($exception->getMessage());
        }
    }
}
