<?php

namespace App\Support;

class Highlight
{
    /**
     * Adiciona <mark> ao redor do termo dentro do texto (case-insensitive).
     */
    public static function apply(?string $text, ?string $term): ?string
    {
        if (!$text || !$term) {
            return $text;
        }

        return preg_replace(
            '/(' . preg_quote($term, '/') . ')/i',
            '<mark>$1</mark>',
            $text
        );
    }
}

