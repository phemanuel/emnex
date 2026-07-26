<?php

namespace App\Services;

use App\Models\DocumentSequence;
use Illuminate\Support\Facades\DB;

class DocumentNumberService
{
    /**
     * Generate the next document number.
     *
     * @param string $documentType
     * @param int|null $companyId
     * @return string
     */
    public static function generate(string $documentType, ?int $companyId = null): string
    {
        $companyId ??= companyId();

        return DB::transaction(function () use ($companyId, $documentType) {

            $sequence = DocumentSequence::lockForUpdate()
                ->where('company_id', $companyId)
                ->where('document_type', $documentType)
                ->where('status', true)
                ->first();

            if (!$sequence) {
                throw new \Exception(
                    "Document sequence '{$documentType}' does not exist."
                );
            }

            self::resetSequenceIfRequired($sequence);

            $number = $sequence->current_number;

            $sequence->increment('current_number');

            return self::formatNumber($sequence, $number);
        });
    }

    /**
     * Format document number.
     */
    protected static function formatNumber($sequence, int $number): string
    {
        $parts = [];

        if (!empty($sequence->prefix)) {
            $parts[] = $sequence->prefix;
        }

        // Optional date
        if (!empty($sequence->use_date_in_sequence)) {
            $parts[] = now()->format('Ymd');
        }

        $parts[] = str_pad(
            $number,
            $sequence->number_length,
            '0',
            STR_PAD_LEFT
        );

        $document = implode(
            $sequence->separator,
            $parts
        );

        if (!empty($sequence->suffix)) {
            $document .= $sequence->separator . $sequence->suffix;
        }

        return $document;
    }

    /**
     * Reset sequence if necessary.
     */
    protected static function resetSequenceIfRequired($sequence): void
    {
        $today = now();

        $lastUpdate = $sequence->updated_at;

        switch ($sequence->reset_frequency) {

            case 'Daily':

                if (!$lastUpdate || $lastUpdate->toDateString() !== $today->toDateString()) {
                    $sequence->update([
                        'current_number' => 1
                    ]);
                }

                break;

            case 'Monthly':

                if (
                    !$lastUpdate ||
                    $lastUpdate->format('Ym') !== $today->format('Ym')
                ) {
                    $sequence->update([
                        'current_number' => 1
                    ]);
                }

                break;

            case 'Yearly':

                if (
                    !$lastUpdate ||
                    $lastUpdate->year !== $today->year
                ) {
                    $sequence->update([
                        'current_number' => 1
                    ]);
                }

                break;

            default:
                break;
        }
    }
}