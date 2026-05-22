<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_home_featured' => 'boolean',
        'is_location_featured' => 'boolean',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function detailValues()
    {
        return $this->hasMany(PropertyDetailValue::class);
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Compact bed/bath/area summary for property cards. Sourced from
     * property_detail_values (matched by detail name keyword) with the
     * legacy bedrooms/bathrooms/area columns as a fallback so existing
     * rows that haven't been migrated to the dynamic detail system
     * still render correctly.
     */
    public function cardSummary(): array
    {
        $byName = $this->detailValues
            ->filter(fn ($dv) => $dv->detail && $dv->value !== null && $dv->value !== '')
            ->mapWithKeys(fn ($dv) => [strtolower($dv->detail->name) => $dv]);

        $pick = function (array $needles) use ($byName) {
            foreach ($byName as $key => $dv) {
                foreach ($needles as $needle) {
                    if (str_contains($key, $needle)) {
                        return $dv;
                    }
                }
            }
            return null;
        };

        $bed  = $pick(['bed']);
        $bath = $pick(['bath']);
        $area = $pick(['area', 'sft', 'size', 'sqft', 'square']);

        return [
            'bedrooms' => [
                'value' => $bed  ? $bed->value  : $this->bedrooms,
                'icon'  => $bed  && $bed->detail->icon  ? $bed->detail->icon  : 'fas fa-bed',
                'label' => 'Bed',
            ],
            'bathrooms' => [
                'value' => $bath ? $bath->value : $this->bathrooms,
                'icon'  => $bath && $bath->detail->icon ? $bath->detail->icon : 'fas fa-bath',
                'label' => 'Bath',
            ],
            'area' => [
                'value' => $area ? $area->value : $this->area,
                'icon'  => $area && $area->detail->icon ? $area->detail->icon : 'fas fa-ruler-combined',
                'label' => 'SFT',
            ],
        ];
    }
}
