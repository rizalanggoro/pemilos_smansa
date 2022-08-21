<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;
    protected $fillable = ["key", "value"];

    public static function set($key, $value)
    {
        Configuration::create([
            "key" => $key,
            "value" => $value,
        ]);
    }

    public static function replace($key, $value)
    {
        $configuration = Configuration::where("key", $key)->first();
        if ($configuration) {
            $configuration->value = $value;
            $configuration->save();
        }
    }

    public static function get($key)
    {
        $config = Configuration::where("key", $key)->first();
        if ($config) {
            return $config->value;
        } else {
            return null;
        }
    }
}
