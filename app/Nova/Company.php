<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Outhebox\NovaHiddenField\HiddenField;
use Wemersonrv\InputMask\InputMask;

class Company extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Company';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'cnpj'
    ];

    public static function label()
    {
        return __('Empresas');
    }

    public static function icon(){
        return self::getIcon('map-pin');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->onlyOnForms(),
            Text::make('Nome', 'name')
                ->sortable()
                ->size('w-2/3')
                ->rules('required'),
            InputMask::make('CNPJ', 'cnpj')
                ->mask('##.###.###/####-##')
                ->raw()
                ->size('w-1/3')
                ->rules('required'),
            Text::make('E-mail', 'email')
                ->sortable()
                ->rules('required', 'email')
                ->size('w-1/3'),
            InputMask::make('Telefone', 'phone')
                ->size('w-1/3'),
            Place::make('Endereço', 'address')
                ->size('w-2/3')
                ->countries(['BR']),
            Text::make('Número', 'number')
                ->size('w-1/3'),
            Text::make('CEP', 'postal_code')
                ->size('w-1/3'),
            Text::make('Estado', 'state')
                ->size('w-1/3'),
            Text::make('Cidade', 'city')
                ->size('w-1/3'),
            HiddenField::make('latitude')->withMeta(['type' => 'hidden'])->onlyOnForms(),
            HiddenField::make('longitude')->withMeta(['type' => 'hidden'])->onlyOnForms(),
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
