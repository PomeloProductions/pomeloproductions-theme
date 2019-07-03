<?php
declare(strict_types=1);


namespace PomeloProductions\Contracts;

/**
 * Interface IsACFFieldContract
 * @package PomeloProductions\Contracts
 */
interface IsACFFieldContract
{
    /**
     * Exports the ACF configuration
     *
     * @return array
     */
    public function export(): array;
}