<?php

namespace App\Http\Controllers\Admin\Api\Module;

use App\Http\Controllers\Controller;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{

    public function index()
    {
        $modules = Module::toCollection()
            ->map(function($module) {
                return [
                    'name' => $module->getName(),
                    'alias' => $module->getAlias(),
                    'description' => $module->getDescription(),
                    'keywords' => $module->get('keywords'),
                    'enabled' => $module->isEnabled(),
                ];
            })->toArray();
        return array_values($modules);
    }
}
