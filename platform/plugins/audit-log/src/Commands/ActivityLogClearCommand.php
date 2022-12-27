<?php

namespace Botble\AuditLog\Commands;

use Botble\AuditLog\Repositories\Interfaces\AuditLogInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cms:activity-logs:clear', 'Clear all activity logs')]
class ActivityLogClearCommand extends Command
{
    public function handle(AuditLogInterface $auditLogRepository): int
    {
        $this->info('Processing...');
        $count = $auditLogRepository->count();
        $auditLogRepository->getModel()->truncate();
        $this->info('Done. Deleted ' . $count . ' records!');

        return self::SUCCESS;
    }
}
