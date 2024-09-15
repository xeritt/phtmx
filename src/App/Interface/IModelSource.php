<?php

/**
 * Если источник данных для Input сама модель,
 * нужно для select
 */
interface IModelSource {
    public function setModelName($modelName): void;
}
