<?php

namespace App\Domain\Task\Index;

use RavenDB\Documents\Indexes\AbstractJavaScriptIndexCreationTask;
use RavenDB\Documents\Indexes\AdditionalSourcesArray;

class TaskByDateAddedIndex extends AbstractJavaScriptIndexCreationTask
{
    public function __construct()
    {
        parent::__construct();

        $this->setMaps(["map('Tasks', function(t){ return { createdAt: t.createdAt.substring(0,10), tasks: [ expandedTask(t) ]}})"]);

        $this->setReduce("groupBy(x => x.createdAt).aggregate(g => { return { createdAt: g.key, tasks: g.values.reduce((acc, value) => acc.concat(value.tasks), [])}; })");

        $additionalSources = new AdditionalSourcesArray();
        $additionalSources->offsetSet("The Script", "function expandedTask(t) { t.id = t[\"@metadata\"][\"@id\"]; return t;}");
        $this->setAdditionalSources($additionalSources);
    }
}
