<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait EncryptsAttributes
{
    /**
     * Lista atrybutów do szyfrowania
     */
    protected $encryptedAttributes = [];

    /**
     * Boot the trait
     */
    protected static function bootEncryptsAttributes()
    {
        static::saving(function ($model) {
            $model->encryptAttributes();
        });

        static::retrieved(function ($model) {
            $model->decryptAttributes();
        });
    }

    /**
     * Szyfruje atrybuty przed zapisem
     */
    protected function encryptAttributes()
    {
        foreach ($this->encryptedAttributes as $attribute) {
            if (isset($this->attributes[$attribute]) && !empty($this->attributes[$attribute])) {
                $this->attributes[$attribute] = Crypt::encryptString($this->attributes[$attribute]);
            }
        }
    }

    /**
     * Deszyfruje atrybuty po pobraniu z bazy
     */
    protected function decryptAttributes()
    {
        foreach ($this->encryptedAttributes as $attribute) {
            if (isset($this->attributes[$attribute]) && !empty($this->attributes[$attribute])) {
                try {
                    $this->attributes[$attribute] = Crypt::decryptString($this->attributes[$attribute]);
                } catch (\Exception $e) {
                    // Jeśli deszyfrowanie się nie powiedzie, zostaw oryginalną wartość
                    // (może to być stary rekord przed szyfrowaniem)
                }
            }
        }
    }

    /**
     * Pobiera zdeszyfrowaną wartość atrybutu
     */
    public function getDecryptedAttribute($attribute)
    {
        if (isset($this->attributes[$attribute]) && !empty($this->attributes[$attribute])) {
            try {
                return Crypt::decryptString($this->attributes[$attribute]);
            } catch (\Exception $e) {
                return $this->attributes[$attribute];
            }
        }
        return null;
    }

    /**
     * Ustawia zaszyfrowaną wartość atrybutu
     */
    public function setEncryptedAttribute($attribute, $value)
    {
        if (!empty($value)) {
            $this->attributes[$attribute] = Crypt::encryptString($value);
        } else {
            $this->attributes[$attribute] = $value;
        }
    }
}
