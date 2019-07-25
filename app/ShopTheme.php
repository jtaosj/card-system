<?php
namespace App; use Illuminate\Database\Eloquent\Model; class ShopTheme extends Model { protected $guarded = array(); public $timestamps = false; protected $casts = array('options' => 'array', 'config' => 'array'); private static $default_theme; public static function defaultTheme() { if (!static::$default_theme) { static::$default_theme = ShopTheme::query()->where('name', \App\System::_get('shop_theme_default', 'Material'))->first(); if (!static::$default_theme) { static::$default_theme = ShopTheme::query()->firstOrFail(); } } return static::$default_theme; } public static function freshList() { $sp678350 = realpath(app_path('..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'shop_theme')); \App\ShopTheme::query()->get()->each(function ($sp898972) use($sp678350) { if (!file_exists($sp678350 . DIRECTORY_SEPARATOR . $sp898972->name . DIRECTORY_SEPARATOR . 'config.php')) { $sp898972->delete(); } }); foreach (scandir($sp678350) as $sp415267) { if ($sp415267 === '.' || $sp415267 === '..') { continue; } try { @($sp898972 = (include $sp678350 . DIRECTORY_SEPARATOR . $sp415267 . DIRECTORY_SEPARATOR . 'config.php')); } catch (\Exception $sp696863) { continue; } $sp898972['config'] = array_map(function ($spdb8903) { return $spdb8903['value']; }, @$sp898972['options'] ?? array()); $spa445a0 = \App\ShopTheme::query()->where('name', $sp415267)->first(); if ($spa445a0) { $spa445a0->description = $sp898972['description']; $spa445a0->options = @$sp898972['options'] ?? array(); $spa445a0->config = ($spa445a0->config ?? array()) + $sp898972['config']; $spa445a0->saveOrFail(); } else { if ($sp898972 && isset($sp898972['description'])) { \App\ShopTheme::query()->create(array('name' => $sp415267, 'description' => $sp898972['description'], 'options' => @$sp898972['options'] ?? array(), 'config' => $sp898972['config'])); } } } } }