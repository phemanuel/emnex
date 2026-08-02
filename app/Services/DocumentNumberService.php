<?php

namespace App\Services;

use App\Models\DocumentSequence;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DocumentNumberService
{
    /**
     * Generate the next document number.
     */
    public static function generate(
        string $documentType,
        ?int $companyId = null
    ): string {
        $companyId ??= companyId();

        return DB::transaction(function () use (
            $companyId,
            $documentType
        ) {

            $sequence = DocumentSequence::lockForUpdate()
                ->where('company_id', $companyId)
                ->where('document_type', $documentType)
                ->where('status', true)
                ->first();

            if (! $sequence) {
                throw new RuntimeException(
                    "Document sequence '{$documentType}' is unavailable."
                );
            }

            self::resetSequenceIfRequired($sequence);

            $number = $sequence->current_number;

            $sequence->increment('current_number');

            return self::formatNumber(
                $sequence,
                $number
            );
        });
    }

    /**
     * Preview the next document number
     * without incrementing the sequence.
     */
    public static function preview(
        string $documentType,
        ?int $companyId = null
    ): string {
        $companyId ??= companyId();

        $sequence = DocumentSequence::where(
                'company_id',
                $companyId
            )
            ->where(
                'document_type',
                $documentType
            )
            ->where(
                'status',
                true
            )
            ->first();

        if (! $sequence) {

            throw new RuntimeException(
                "Document sequence '{$documentType}' is unavailable."
            );

        }

        self::resetSequenceIfRequired($sequence);

        return self::formatNumber(
            $sequence,
            $sequence->current_number
        );
    }

    /**
     * Format a document number.
     */
    protected static function formatNumber(
        DocumentSequence $sequence,
        int $number
    ): string {

        $parts = [];

        if (! empty($sequence->prefix)) {

            $parts[] = $sequence->prefix;

        }

        $parts[] = str_pad(

            $number,

            $sequence->number_length,

            '0',

            STR_PAD_LEFT

        );

        if (! empty($sequence->suffix)) {

            $parts[] = $sequence->suffix;

        }

        return implode(

            $sequence->separator,

            $parts

        );
    }

    /**
     * Reset the sequence when required.
     */
    protected static function resetSequenceIfRequired(
        DocumentSequence $sequence
    ): void {

        if ($sequence->reset_frequency === 'Never') {
            return;
        }

        $today = now();

        $lastReset = $sequence->last_reset_at;

        $shouldReset = false;

        switch ($sequence->reset_frequency) {

            case 'Daily':

                $shouldReset = ! $lastReset
                    || $lastReset->toDateString()
                    !== $today->toDateString();

                break;

            case 'Monthly':

                $shouldReset = ! $lastReset
                    || $lastReset->format('Ym')
                    !== $today->format('Ym');

                break;

            case 'Yearly':

                $shouldReset = ! $lastReset
                    || $lastReset->year
                    !== $today->year;

                break;

        }

        if ($shouldReset) {

            $sequence->update([

                'current_number' => 1,

                'last_reset_at' => now(),

            ]);

            $sequence->refresh();

        }
    }
}