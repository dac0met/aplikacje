<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

trait GeneratesSearchHashes
{
    /**
     * Lista atrybutów do generowania hashów wyszukiwania
     */
    protected $searchableAttributes = [];

    /**
     * Generuje hash dla wyszukiwania z podanego tekstu
     * Używa kombinacji różnych algorytmów hashujących dla lepszego bezpieczeństwa
     */
    public function generateSearchHash($text)
    {
        if (empty($text)) {
            return null;
        }

        // Normalizacja tekstu - usuwamy znaki specjalne, spacje, konwertujemy na małe litery
        $normalized = $this->normalizeTextForSearch($text);
        
        // Generujemy hash używając kombinacji algorytmów
        // Używamy SHA-256 z solą dla bezpieczeństwa
        $salt = config('app.key'); // Używamy APP_KEY jako sól
        $hash = hash('sha256', $normalized . $salt);
        
        return $hash;
    }

    /**
     * Normalizuje tekst do wyszukiwania
     */
    protected function normalizeTextForSearch($text)
    {
        if (empty($text)) {
            return '';
        }
        
        // Usuwamy polskie znaki diakrytyczne
        $text = $this->removeDiacritics($text);
        
        // Konwertujemy na małe litery
        $text = strtolower(trim($text));
        
        // Usuwamy wszystkie znaki specjalne i spacje
        $text = preg_replace('/[^a-z0-9]/', '', $text);
        
        return $text;
    }

    /**
     * Usuwa polskie znaki diakrytyczne
     */
    protected function removeDiacritics($text)
    {
        $diacritics = [
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z'
        ];
        
        return strtr($text, $diacritics);
    }

    /**
     * Generuje hash dla wyszukiwania częściowego (dla każdego słowa)
     * Pozwala na wyszukiwanie po części imienia/nazwiska
     */
    public function generatePartialSearchHashes($text)
    {
        if (empty($text)) {
            return [];
        }

        $hashes = [];
        
        // Generujemy hash dla całego tekstu (oryginalnego)
        $hashes[] = $this->generateSearchHash($text);
        
        // Generujemy hash dla znormalizowanego tekstu
        $normalized = $this->normalizeTextForSearch($text);
        if (!empty($normalized)) {
            $hashes[] = $this->generateSearchHash($normalized);
        }

        // Generujemy hash dla każdego słowa osobno (z oryginalnego tekstu)
        $originalWords = explode(' ', trim($text));
        foreach ($originalWords as $word) {
            if (strlen(trim($word)) >= 2) {
                $hashes[] = $this->generateSearchHash(trim($word));
            }
        }

        // Generujemy hash dla prefiksów (pierwsze 3, 4, 5 znaków z znormalizowanego tekstu)
        if (!empty($normalized)) {
            for ($i = 3; $i <= min(5, strlen($normalized)); $i++) {
                $prefix = substr($normalized, 0, $i);
                $hashes[] = $this->generateSearchHash($prefix);
            }
        }

        return array_unique(array_filter($hashes));
    }

    /**
     * Sprawdza czy podany tekst pasuje do hashów wyszukiwania
     */
    public function matchesSearchHashes($searchText, $storedHashes)
    {
        if (empty($searchText) || empty($storedHashes)) {
            return false;
        }

        $searchHashes = $this->generatePartialSearchHashes($searchText);
        
        // Sprawdzamy czy którykolwiek z hashów wyszukiwania pasuje do przechowywanych
        return !empty(array_intersect($searchHashes, $storedHashes));
    }

    /**
     * Konwertuje tablicę hashów na string do przechowania w bazie
     */
    public function hashesToString($hashes)
    {
        return implode(',', array_unique($hashes));
    }

    /**
     * Konwertuje string z hashów z powrotem na tablicę
     */
    public function stringToHashes($hashString)
    {
        if (empty($hashString)) {
            return [];
        }
        
        return array_filter(explode(',', $hashString));
    }

    /**
     * Statyczna metoda do generowania hash dla wyszukiwania częściowego
     */
    public static function generatePartialSearchHashesStatic($text)
    {
        if (empty($text)) {
            return [];
        }

        $hashes = [];
        
        // Generujemy hash dla całego tekstu (oryginalnego)
        $hashes[] = static::generateSearchHashStatic($text);
        
        // Generujemy hash dla znormalizowanego tekstu
        $normalized = static::normalizeTextForSearchStatic($text);
        if (!empty($normalized)) {
            $hashes[] = static::generateSearchHashStatic($normalized);
        }

        // Generujemy hash dla każdego słowa osobno (z oryginalnego tekstu)
        $originalWords = explode(' ', trim($text));
        foreach ($originalWords as $word) {
            if (strlen(trim($word)) >= 2) {
                $hashes[] = static::generateSearchHashStatic(trim($word));
            }
        }

        // Generujemy hash dla prefiksów (pierwsze 3, 4, 5 znaków z znormalizowanego tekstu)
        if (!empty($normalized)) {
            for ($i = 3; $i <= min(5, strlen($normalized)); $i++) {
                $prefix = substr($normalized, 0, $i);
                $hashes[] = static::generateSearchHashStatic($prefix);
            }
        }

        return array_unique(array_filter($hashes));
    }

    /**
     * Statyczna metoda do generowania hash dla wyszukiwania
     */
    public static function generateSearchHashStatic($text)
    {
        if (empty($text)) {
            return null;
        }

        $normalized = static::normalizeTextForSearchStatic($text);
        $salt = config('app.key');
        $hash = hash('sha256', $normalized . $salt);
        
        return $hash;
    }

    /**
     * Statyczna metoda do normalizacji tekstu
     */
    protected static function normalizeTextForSearchStatic($text)
    {
        if (empty($text)) {
            return '';
        }
        
        $text = static::removeDiacriticsStatic($text);
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]/', '', $text);
        
        return $text;
    }

    /**
     * Statyczna metoda do usuwania polskich znaków diakrytycznych
     */
    protected static function removeDiacriticsStatic($text)
    {
        $diacritics = [
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z'
        ];
        
        return strtr($text, $diacritics);
    }
}
