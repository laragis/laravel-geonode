<?php

namespace TungTT\LaravelGeoNode\Models;

class LayersLayer extends GeoNode
{
    protected $table = 'layers_layer';

    protected $primaryKey = 'resourcebase_ptr_id';

    protected $fillable = [
        'title_en',
        'abstract_en',
        'purpose_en',
        'constraints_other_en',
        'supplemental_information_en',
        'data_quality_statement_en',
        'workspace',
        'store',
        'storeType',
        'name',
        'typename',
        'charset',
        'default_style_id',
        'upload_session_id',
        'elevation_regex',
        'has_elevation',
        'has_time',
        'is_mosaic',
        'time_regex',
        'remote_service_id',
        'featureinfo_custom_template',
        'use_featureinfo_custom_template',

    ];

    protected $casts = [

    ];
}
