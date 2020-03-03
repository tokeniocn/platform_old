<?php

namespace App\Settings;

use Cache;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Config\Repository as ConfigRepository;

class Repository extends ConfigRepository
{
    protected $settingsChanged = [];

    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        parent::__construct(array_merge($this->loadData(), $items));
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->items, $key, $value);

            $_keys = explode('.', $key);
            $this->settingsChanged[] = array_shift($_keys);
        }
    }

    public function loadData($force = false)
    {
        if ($force || is_null($data = Cache::get('config_settings'))) {
            $this->refreshSettingsCache(); // TODO  解决 composer install时的刷新找不到数据库问题
            $data = Cache::get('config_settings', []);
        }

        return $data;
    }

    public function __destruct()
    {
        if ( ! empty($this->settingsChanged)) {
            $this->storeChangedSettings();

            $this->refreshSettingsCache();
        }
    }

    protected function storeChangedSettings()
    {
        foreach ($this->settingsChanged as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $this->get('settings.' . $key)]);
        }
    }

    public function refreshSettingsCache()
    {
        $items = Setting::all()
            ->keyBy('key')
            ->map(function($setting) {
                return $setting->value;
            })
            ->toArray();

        Cache::forever('config_settings', $items);
    }
}
