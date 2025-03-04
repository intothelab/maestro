<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Document extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Document';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'number'
    ];

    public static function label()
    {
        return 'Documentos'; // TODO: Change the autogenerated stub
    }

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Transportadora', 'transporter', Transporter::class),
            BelongsTo::make('Cliente', 'customer', Customer::class),
            BelongsTo::make('Empresa', 'company', Company::class),
            BelongsTo::make('Pedido', 'order', Order::class),
            Text::make('Número', 'number'),
            Date::make('Data da Coleta','collected_at'),
            Date::make('Data da Entrega', 'delivered_at')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
