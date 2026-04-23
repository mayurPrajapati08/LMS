<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AuditLogger
{
    public static function record(
        string $action,
        Request $request,
        Model|string|null $target = null,
        array $context = []
    ): void {
        if (! Schema::hasTable('audit_logs')) {
            return;
        }

        $actor = $request->user();

        AuditLog::query()->create([
            'actor_id' => $actor instanceof Authenticatable ? $actor->getAuthIdentifier() : null,
            'action' => $action,
            'target_type' => $target instanceof Model ? $target::class : (is_string($target) ? $target : null),
            'target_id' => $target instanceof Model ? (string) $target->getKey() : null,
            'route_name' => optional($request->route())->getName(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
            'context' => $context,
        ]);
    }
}
