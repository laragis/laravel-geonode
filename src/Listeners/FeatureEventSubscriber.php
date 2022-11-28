<?php
namespace TungTT\LaravelGeoNode\Listeners;

use App\Models\MapFeature;
use TungTT\LaravelGeoNode\Events\FeatureCreated;
use TungTT\LaravelGeoNode\Events\FeatureDeleted;
use TungTT\LaravelGeoNode\Events\FeatureUpdated;

class FeatureEventSubscriber
{
    public function handleFeatureCreated($event) {

    }

    public function handleFeatureUpdated($event) {

    }

    public function handleFeatureDeleted($event) {
        MapFeature::where('feature_id', $event->featureId)->get()->each->delete();
    }

    public function subscribe($events)
    {
        return [
            FeatureCreated::class => 'handleFeatureCreated',
            FeatureUpdated::class => 'handleFeatureUpdated',
            FeatureDeleted::class => 'handleFeatureDeleted',
        ];
    }
}
