<?php

namespace App\Config;

use App\Models\Setting;
use Illuminate\Support\Arr;
use InvalidArgumentException;
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
        parent::__construct($items);
    }

    public function set($key, $value = null)
    {
        parent::set($key, $value);

        $this->recordSettingsChanged($key, $value);
    }

    public function loadSettingsData($force = false)
    {
        if ($force || is_null($data = cache('config_settings'))) {
            $this->updateSettingsCache();
            $data = cache('config_settings', []);
        }

        Arr::set($this->items, 'settings', $data);
    }

    protected function recordSettingsChanged($key, $value)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $_key => $v) {
            $_keys = explode('.', $_key);
            $settingsKey = array_shift($_keys);

            if ($settingsKey == 'settings') {

                if (count($_keys) === 0 && !$this->has('settings')) {
                    throw new InvalidArgumentException(
                        "Can not change whole config by 'settings' key."
                    );
                }

                $keyName = array_shift($_keys);

                if ($keyName) {
                    $this->settingsChanged[] = $keyName;
                }
            }
        }
    }

    public function __destruct()
    {
        if ( ! empty($this->settingsChanged)) {
            $this->storeSettingsChanged();

            $this->updateSettingsCache();
        }
    }

    protected function storeSettingsChanged()
    {
        foreach ($this->settingsChanged as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $this->get('settings.' . $key)]);
        }
    }

    public function updateSettingsCache()
    {
        $items = Setting::all()
            ->keyBy('key')
            ->map(function($setting) {
                return $setting->value;
            })
            ->toArray();

        cache(['config_settings' => $items]);
    }
}
