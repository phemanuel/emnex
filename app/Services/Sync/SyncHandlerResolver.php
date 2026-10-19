<?php

namespace App\Services\Sync;

use App\Contracts\Sync\SyncHandler;
use InvalidArgumentException;
use App\Services\Sync\Handlers\ProductSyncHandler;
use App\Services\Sync\Handlers\UnitSyncHandler;
use App\Services\Sync\Handlers\TaxRateSyncHandler;
use App\Services\Sync\Handlers\DiscountSyncHandler;
use App\Services\Sync\Handlers\ProductCategorySyncHandler;
use App\Services\Sync\Handlers\BranchSyncHandler;
use App\Services\Sync\Handlers\TerminalSyncHandler;

class SyncHandlerResolver
{
    /**
     * Registered synchronization handlers.
     *
     * Entity name => Handler class
     */
    protected array $handlers = [

        'product' =>
            ProductSyncHandler::class,
        'unit' => 
            UnitSyncHandler::class,
        'tax_rate' => 
            TaxRateSyncHandler::class,
        'discount' => 
            DiscountSyncHandler::class,
        'product_category' => 
            ProductCategorySyncHandler::class,
        'branch' =>
            BranchSyncHandler::class,
        'terminal' =>
            TerminalSyncHandler::class,

    ];


    /**
     * Resolve the synchronization handler for an entity.
     */
    public function resolve(string $entity): SyncHandler
    {
        $entity = strtolower(trim($entity));

        if (!isset($this->handlers[$entity])) {
            throw new InvalidArgumentException(
                "No synchronization handler registered for entity [{$entity}]."
            );
        }

        $handlerClass = $this->handlers[$entity];

        $handler = app($handlerClass);

        if (!$handler instanceof SyncHandler) {
            throw new InvalidArgumentException(
                "Synchronization handler [{$handlerClass}] must implement SyncHandler."
            );
        }

        return $handler;
    }


    /**
     * Determine whether an entity has a registered handler.
     */
    public function supports(string $entity): bool
    {
        $entity = strtolower(trim($entity));

        return isset($this->handlers[$entity]);
    }
}