<?php

namespace tiagomichaelsousa\LaravelResources\Generators;

interface Generator
{
    public function __construct($model);

    public function getStub();

    public function replacements();

    public function fileAlreadyExists($path);

    public function directoryExists($path);

    public function className();

    public function fileName();

    public function handle();
}
