<?php

return [
    /*
    |--------------------------------------------------------------------------
    | iDoc Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where the documentation will be accessible from.
    | If the setting is null, iDoc will reside under the same domain as the
    | application. otherwise, this value will be used as the subdomain.
    |
     */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | iDoc Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where the documentation will be accessible from.
    | Feel free to change this path to anything you like.
    |
     */

    'path' => 'docs',

    /*
    |--------------------------------------------------------------------------
    | iDoc Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to the iDoc route, giving you
    | the chance to add your own or change the idoc middleware.
    |
     */

    'middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | iDoc logo url
    |--------------------------------------------------------------------------
    |
    | This is the logo configuration for the documentation. The logo expects
    | an absolute or relative url to a logo image while the color will
    | fill any space left depending on the log size.
    |
     */

    'logo' => '/docs.png',

    'color' => '',

    /*
    |--------------------------------------------------------------------------
    | iDoc Title / Description
    |--------------------------------------------------------------------------
    |
    | This is the title and description that will be visible on the
    | documentation.
    |
     */

    'title' => 'Maestro API Docs',

    'description' => file_get_contents(resource_path('views/vendor/idoc/partials/info.blade.php')),

    'version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | iDoc collection/output path
    |--------------------------------------------------------------------------
    |
    | The output path for the generated Open API 3.0 collection file.
    | This path is relative to the public path.
    |
    | In order To disable the  the open-api-3 download button
    | on the  documentation, the `hide_download_button`
    | option should be set to true.
    |
     */

    'output' => '',

    'hide_download_button' => false,

    /*
    |--------------------------------------------------------------------------
    | iDoc router
    |--------------------------------------------------------------------------
    |
    | The application's router.  (Laravel or Dingo).
    |
     */

    'router' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | iDoc servers
    |--------------------------------------------------------------------------
    |
    | The servers that should be added to the documentation. Each should have
    | a server hostname (and path if neccessary) and a discription of the
    | host. eg: one for test and another for production.
    |
     */

    'servers' => [
        [
            'url' => 'http://staging-maestro.v-labs.co',
            'description' => 'Maestro Staging',
        ],
        [
            'url' => 'https://maestro.v-labs.co',
            'description' => 'Production Server',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | iDoc languages tab.
    |--------------------------------------------------------------------------
    | Each tab is used to generate a request template for a given language.
    | New languages can be added and the existing ones modified after.
    |
    | You can add or edit new languages tabs by publishing the view files
    | and editing them or adding custom view files to:
    |
    |    'resources/views/vendor/idoc/languages/*.blade.php',
    |
    | where * is the name of the language you wish to add.
    |
    | Don't forget to add here too when done.
    |
     */

    'language-tabs' => [
        'bash' => 'Bash',
        'javascript' => 'Javascript',
        'php' => 'PHP'
    ],

    /*
    |--------------------------------------------------------------------------
    | iDoc routes: The routes for which documentation should be generated.
    |--------------------------------------------------------------------------
    | Each group contains rules defining which routes should be included
    | ('match', 'include' and 'exclude' sections) and rules which
    | should be applied to them ('apply' section).
    |
     */

    'routes' => [
        [
            /*
             * Specify conditions to determine what routes will be parsed in this group.
             * A route must fulfill ALL conditions to pass.
             */
            'match' => [

                /*
                 * Match only routes whose domains match this pattern (use * as a wildcard to match any characters).
                 */
                'domains' => [
                    '*',
                ],

                /*
                 * Match only routes whose paths match this pattern (use * as a wildcard to match any characters).
                 */
                'prefixes' => [
                    'api/*',
                ],

                /*
                 * Match only routes registered under this version. This option is ignored for Laravel router.
                 * Note that wildcards are not supported.
                 */
                'versions' => [
                    'v1',
                ],
            ],

            /*
             * Include these routes when generating documentation,
             * even if they did not match the rules above.
             * Note that the route must be referenced by name here (wildcards are supported).
             */
            'include' => [
                // 'users.index', 'healthcheck*'
            ],

            /*
             * Exclude these routes when generating documentation,
             * even if they matched the rules above.
             * Note that the route must be referenced by name here (wildcards are supported).
             */
            'exclude' => [
                'passport.*'
            ],

            /*
             * Specify rules to be applied to all the routes in this group when generating documentation
             */
            'apply' => [
                /*
                 * Specify headers to be added to the example requests
                 */
                'headers' => [
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJod',
                ],

                /*
                 * If no @response or @transformer declaratons are found for the route,
                 * we'll try to get a sample response by attempting an API call.
                 * Configure the settings for the API call here,
                 */
                'response_calls' => [
                    /*
                     * API calls will be made only for routes in this group matching these HTTP methods (GET, POST, etc).
                     * List the methods here or use '*' to mean all methods. Leave empty to disable API calls.
                     */
                    'methods' => ['*'],

                    /*
                     * For URLs which have parameters (/users/{user}, /orders/{id?}),
                     * specify what values the parameters should be replaced with.
                     * Note that you must specify the full parameter, including curly brackets and question marks if any.
                     */
                    'bindings' => [
                        // '{user}' => 1
                    ],

                    /*
                     * Environment variables which should be set for the API call.
                     * This is a good place to ensure that notifications, emails
                     * and other external services are not triggered during the documentation API calls
                     */
                    'env' => [
                        'APP_ENV' => 'documentation',
                        'APP_DEBUG' => false,
                        // 'env_var' => 'value',
                    ],

                    /*
                     * Headers which should be sent with the API call.
                     */
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer: {token}',
                    ],

                    /*
                     * Query parameters which should be sent with the API call.
                     */
                    'query' => [
                        // 'key' => 'value',
                    ],

                    /*
                     * Body parameters which should be sent with the API call.
                     */
                    'body' => [
                        // 'key' => 'value',
                    ],
                ],
            ],
        ],
    ],
];
