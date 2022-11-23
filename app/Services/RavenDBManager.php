<?php

namespace App\Services;

use RavenDB\Documents\DocumentStore;
use RavenDB\Http\GetDatabaseNamesResponse;
use RavenDB\ServerWide\DatabaseRecord;
use RavenDB\ServerWide\Operations\CreateDatabaseOperation;
use RavenDB\ServerWide\Operations\DeleteDatabasesOperation;
use RavenDB\ServerWide\Operations\GetDatabaseNamesOperation;

class RavenDBManager
{

    private array $stores = [];

    public function getStore(?string $database = null): DocumentStore
    {
        $database = $database ?? $this->defaultDatabase();

        if (array_key_exists($database, $this->stores)) {
            return $this->stores[$database];
        }

        $store = new DocumentStore([$this->defaultUrl()], $database);
        $store->initialize();

        $this->stores[$database] = $store;

        return $store;
    }

    private function defaultUrl(): string
    {
        return "http://raven.db:8080";
    }

    private function defaultDatabase(): string
    {
        return "Northwind";
    }

    public function removeDatabaseIfExists(?string $database = null)
    {
        $store = $this->getStore($database);

        $store->maintenance()->server()->send(new DeleteDatabasesOperation($store->getDatabase(), true));

    }

    public function createDatabase(?string $database = null)
    {
        $store = $this->getStore($database);

        $databaseRecord = new DatabaseRecord();
        $databaseRecord->setDatabaseName($store->getDatabase());

        $createDatabaseOperation = new CreateDatabaseOperation($databaseRecord);
        $store->maintenance()->server()->send($createDatabaseOperation);
    }

    public function databaseExists(?string $database = null): bool
    {
        $store = $this->getStore($database);

        $operation = new GetDatabaseNamesOperation(0, 100);

        /** @var GetDatabaseNamesResponse $response */
        $response = $store->maintenance()->server()->send($operation);

        $databaseNames = $response->getDatabases();

        return in_array($store->getDatabase(), $databaseNames);
    }

}
